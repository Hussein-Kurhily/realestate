<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentRealestateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id' => 'required|exists:users,id',
            'phone' => 'required|string',
            'type' => 'required|string',
            'city' => 'required|string',
            'region' => 'required|string',
            'desc' => 'required|string',
            'brushes' => 'required|string',
            'preparation' => 'required|string',
            'seller_type' => 'required|string',
            'floor' => 'required|string',
            'price' => 'required|string',
            'area' => 'required|string',
            'views' => 'required|integer',
            'evaluation' => 'required|numeric',
            'property_type' => 'required|numeric',
            'bathrooms_number' => 'required|string',
            'wifi' => 'required|boolean',
            'elevator' => 'required|boolean',
            'barking' => 'required|boolean',
            'swimming_bool' => 'required|boolean',
            'solar_energy' => 'required|boolean',
            'images' => 'required|array',
            'images.*' => 'required|string', // Assuming each image is a base64 string
        ];
    }
}
