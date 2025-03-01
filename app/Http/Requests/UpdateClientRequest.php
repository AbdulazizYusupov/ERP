<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'fio' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string',
            'address' => 'sometimes|string|max:500',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'fio.string' => 'Full name must contain only letters and valid characters.',
            'fio.max' => 'Full name cannot exceed 255 characters.',

            'phone.string' => 'Phone number must be a valid text format.',
            'phone.unique' => 'This phone number is already in use. Please enter another one.',
            'phone.regex' => 'Invalid phone number format. Please enter a valid phone number.',

            'address.string' => 'Address must be a valid text format.',
            'address.max' => 'Address should not be longer than 500 characters.',

            'latitude.numeric' => 'Latitude must be a numeric value.',
            'latitude.between' => 'Latitude must be between -90 and 90 degrees.',

            'longitude.numeric' => 'Longitude must be a numeric value.',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees.',
        ];
    }
}
