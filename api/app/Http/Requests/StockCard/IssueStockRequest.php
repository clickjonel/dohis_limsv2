<?php

namespace App\Http\Requests\StockCard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IssueStockRequest extends FormRequest
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
            'id' => 'required|exists:lims_stock_cards,id',
            'issued' => 'required|numeric',
            'remarks' => 'nullable|string',
            'recepient' => 'required|string',
            'ptr_no' => 'required|string',
            'transaction_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'issued.notin' => 'The unit cost should be greater than 0.',
        ];
    }
}
