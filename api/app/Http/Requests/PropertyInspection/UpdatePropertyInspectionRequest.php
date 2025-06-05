<?php

namespace App\Http\Requests\PropertyInspection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePropertyInspectionRequest extends FormRequest
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
            'request_id' => 'required|exists:lims_property_inspection_requests,id',
            'request_date' => 'nullable|date',
            'requested_by' => 'nullable|numeric',
            'defects' => 'nullable|string',
            'inspection_section' => 'nullable|numeric',
            'status' => 'nullable|string',
            'inspection_result' => 'nullable|string',
            'inspection_findings' => 'nullable|string',
            'inspection_date' => 'nullable|date',
        ];
    }
}
