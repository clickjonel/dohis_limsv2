<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePropertyRequest extends FormRequest
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
            'property_no'       => 'required|string',
            'measurement_unit'  => 'required|numeric',
            'particulars'       => 'required|string',
            'unit_cost'         => 'required|numeric',
            'status'            => 'nullable|string',
            'remarks'           => 'nullable|string',
            'end_user'          => 'required|numeric',
            'acquisition_date'  => 'required|date'
        ];
    }
}
