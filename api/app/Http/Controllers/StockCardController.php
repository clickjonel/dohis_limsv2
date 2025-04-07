<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockCard\CreateStockCardRequest;
use App\Http\Requests\StockCard\IssueStockRequest;
use App\Http\Requests\StockCard\UpdateStockCardRequest;
use App\Http\Requests\UpdateStockCard;
use App\Models\FundSource;
use App\Models\Measurement;
use App\Models\Office;
use App\Models\StockCard;
use App\Models\StockCardCategory;
use App\Models\StockCardTransaction;
use App\Models\Warehouse;
use App\OfficeTrait;
use App\UserTrait;
use App\WarehouseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    use UserTrait,WarehouseTrait,OfficeTrait;

    public function list(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        // $offset = ($page - 1) * 15;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $baseQuery = StockCard::with(['transactions'])
        ->when($search_keyword, function ($query) use ($search_keyword) {
            $query->where('stock_no', 'like', '%' . $search_keyword . '%');
        })->orderBy('id','DESC');

        $stock_cards = $baseQuery->clone()
        ->offset(($page - 1) * $perPage)
        ->limit($perPage)
        ->get()
        ->map(function($stock_card){
            $stock_card['req_office'] = $this->findOffice($stock_card['req_office'])->section_name;
            $stock_card['warehouse'] = $this->getWarehouseName($stock_card['warehouse']);
            $stock_card['remaining'] = $stock_card->transactions()->latest('id')->first()->balance;

            return $stock_card;
        });

        $total = $baseQuery->count();

        return response()->json([
            'stock_cards' => $stock_cards,
            'total' => $total
        ]);
    }

    public function create(CreateStockCardRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $stock_card = StockCard::create($validated);

        $transaction = StockCardTransaction::create([
            'stock_card_id' => $stock_card->id,
            'transaction_date' => Carbon::now(),
            'received' => $stock_card->quantity,
            'issued' => null,
            'balance' => $stock_card->quantity,
            'total_cost' => (float) $stock_card->quantity * $stock_card->umit_cost,
            'ptr_no' => null,
            'iar_no' => $stock_card->iar_no,
            'recepient' => 'DOH-CHD-CAR',
            'remarks' => null
        ]);

        return response()->json([
            'message' => $stock_card
        ]);
    }

    public function find(Request $request):JsonResponse
    {
        $stock_card = StockCard::find($request->id);
        $stock_card->req_office = [
            'section_id' => $stock_card->req_office,
            'section_name' => $this->findOffice($stock_card->req_office)->section_name,
            'personnel' => $this->fetchOfficePersonnel($stock_card->req_office)
        ];

        $stock_card->fund_source = FundSource::find($stock_card->fund_cluster);
        $stock_card->warehouse = Warehouse::find($stock_card->warehouse);
        $stock_card->measurement_unit = Measurement::find($stock_card->measurement_unit);
        $stock_card->category = StockCardCategory::find($stock_card->category);


        return response()->json([
            'stock_card' => $stock_card
        ]);
    }

    public function update(UpdateStockCardRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $stock_card = StockCard::find($validated['stock_card_id'])->update($validated);

        return response()->json([
            'status' => $stock_card
        ]);
    }

    public function fetchStockCardGenerationDetails(Request $request):JsonResponse
    {
       $stock_card = StockCard::with('transactions')->find($request->stock_card_id)->toArray();
       $stock_card['fund_cluster'] = FundSource::find($stock_card['fund_cluster'])->name;
       $stock_card['procurement_mode'] = $stock_card['procurement_mode'] === 1 ? 'Charge' : 'Donation';
       $stock_card['measurement_unit'] = Measurement::find($stock_card['measurement_unit'])->name;
       $stock_card['req_office'] = $this->findOffice($stock_card['req_office'])->section_name;

        return response()->json([
            'stock_card' => $stock_card
        ]);
    }

    public function issue(IssueStockRequest $request):JsonResponse
    {
        $validated = $request->validated();

        // Find the stock card
        $stock_card = StockCard::find($validated['stock_card_id']);
    
        if (!$stock_card) {
            return response()->json(['error' => 'Stock card not found'], 404);
        }
    
        // Retrieve the maximum transaction ID
        $maxTransactionId = $stock_card->transactions()->max('id');
    
        // Fetch the transaction with the maximum ID
        $lastTransaction = $stock_card->transactions()->find($maxTransactionId);
    
        if (!$lastTransaction) {
            return response()->json(['error' => 'No transactions found for this stock card'], 400);
        }
    
        // Calculate the new balance
        $newBalance = $lastTransaction->balance - $validated['issued'];
    
        // Create a new transaction
        $stock_card->transactions()->create([
            'stock_card_id' => $validated['stock_card_id'],
            'transaction_date' => $validated['transaction_date'],
            'received' => null,
            'issued' => $validated['issued'],
            'balance' => $newBalance,
            'total_cost' => $validated['issued'] * $stock_card->unit_cost,
            'ptr_no' => $validated['ptr_no'],
            'iar_no' => null,
            'recepient' => $validated['recepient'],
            'remarks' => $validated['remarks'] ?? null
        ]);
    
        return response()->json(['stock_card' => $stock_card]);
    }
}
