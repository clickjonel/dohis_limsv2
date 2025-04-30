<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePropertyRequestTransferRequest extends FormRequest
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
            'transfer_to' => 'required|integer',
            'requested_by' => 'required|integer',
            'transfer_type' => 'required|string',
            'transfer_reason' => 'required|string',
            'date_requested' => 'required|date',
            'property_id' => 'required|integer',
            'status' => 'required|string',
        ];
    }
}
