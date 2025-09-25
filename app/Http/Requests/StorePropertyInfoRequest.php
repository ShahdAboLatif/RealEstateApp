<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255|unique:properties,name',
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
        ];
    }
}
