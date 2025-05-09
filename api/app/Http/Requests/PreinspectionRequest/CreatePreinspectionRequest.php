<?php

namespace App\Http\Requests\PreinspectionRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePreinspectionRequest extends FormRequest
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
            'equipment' => 'required|string',
            'model' => 'required|string',
            'property_no' => 'required|string',
            'acquisition_cost' => 'required|numeric|gt:0',
            'acquisition_date' => 'required|date',
            'date' => 'required|date',
            'defects' => 'required|string',
            'requestor' => 'required|numeric',
            'equipment_type' => 'string|required'
        ];
    }
}
