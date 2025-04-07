<?php

namespace App\Http\Requests\StockCard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStockCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stock_card_id' => 'required|numeric|exists:lims_stock_cards,id',
            'contract_no' => 'required|string',
            'iar_no' => 'required|string',
            'entity_name' => 'required|string',
            'supplier_name' => 'required|string',
            'supplier_address' => 'required|string',
            'procurement_mode' => 'required|numeric|in:1,2',
            'req_office' => 'required|numeric',
            'fund_source' => 'required|numeric|exists:lims_fund_sources,id',
    
            'stock_no' => 'required|string',
            'stock_name' => 'required|string',
            'item_description' => 'required|string',
            'dosage_form' => 'nullable|string',
            'dosage_strength' => 'nullable|string',
            'batch_no' => 'nullable|string',
            'measurement_unit' => 'required|numeric|exists:lims_measurements,id',
            'unit_cost' => 'required|numeric|notin:0',
            'quantity' => 'required|numeric|notin:0',
            'warehouse' => 'required|numeric|exists:lims_warehouses,id',
            'exp_date' => 'nullable|date',
            'category' => 'nullable|numeric|exists:lims_stock_card_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'unit_cost.required' => 'The unit cost is required.',
            'unit_cost.numeric' => 'The unit cost must be a number.',
            'unit_cost.notin' => 'The unit cost must be greater than 0.',
            'quantity.required' => 'The quantity is required.',
            'quantity.numeric' => 'The quantity must be a number.',
            'quantity.notin' => 'The quantity must be greater than 0.',
            'procurement_mode.required' => 'The procurement mode is required.',
            'procurement_mode.numeric' => 'The procurement mode must be a number.',
            'procurement_mode.in' => 'The procurement mode must be 1 or 2.',
        ];
    }
}
