<?php

namespace App\Http\Requests\PropertyInspection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePropertyInspectionRequest extends FormRequest
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
            'property_id' => 'required|exists:lims_properties,id',
            'request_date' => 'required|date',
            'requested_by' => 'required|numeric',
            'defects' => 'required|string',
            'inspection_section' => 'required|numeric',
            'status' => 'required|string'
        ];
    }
}
