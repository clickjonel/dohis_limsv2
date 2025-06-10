<?php

namespace App\Http\Controllers;

use App\DeliveryTrait;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\DeliveryItem;
use App\Models\DeliveryReceipts;
use App\Models\Measurement;
use App\Models\Property;
use App\Models\StockCard;
use App\Models\User;
use App\Models\Warehouse;
use App\UserTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use DeliveryTrait,UserTrait;

    public function getUserDashboardData(Request $request)
    {
    
        $user = User::with(['properties','deliveries.receipts','deliveries.items'])->find($request->user()->user_id);
        $user_deliveries = $user->deliveries()->orderBy('id','desc')->get()->map(function($delivery){
            return [
                'id' => $delivery->id,
                'source' => $delivery->source_name,
                'receipts' => $delivery->receipts,
                'items' => $delivery->items->map(function($item){
                    $item['measurement_unit'] = $item->measurementUnit->name;
                    return $item;
                })
            ];
        });
        // $user_section_stock_cards = StockCard::with('transactions')->where('req_office',$user->assignment->section_id);

        $user_section_stock_cards = StockCard::with('transactions')->where('req_office',$user->assignment->section_id)->get()->map(function($stock_card){
            if($stock_card->latestTransaction()->balance === $stock_card->quantity){
                $stock_card['status'] = 'For Allocation';

            }
            else if($stock_card->latestTransaction()->balance < $stock_card->quantity && $stock_card->latestTransaction()->balance > 0){
                $stock_card['status'] = 'Allocating';
            }
            else if($stock_card->latestTransaction()->balance === 0){
                $stock_card['status'] = 'Allocated';
            }
            else{
                $stock_card['status'] = 'Unknown';
            }

            return $stock_card;
        });

        $user_delivery_receipts = DeliveryReceipts::whereIn('id',$user->deliveries->pluck('id'))->whereYear('delivery_date',Carbon::now()->year)->get();
        
        $data = [
            'deliveries' => [
                'list' => $user_deliveries,
                'total' => $user->deliveries->load('items')->count(),
                'charge' => $user->deliveries->where('payment_term',1)->count(),
                'donation' => $user->deliveries->where('payment_term',2)->count(),
                'chart' =>  $this->getDeliveryTotalByMonth($user_delivery_receipts)
            ],
            'stocks' => [
                'list' => $user_section_stock_cards,
                'total' => $user_section_stock_cards->count(),
                'series' =>  $user_section_stock_cards->groupBy('status')->map(function($stock_cards){
                    return $stock_cards->count();
                }),
            ],
            'properties' => [
                'list' => $user->properties->map(function($property_user){
                    $property = Property::find($property_user->property_id);
                    return [
                        'property' => $property,
                        'user' => $this->getUserFullName($property_user->user_id),
                        'measurement_unit' => Measurement::find($property->measurement_unit)->name,
                        'acquisition_date' => $property_user->issuance_date
                    ];
                }),
                'total' => $user->properties->count(),
                'series' => [
                    Property::whereIn('id', $user->properties()->pluck('property_id'))->where('status','Stock')->count(),
                    Property::whereIn('id', $user->properties()->pluck('property_id'))->where('status','Active')->count(),
                    Property::whereIn('id', $user->properties()->pluck('property_id'))->where('status','Waste')->count()
                ],
                'test' => Property::all()->groupBy('status')
                ],
               

        ];

 
        return response()->json([
            'data' => $data, 
        ]);
    }

    public function fetchPermanentUserDashboardData(Request $request):JsonResponse
    {
        $deliveriesCollection = Delivery::where('end_user',$request->user()->user_id)->get();
        $deliveries = [
            'total' => $deliveriesCollection->count(),
            'procured' => $deliveriesCollection->where('payment_term',1)->count(),
            'donated' => $deliveriesCollection->where('payment_term',2)->count(),
            'this_month' => $deliveriesCollection->filter(function ($delivery) {
                                return $delivery->receipts()->whereMonth('delivery_date', Carbon::now()->month)
                                                ->whereYear('delivery_date', Carbon::now()->year)
                                                ->exists();
            })->count(),
            'this_week' => $deliveriesCollection->filter(function ($delivery) {
                return $delivery->receipts()->whereBetween('delivery_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                            ->exists();
            })->count(),
        ];

        $stockCollection = StockCard::where('req_office', $request->user()->assignment->section_id)
                            ->get()
                            ->map(function($stock_card) {
                                $balance = $stock_card->latestTransaction()->balance;
                                $stock_card->balance = $balance;
                                return $stock_card;
                            });

        $stocks = [
            'total' => $stockCollection->count(),
            'allocated' => $stockCollection->filter(function($stock_card) {
                                return $stock_card->balance === 0;
                            })->count(),
            'allocating' =>  $stockCollection->filter(function($stock_card) {
                                    return $stock_card->balance > 0 && $stock_card->balance < $stock_card->quantity;
                                })->count(),
            'to_allocate' =>  $stockCollection->filter(function($stock_card) {
                                    return $stock_card->balance === $stock_card->quantity;
                                })->count(),
        ];

        $properties = Property::whereHas('user', function($query) use ($request) {
            $query->where('user_id', $request->user()->user_id);
        })->get();

        return response()->json([
            'delivery' => $deliveries,
            'stock' => $stocks,
            'properties' => $properties
        ]);
    }

    public function fetchSupplyDashboardDetails(Request $request):JsonResponse
    {
        $property_categories = Category::withCount('properties')->withSum('properties', 'unit_cost')->get();
        $counts = [
            'properties' => Property::count(),
            'deliveries' => Delivery::count(),
            'stocks' => StockCard::count() 
        ];

        return response()->json([
            'property_categories' => $property_categories,
            'counts' => $counts

        ],200);
    }


    public function fetchDeliveryByMonth()
    {
        $months = collect(range(1, 12))->mapWithKeys(function ($monthNumber) {
            $count = Delivery::whereHas('receipts', function($query) use ($monthNumber) {
                $query->whereYear('delivery_date', Carbon::now()->year)
                        ->whereMonth('delivery_date', $monthNumber);
            })->count();

            return [
                Carbon::create()->month($monthNumber)->format('F') => $count
            ];
        });

        return $months;
    }

    public function fetchStockCardByStatus(){

    }


}
