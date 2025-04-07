<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateDeliveryRequest extends FormRequest
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
            'fund_source' => 'required|numeric',
            'req_office' => 'required|numeric',
            'end_user' => 'required|numeric',
            'payment_term' => 'required|numeric',
            'completion' => 'required|numeric',
            'entity_name' => 'required|string',
            'purpose' => 'required|string',
            'source_name' => 'required|string',
            'source_address' => 'required|string',
            'iar_no' => 'required|string',
            'iar_date' => 'required|date',
            'po_no' => 'nullable|required_if:payment_term,1|string',
            'po_date' => 'nullable|required_if:payment_term,1|date',
            'ptr_no' => 'nullable|required_if:payment_term,2|string',
            'ptr_date' => 'nullable|required_if:payment_term,2|date',
            'dnf_no' => 'nullable|string',
            'dnf_date' => 'nullable|date',
            'bl_no' => 'nullable|string',
            'bl_date' => 'nullable|date',
            'invoices' => 'nullable|array|required_if:payment_term,1',
            'delivery_receipts' => 'array|required',
            'items' => 'array|required'
        ];
    }

    public function messages()
    {
        return [
            'invoices.required_if' => 'Invoices is required if payment terms is Charge',
            'po_no.required_if' => 'PO Number is required if payment terms is Charge'
        ];
    }
}
