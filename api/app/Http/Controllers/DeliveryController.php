<?php

namespace App\Http\Controllers;

use App\Http\Requests\Delivery\CreateDeliveryInvoiceRequest;
use App\Http\Requests\Delivery\CreateDeliveryItemRequest;
use App\Http\Requests\Delivery\CreateDeliveryReceiptRequest;
use App\Http\Requests\Delivery\CreateDeliveryRequest;
use App\Http\Requests\Delivery\DeleteDeliveryInvoiceRequest;
use App\Http\Requests\Delivery\DeleteDeliveryItemRequest;
use App\Http\Requests\Delivery\DeleteDeliveryReceiptRequest;
use App\Http\Requests\Delivery\UpdateDeliveryInvoiceRequest;
use App\Http\Requests\Delivery\UpdateDeliveryItemRequest;
use App\Http\Requests\Delivery\UpdateDeliveryReceiptRequest;
use App\Http\Requests\Delivery\UpdateDeliveryRequest;
use App\Http\Requests\Delivery\ValidateDeliveryItemsRequest;
use App\Http\Requests\FetchIARsRequest;
use App\Models\Delivery;
use App\Models\DeliveryInvoice;
use App\Models\DeliveryItem;
use App\Models\DeliveryReceipts;
use App\Models\FundSource;
use App\Models\Measurement;
use App\Models\Office;
use App\Models\User;
use App\OfficeTrait;
use App\UserTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    use UserTrait,OfficeTrait;

    public function create(CreateDeliveryRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $validated['hashid'] = sha1($validated['iar_no']);

        DB::beginTransaction();

        try {
            // create the delivery
            $delivery = Delivery::create($validated);

            // create the delivery invoices
            if(!empty($validated['invoices'])){
               $invoices = collect($validated['invoices']);

               $invoices->each(function($invoice) use ($delivery) {
                    $invoice['delivery_id'] = $delivery->id;
                    DeliveryInvoice::create($invoice);
               });
            }

             // create the delivery receipts
             $receipts = collect($validated['delivery_receipts']);
             $receipts->each(function($receipt) use ($delivery){
                    DeliveryReceipts::create([
                        'delivery_id' => $delivery->id,
                        'dr_no' => $receipt['delivery_receipt_no'],
                        'dr_date' => $receipt['delivery_receipt_date'],
                        'delivery_place' => $receipt['delivery_place'],
                        'delivery_date' => $receipt['delivery_date'],
                    ]);
             });

            // create the deliveryitems
            $items = collect($validated['items']);
            $items->each(function($item) use ($delivery){
                $item['delivery_id'] = $delivery->id;
                DeliveryItem::create([
                    'delivery_id' => $delivery->id,
                    'availability' => $item['availability'],
                    'manufacturer' => $item['manufacturer'],
                    'manufacturing_date' => $item['manufacturing_date'],
                    'expiry_date' => $item['expiry_date'],
                    'unit_cost' => $item['unit_cost'],
                    'quantity' => $item['quantity'],
                    'batch_lot_number' => $item['batch_lot_number'],
                    'shelf_life' => $item['shelf_life'],
                    'measurement_unit' => $item['measurement_unit'],
                    'description' => $item['description'],
                ]);
            });

            DB::commit();

            return response()->json([
                'message' => 'Delivery is saved successfully',
                'delivery' => $delivery
            ], 200);
        } 

        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to save delivery',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function validateDeliveryItems(ValidateDeliveryItemsRequest $request):JsonResponse
    {
        $validated = $request->validated();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Validated Items'
        ]);
    }

    public function list(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        // $offset = ($page - 1) * 15;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        // $total = Delivery::count();

        $baseQuery = Delivery::with(['invoices','receipts','items.measurementUnit'])
                        ->when($search_keyword, function ($query) use ($search_keyword) {
                            $query->where('iar_no', 'like', '%' . $search_keyword . '%');
                        })->orderBy('id','DESC');

        $deliveries = $baseQuery->clone()
        ->offset(($page - 1) * $perPage)
        ->limit($perPage)
        ->get();

        $total = $baseQuery->count();

        return response()->json([
            'deliveries' => $deliveries->map(function($delivery){

                $delivery['req_office'] = Office::find($delivery['req_office'])->short_name;
                $delivery['end_user'] = $this->getUserFullName($delivery['end_user']);
                $delivery['payment_term'] = $delivery['payment_term'] === 1 ? 'Charge' : 'Donation';
                return $delivery;
            }),
            'total' => $total
        ]);
    }

    public function generateDeliveryIAR(Request $request)
    {

        $delivery = Delivery::find($request->id);

        $delivery['invoice_nos'] = $delivery->invoices->pluck('invoice_no')->implode(', ');
        $delivery['invoice_dates'] = $delivery->invoices->pluck('invoice_date')->implode(', ');

        $delivery['dr_nos'] = $delivery->receipts->pluck('dr_no')->implode(', ');
        $delivery['dr_dates'] = $delivery->receipts->pluck('dr_date')->implode(', ');
        $delivery['delivery_places'] = $delivery->receipts->pluck('delivery_place')->implode(', ');
        $delivery['delivery_dates'] = $delivery->receipts->pluck('delivery_date')->implode(', ');

        $delivery['po_total_amount'] = $delivery->items->sum(fn($item) => $item['quantity'] * $item['unit_cost']);
        $delivery['po_quantity'] = $delivery->items->map(function($item){
            $measurement_unit = $item->measurementUnit->name;
            return "{$item['quantity']} {$measurement_unit}";
        })->implode(', ');

        $delivery['inspected_quantity'] = $delivery->items->where('is_balance',0)->map(function($item){
            $measurement_unit = $item->measurementUnit->name;
            return "{$item['quantity']} {$measurement_unit}";
        })->implode(', ');
        $delivery['inspected_amount'] = $delivery->items->where('is_balance',0)->sum(fn($item) => $item['quantity'] * $item['unit_cost']);

        $delivery['delivered'] = $delivery->items->where('is_balance',0);
        $delivery['balance'] = $delivery->items->where('is_balance',1);

        $delivery->end_user= [
            'user_id' => $delivery['end_user'],
            'user_name' => $this->getUserFullName($delivery['end_user']),
            'user_position' => $this->getUserPosition($delivery['end_user'])
        ];


        return response()->json([
            'delivery' => $delivery
        ]);
    }

    public function fetchDelivery(Request $request)
    {

        $delivery = Delivery::with(['items.measurementUnit','invoices','receipts'])->find($request->id);
        $delivery->fund_source = FundSource::find($delivery['fund_source']);

        $office = Office::find($delivery['req_office']);
        $user = User::find($delivery['end_user']);

        $delivery->office = [
            'section_id' => $office->section_id,
            'section_name' => $office->section_name,
            'personnel' => $this->fetchOfficePersonnel($office->section_id)
        ];

        $delivery->end_user = [
            'user_id' => $user->user_id,
            'full_name' => $this->getUserFullName($user->user_id)
        ];
        

        return response()->json([
            'delivery' => $delivery
        ]);
    }

    public function saveInvoice(CreateDeliveryInvoiceRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $invoice = DeliveryInvoice::create($validated);

        return response()->json([
            'invoice' => $invoice
        ]);
    }

    public function updateInvoice(UpdateDeliveryInvoiceRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $invoice = DeliveryInvoice::find($validated['id'])->update([
            'invoice_no' => $validated['invoice_no'],
            'invoice_date' => $validated['invoice_date']
        ]);
        $invoice = DeliveryInvoice::find($validated['id']);

        return response()->json([
            'invoice' => $invoice
        ]);
    }

    public function deleteInvoice(DeleteDeliveryInvoiceRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $invoice = DeliveryInvoice::find($validated['id'])->delete();

        return response()->json([
            'status' => $invoice
        ]);
    }

    public function saveReceipt(CreateDeliveryReceiptRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $receipt = DeliveryReceipts::create($validated);

        return response()->json([
            'receipt' => $receipt
        ]);
    }

    public function updateReceipt(UpdateDeliveryReceiptRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $receipt = DeliveryReceipts::find($validated['id'])->update([
            'dr_no' => $validated['dr_no'],
            'dr_date' => $validated['dr_date'],
            'delivery_place' => $validated['delivery_place'],
            'delivery_date' => $validated['delivery_date']
        ]);
        $receipt = DeliveryReceipts::find($validated['id']);

        return response()->json([
            'receipt' => $receipt
        ]);
    }

    public function deleteReceipt(DeleteDeliveryReceiptRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $invoice = DeliveryReceipts::find($validated['id'])->delete();

        return response()->json([
            'status' => $invoice
        ]);
    }
    
    public function saveItem(CreateDeliveryItemRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $item = DeliveryItem::create([
            'delivery_id' => $validated['delivery_id'],
            'availability' => $validated['availability'],
            'manufacturer' => $validated['manufacturer'] ?? null,
            'manufacturing_date' => $validated['manufacturing_date'] ?? null,
            'expiry_date'  => $validated['expiry_date'] ?? null,
            'unit_cost' => $validated['unit_cost'],
            'quantity' => $validated['quantity'],
            'batch_lot_number' => $validated['batch_lot_number'],
            'shel_life' => $validated['shelf_life'],
            'measurement_unit' => $validated['measurement_unit'],
            'description' => $validated['description']
        ]);

        return response()->json([
            'item' => $item->with('measurementUnit')
        ]);
    }

    public function updateItem(UpdateDeliveryItemRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $item = DeliveryItem::find($validated['id'])->update([
            'availability' => $validated['availability'],
            'manufacturer' => $validated['manufacturer'] ?? null,
            'manufacturing_date' => $validated['manufacturing_date'] ?? null,
            'expiry_date'  => $validated['expiry_date'] ?? null,
            'unit_cost' => $validated['unit_cost'],
            'quantity' => $validated['quantity'],
            'batch_lot_number' => $validated['batch_lot_number'],
            'shelf_life' => $validated['shelf_life'],
            'measurement_unit' => $validated['measurement_unit'],
            'description' => $validated['description']
        ]);

        return response()->json([
            'status' => $item
        ]);
    }

    public function deleteItem(DeleteDeliveryItemRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $item = DeliveryItem::find($validated['id'])->delete();

        return response()->json([
            'status' => $item
        ]);
    }

    public function update(UpdateDeliveryRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $delivery = Delivery::find($validated['id'])->update([
            'entity_name' => $validated['entity_name'],
            'fund_source' => $validated['fund_source'],
            'source_name' => $validated['source_name'],
            'source_address' => $validated['source_address'],
            'iar_no' => $validated['iar_no'],
            'iar_date' => $validated['iar_date'],
            'po_no' => $validated['po_no'],
            'po_date' => $validated['po_date'],
            'ptr_no' => $validated['ptr_no'],
            'ptr_date' => $validated['ptr_date'],
            'bl_no' => $validated['bl_no'],
            'bl_date' => $validated['bl_date'],
            'dnf_no' => $validated['dnf_no'],
            'dnf_date' => $validated['dnf_date'],
            'req_office' => $validated['req_office'],
            'end_user' => $validated['end_user'],
            'payment_term' => $validated['payment_term'],
            'completion' => $validated['completion'],
            'purpose' => $validated['purpose'],
        ]);

        return response()->json([
            'status' => $delivery
        ]);
    }

    public function checkIARExists(Request $request):JsonResponse //for notice of delivery
    {
        $delivery = Delivery::where('iar_no',$request->iar_no)->first();

        $items = $delivery->items->where('availability',1)->map(function($item) use ($delivery){
            $item['measurement_unit'] = $item->measurementUnit->name;
            $item['contract_no'] = $delivery->payment_term === 1 ? $delivery->po_no : $delivery->ptr_no;
            $item['contract_date'] = $delivery->payment_term === 1 ? $delivery->po_date : $delivery->ptr_date;
            $item['dr_nos'] = $delivery->receipts->pluck('dr_no')->implode('<br> ');
            $item['invoice_nos'] = $delivery->invoices->pluck('invoice_no')->implode('<br> ');
            $item['invoice_dates'] = $delivery->invoices->pluck('invoice_date')->implode('<br> ');
            $item['dr_dates'] = $delivery->receipts->pluck('dr_date')->implode('<br> ');
            $item['delivery_dates'] = $delivery->receipts->map(function($receipt) use ($delivery){
                return $delivery->iar_no . ' => ' . Carbon::parse($receipt->delivery_date)->format('d/m/y');
            })->implode('<br>');
            $item['source_name'] = $delivery->source_name;
            $item['source_address'] = $delivery->source_address;
            $item['dr_si_nos'] = trim(implode(', ', array_filter([$item['dr_nos'], $item['invoice_nos']])));
            $item['dr_si_dates'] = trim(implode(', ', array_filter([$item['dr_dates'], $item['invoice_dates']])));
            return $item;
        });

        return response()->json([
            'status' => $delivery ? true : false,
            'delivery' => $items
        ]);
    }

    public function findDeliveryByIAR(Request $request):JsonResponse //for stock card
    {
        $delivery = Delivery::where('iar_no',$request->iar_no)->first();

        $delivery['req_office'] = $this->findOffice($delivery['req_office']);
        $delivery['end_user'] = [
            'user_id' => $delivery['end_user'],
            'full_name' => $this->getUserFullName($delivery['end_user'])
        ];
        $delivery['fund_source'] = FundSource::find($delivery['fund_source']);

        return response()->json([
            'delivery' => $delivery
        ]);
    }

    public function fetchIARGenerationDetails(Request $request):JsonResponse
    {
        $delivery = Delivery::with(['items','invoices','receipts'])->find($request->id)->toArray();
        $delivery['req_office'] = $this->findOffice($delivery['req_office']);
        $delivery['payment_term'] = $delivery['payment_term'] === 1 ? 'Charge' : 'Donation';

        $delivery['total_procured'] = array_sum(array_map(function ($item) {
            return $item['quantity'];
        }, $delivery['items'] ?? []));

        $delivery['amount_procured'] = array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['unit_cost'];
        }, $delivery['items'] ?? []));

        $delivery['delivered_items'] = collect(array_filter($delivery['items'], function ($item) {
            return $item['availability'] === 1;
        }))->map(function($item){
            $item['measurement_unit'] = Measurement::find($item['measurement_unit'])->name;
            return $item;
        })->toArray();

        $delivery['balance_items'] = collect(array_filter($delivery['items'], function ($item) {
            return $item['availability'] === 0;
        }))->map(function($item){
            $item['measurement_unit'] = Measurement::find($item['measurement_unit'])->name;
            return $item;
        })->toArray();

        $delivery['inspected_quantity'] = array_sum(array_map(function ($item) {
            return $item['quantity'];
        }, $delivery['delivered_items'] ?? []));

        $delivery['inspected_amount'] = array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['unit_cost'];
        }, $delivery['delivered_items'] ?? []));

        $delivery['fund_source'] = FundSource::find($delivery['fund_source'])->name;

        $delivery['invoice_nos'] = implode(', ', array_map(function ($invoice) {
            return $invoice['invoice_no'];
        }, $delivery['invoices'] ?? []));

        $delivery['invoice_dates'] = implode(', ', array_map(function ($invoice) {
            return $invoice['invoice_date'];
        }, $delivery['invoices'] ?? []));

        $delivery['dr_nos'] = implode(', ', array_map(function ($receipt) {
            return $receipt['dr_no'];
        }, $delivery['receipts'] ?? []));

        $delivery['dr_dates'] = implode(', ', array_map(function ($receipt) {
            return $receipt['dr_date'];
        }, $delivery['receipts'] ?? []));

        $delivery['delivery_dates'] = implode(', ', array_map(function ($receipt) {
            return $receipt['delivery_date'];
        }, $delivery['receipts'] ?? []));

        $delivery['delivery_places'] = implode(', ', array_map(function ($receipt) {
            return $receipt['delivery_place'];
        }, $delivery['receipts'] ?? []));

        $delivery['measurement_units'] = implode(', ', array_map(function ($receipt) {
            return Measurement::find($receipt['measurement_unit'])->name;
        }, $delivery['items'] ?? []));

        $delivery['unit_costs'] = implode(', ', array_map(function ($receipt) {
            return $receipt['unit_cost'];
        }, $delivery['items'] ?? []));

        $delivery['end_user'] = [
            'user_name' => $this->getUserFullName($delivery['end_user']),
            'user_position' => $this->getUserPosition($delivery['end_user'])
        ];

        return response()->json([
            'delivery' => $delivery
        ]);
    }

    // public function getInvalidCostDeliveryItems()
    // {
    //     return response()->json([
    //         'items' => DeliveryItem::where('unit_cost',0)->with(['delivery','measurementUnit'])->get()
    //     ]);
    // }

    public function fetchUserDeliveries(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        // $offset = ($page - 1) * 15;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        // $total = Delivery::count();

        $baseQuery = Delivery::with(['invoices','receipts','items.measurementUnit'])
                        ->where('end_user',$request->user()->user_id)
                        ->when($search_keyword, function ($query) use ($search_keyword) {
                            $query->where('iar_no', 'like', '%' . $search_keyword . '%');
                        })->orderBy('id','DESC');

        $deliveries = $baseQuery->clone()
        ->offset(($page - 1) * $perPage)
        ->limit($perPage)
        ->get();

        $total = $baseQuery->count();

        return response()->json([
            'deliveries' => $deliveries->map(function($delivery){

                $delivery['req_office'] = Office::find($delivery['req_office'])->short_name;
                $delivery['end_user'] = $this->getUserFullName($delivery['end_user']);
                $delivery['payment_term'] = $delivery['payment_term'] === 1 ? 'Charge' : 'Donation';
                return $delivery;
            }),
            'total' => $total
        ]);
    }

    public function fetchDeliveryItem(Request $request):JsonResponse
    {
        $item = DeliveryItem::with(['delivery','measurementUnit'])->find($request->id);

        // End User of the Item Delivery
        $item->end_user = User::find($item->delivery['end_user']);
        $item->end_user['full_name'] =$this->getUserFullName($item->end_user['user_id']);
        $item->end_user['position'] =$this->getUserPosition($item->end_user['user_id']);

        // recommending approval
        $item->recommending_approval = [
            'full_name' => $this->getUserDivisionChief($item->end_user['user_id']),
        ];

        return response()->json([
            'item' => $item
        ]);
    }

}



