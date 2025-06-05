<?php

namespace App\Http\Requests\PropertyInspection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SetPropertyInspectionRequest extends FormRequest
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
            'status' => 'required|string',
            'inspection_result' => 'required|string',
            'inspection_findings' => 'required|string',
            'inspection_date' => 'required|date',
        ];
    }
}
