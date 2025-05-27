<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FundSourceController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PreinspectionRequestController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\StockCardCategoryController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Models\Delivery;
use App\Models\PreinspectionRequest;
use App\Models\StockCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// Authentication Routes
Route::post('/login',[AuthenticationController::class,'login']);
Route::post('/logout',[AuthenticationController::class,'logout'])->middleware('auth:sanctum');

// Warehouse Routes
Route::get('/warehouse/list',[WarehouseController::class,'list'])->middleware('auth:sanctum');

// Measurement Routes
Route::get('/measurement/list',[MeasurementController::class,'list'])->middleware('auth:sanctum');
Route::get('/measurement/selection',[MeasurementController::class,'measurementSelectionList'])->middleware('auth:sanctum');

// Fund Source Routes
Route::get('/fund_source/list',[FundSourceController::class,'list'])->middleware('auth:sanctum');

// Office Routes
Route::get('/office/list',[OfficeController::class,'list'])->middleware('auth:sanctum');
Route::get('/office/selection',[OfficeController::class,'selection'])->middleware('auth:sanctum');

// Division Routes
Route::get('/division/selection',[DivisionController::class,'selection'])->middleware('auth:sanctum');

// Stock Card Category Routes
Route::get('/stock_card_category/list',[StockCardCategoryController::class,'list'])->middleware('auth:sanctum');

// Delivery Routes
Route::post('/delivery/create',[DeliveryController::class,'create'])->middleware('auth:sanctum');
Route::post('/delivery/update',[DeliveryController::class,'update'])->middleware('auth:sanctum');
Route::post('/delivery/validate/items',[DeliveryController::class,'validateDeliveryItems'])->middleware('auth:sanctum');
Route::get('/delivery/list',[DeliveryController::class,'list'])->middleware('auth:sanctum');
Route::get('/delivery/user',[DeliveryController::class,'fetchUserDeliveries'])->middleware('auth:sanctum');
// Route::get('/delivery/generate/iar',[DeliveryController::class,'generateDeliveryIAR'])->middleware('auth:sanctum');
Route::get('/delivery/find',[DeliveryController::class,'fetchDelivery'])->middleware('auth:sanctum');
Route::get('/delivery/generate/iar',[DeliveryController::class,'fetchIARGenerationDetails'])->middleware('auth:sanctum');

Route::post('/delivery/create/invoice',[DeliveryController::class,'saveInvoice'])->middleware('auth:sanctum');
Route::post('/delivery/update/invoice',[DeliveryController::class,'updateInvoice'])->middleware('auth:sanctum');
Route::delete('/delivery/delete/invoice',[DeliveryController::class,'deleteInvoice'])->middleware('auth:sanctum');

Route::post('/delivery/create/receipt',[DeliveryController::class,'saveReceipt'])->middleware('auth:sanctum');
Route::post('/delivery/update/receipt',[DeliveryController::class,'updateReceipt'])->middleware('auth:sanctum');
Route::delete('/delivery/delete/receipt',[DeliveryController::class,'deleteReceipt'])->middleware('auth:sanctum');

Route::post('/delivery/create/item',[DeliveryController::class,'saveItem'])->middleware('auth:sanctum');
Route::post('/delivery/update/item',[DeliveryController::class,'updateItem'])->middleware('auth:sanctum');
Route::delete('/delivery/delete/item',[DeliveryController::class,'deleteItem'])->middleware('auth:sanctum');

Route::get('/delivery/exists/iar',[DeliveryController::class,'checkIARExists'])->middleware('auth:sanctum');
Route::get('/delivery/item/find',[DeliveryController::class,'fetchDeliveryItem'])->middleware('auth:sanctum');
// Route::get('/delivery/item/invalid_cost',[DeliveryController::class,'getInvalidCostDeliveryItems'])->middleware('auth:sanctum');
// Route::get('/delivery/find/iar',[DeliveryController::class,'findDeliveryByIAR'])->middleware('auth:sanctum');

// delivery route group
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'deliveries',
], function () {
    Route::get('/list', [DeliveryController::class, 'fetchDeliveriesForDeliveriesPage']);
    Route::get('/list/user', [DeliveryController::class, 'fetchDeliveriesForUserDeliveriesPage']);
    Route::get('/find/id', [DeliveryController::class, 'fetchDeliveryForViewDeliveryPage']);
});


