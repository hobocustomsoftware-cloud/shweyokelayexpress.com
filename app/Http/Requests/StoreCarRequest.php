<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'number' => 'required|string|max:10',
            'departure_date' => 'nullable|date',
            'departure_time' => 'required|date_format:H:i',
            'day_off_date' => 'nullable|string',
            'from' => 'required|string|max:100',
            'to' => 'required|string|max:100',
            'driver_name' => 'required|string|max:50',
            'driver_phone_number' => 'required|string|max:50',
            'assistant_driver_name' => 'required|string|max:50',
            'assistant_driver_phone' => 'required|string|max:50',
            'spare_name' => 'required|string|max:50',
            'spare_phone' => 'required|string|max:50',
            'crew_name' => 'required|string|max:50',
            'crew_phone' => 'required|string|max:50',
        ];
    }
}
