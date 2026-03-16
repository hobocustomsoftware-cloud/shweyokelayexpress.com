<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'name_en' => 'required|string|max:50',
            'name_my' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'status'=> 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name_en.required' => 'Name in English is required',
            'name_en.string' => 'Name in English must be a string',
            'name_en.max' => 'Name in English must be less than 50 characters',
            'name_my.required' => 'Name in Myanmar is required',
            'name_my.string' => 'Name in Myanmar must be a string',
            'name_my.max' => 'Name in Myanmar must be less than 50 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description must be less than 255 characters',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be active or inactive',
        ];
    }
}