// Stock Card Routes
Route::get('/stock_card/list',[StockCardController::class,'list'])->middleware('auth:sanctum');
Route::get('/stock_card/find',[StockCardController::class,'find'])->middleware('auth:sanctum');
Route::post('/stock_card/create',[StockCardController::class,'create'])->middleware('auth:sanctum');
Route::get('/stock_card/generate/stock_card',[StockCardController::class,'fetchStockCardGenerationDetails'])->middleware('auth:sanctum');
Route::post('/stock_card/transaction/issue',[StockCardController::class,'issue'])->middleware('auth:sanctum');
Route::get('/stock_card/user',[StockCardController::class,'fetchUserSectionStockCards'])->middleware('auth:sanctum');

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'stocks',
], function () {
    Route::get('/list', [StockCardController::class, 'fetchStockCardsForStocksPage']);
    Route::get('/list/section', [StockCardController::class, 'fetchStockCardsForSectionStocksPage']);
    Route::get('/fetch/update', [StockCardController::class, 'fetchStockCardForUpdatePage']);
    Route::post('/update',[StockCardController::class,'update']);
});

// Property Routes
Route::get('/property/list',[PropertyController::class,'list'])->middleware('auth:sanctum');
Route::get('/property/user',[PropertyController::class,'fetchUserProperties'])->middleware('auth:sanctum');
Route::get('/property/user/selection',[PropertyController::class,'fetchUserPropertiesSelection'])->middleware('auth:sanctum');
Route::get('/property/find',[PropertyController::class,'fetchProperty'])->middleware('auth:sanctum');
Route::get('/property/statuses',[PropertyController::class,'fetchPropertyStatuses'])->middleware('auth:sanctum');
Route::post('/property/update',[PropertyController::class,'updateProperty'])->middleware('auth:sanctum');
Route::get('/properties/find',[PropertyController::class,'findProperties'])->middleware('auth:sanctum');
Route::get('/property/find/property_number',[PropertyController::class,'findPropertyByPropertyNumber'])->middleware('auth:sanctum');
Route::post('/property/transfer',[PropertyController::class,'transferProperties'])->middleware('auth:sanctum');
Route::get('property/inventory/user/find',[PropertyController::class,'fetchInventoryUserPropertyReport'])->middleware('auth:sanctum');

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'properties',
], function () {
    Route::get('/list', [PropertyController::class, 'fetchPropertiesForPropertiesPage']);
    Route::get('/list/user', [PropertyController::class, 'fetchPropertiesUserForPropertiesPage']);
    Route::post('/create',[PropertyController::class,'create'])->middleware('auth:sanctum');
});


// User Routes
Route::get('/user/data',[UserController::class,'getUserData'])->middleware('auth:sanctum');
Route::get('/user/selection',[UserController::class,'userSelectionList'])->middleware('auth:sanctum');

// Dashboard Routes
// Route::get('/dashboard/user',[DashboardController::class,'getUserDashboardData'])->middleware('auth:sanctum');
Route::get('/dashboard/user',[DashboardController::class,'fetchPermanentUserDashboardData'])->middleware('auth:sanctum');
Route::get('/dashboard',[DashboardController::class,'fetchSupplyDashboardDetails'])->middleware('auth:sanctum');


// Preinspection Request Routes
Route::get('/preinspection_request/list',[PreinspectionRequestController::class,'list'])->middleware('auth:sanctum');
Route::post('/preinspection_request/create',[PreinspectionRequestController::class,'createRequest'])->middleware('auth:sanctum');
Route::get('/preinspection_request/list/user',[PreinspectionRequestController::class,'listUserRequests'])->middleware('auth:sanctum');
Route::post('/preinspection_request/action',[PreinspectionRequestController::class,'actionPreinspectionRequest'])->middleware('auth:sanctum');

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'preinspection_requests',
], function () {
    Route::get('/list', [PreinspectionRequestController::class, 'fetchPreinspectionRequestsforPreinspectionListPage']);
    Route::get('/list/user', [PreinspectionRequestController::class, 'fetchUserPreinspectionRequestsforPreinspectionListPage']);
});