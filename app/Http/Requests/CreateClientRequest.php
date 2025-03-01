<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'fio' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\+?\d{9,15}$/|max:15',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'fio.required' => 'Full name is required.',
            'fio.string' => 'Full name must be a valid string.',
            'fio.max' => 'Full name must not exceed 255 characters.',

            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a valid string.',
            'phone.regex' => 'Phone number must be a valid format (e.g., +998901234567).',
            'phone.max' => 'Phone number must not exceed 15 characters.',

            'address.required' => 'Please select an address from the map.',
            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address must not exceed 500 characters.',

            'latitude.required' => 'Latitude is required.',
            'latitude.numeric' => 'Latitude must be a valid number.',
            'latitude.between' => 'Latitude must be between -90 and 90.',

            'longitude.required' => 'Longitude is required.',
            'longitude.numeric' => 'Longitude must be a valid number.',
            'longitude.between' => 'Longitude must be between -180 and 180.',
        ];
    }
}
