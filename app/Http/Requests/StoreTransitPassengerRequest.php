<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransitPassengerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'nrc' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
            'seat_number' => 'required|numeric',
            'price' => 'required|numeric',
            'transit_cargo_id' => 'nullable|exists:transit_cargos,id',
            'user_id' => 'nullable|exists:users,id',
            'is_paid' => 'required|boolean',
            'status' => 'required|in:active,inactive',
            'voucher_number' => 'nullable|string|max:255',
        ];
    }
}
