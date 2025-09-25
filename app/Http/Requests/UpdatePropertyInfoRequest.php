<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $propertyId = $this->route('properties_info') ?? $this->route('id');

        return [
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255|unique:properties,name,' . $propertyId,
            'archived' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'city_id.required' => 'City is required.',
            'city_id.exists' => 'Selected city does not exist.',
            'name.required' => 'Property name is required.',
            'name.string' => 'Property name must be a valid string.',
            'name.max' => 'Property name cannot exceed 255 characters.',
            'name.unique' => 'Property name already exists.',
            'archived.boolean' => 'Archived status must be true or false.',
        ];
    }
}
