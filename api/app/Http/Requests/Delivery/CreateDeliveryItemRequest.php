<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateDeliveryItemRequest extends FormRequest
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
            'delivery_id' => 'required|numeric|exists:lims_deliveries,id',
            'availability' => 'required|numeric',
            'manufacturer' => 'nullable|string',
            'manufacturing_date' => 'nullable|date',
            'expiry_date'  => 'nullable|date',
            'unit_cost' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:1',
            'batch_lot_number' => 'nullable|string',
            'shelf_life' => 'nullable|numeric',
            'measurement_unit' => 'required|numeric|exists:lims_measurements,id',
            'description' => 'required|string',
        ];
    }
}
