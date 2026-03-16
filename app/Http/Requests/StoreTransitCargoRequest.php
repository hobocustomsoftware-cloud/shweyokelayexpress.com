<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransitCargoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            's_nrc' => $this->s_nrc ?? 'N/A',
            'r_nrc' => $this->r_nrc ?? 'N/A',
            'is_debt' => filter_var($this->is_debt, FILTER_VALIDATE_BOOLEAN), // Boolean string ကို စနစ်တကျ ပြောင်းလဲခြင်း
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        return [
            // Sender & Receiver
            's_name'         => 'required|string|max:50',
            's_phone'        => 'required|string|max:20',
            's_address'      => 'required|string|max:50',
            'r_name'         => 'required|string|max:50',
            'r_phone'        => 'required|string|max:20',
            'r_address'      => 'required|string|max:50',
    
            // Logistics (JSON key တွေနဲ့ ကိုက်အောင် _id ထည့်ထားပါတယ်)
            'from_city_id'   => 'required|integer|exists:cities,id',
            'to_city_id'     => 'required|integer|exists:cities,id',
            'from_gate_id'   => 'required|integer|exists:gates,id',
            'to_gate_id'     => 'required|integer|exists:gates,id',
    
            // Products/Items (Postman နဲ့ ကိုက်အောင် items လို့ ပြောင်းလိုက်ပါ)
            'items'                  => 'required|array|min:1',
            'items.*.cargo_type_id'  => 'required|integer|exists:cargo_types,id',
            'items.*.quantity'       => 'required|integer|min:1',
            'items.*.notice_message' => 'nullable|string|max:255',
    
            // Fees
            'service_charge' => 'required|numeric|min:0',
            'short_deli_fee' => 'nullable|numeric',
            'border_fee'     => 'nullable|numeric',
            'transit_fee'    => 'nullable|numeric',
            'total_fee'      => 'required|numeric',
    
            // Others
            'image'          => 'nullable|image|max:2048', // JSON နဲ့စမ်းရင် nullable ထားမှရမှာပါ
            'status'         => 'required|in:registered,delivered,taken,lost,deleted',
            'is_debt'        => 'required|boolean',
            'to_pick_date'   => 'required|date',
            'car_id'         => 'required|integer|exists:cars,id',
        ];
    }
    // public static function rules(): array
    // {
    //     return [
    //         // Sender information
    //         's_name'         => 'required|string|max:50',
    //         's_phone'        => 'required|string|max:20',
    //         's_nrc'          => 'required|string|max:20',
    //         's_address'      => 'required|string|max:50',

    //         // Receiver information
    //         'r_name'         => 'required|string|max:50',
    //         'r_phone'        => 'required|string|max:20',
    //         'r_nrc'          => 'required|string|max:20',
    //         'r_address'      => 'required|string|max:50',

    //         // Logistics info
    //         'cargo_no'       => 'nullable|string|max:50',
    //         'from_city'      => 'required|string|max:50',
    //         'to_city'        => 'required|string|max:50',
    //         'from_gate'      => 'required|string|max:50',
    //         'to_gate'        => 'required|string|max:50',

    //         // 🔹 Multiple Products Validation (အသစ်ထည့်သွင်းထားသော အပိုင်း)
    //         'products'                 => 'required|array|min:1',
    //         'products.*.cargo_type_id' => 'required|integer|exists:cargo_types,id',
    //         'products.*.quantity'      => 'required|integer|min:1',
    //         'products.*.detail'        => 'nullable|string|max:255',

    //         // 🔹 ပင်မ Table ထဲက field အဟောင်းတွေကို nullable ပြောင်းထားပါသည်
    //         'quantity'       => 'nullable|integer',
    //         'cargo_type_id'  => 'nullable|integer',

    //         // Remaining fields
    //         'image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'status'         => 'required|in:registered,delivered,taken,lost,deleted',
    //         'service_charge' => 'required|numeric|min:0',
    //         'is_debt'        => 'required|boolean',
    //         'to_pick_date'   => 'required|date',
    //         'voucher_number' => 'nullable|string|max:50',
    //         'car_id'         => 'required|integer|exists:cars,id',
    //     ];
    // }
}

// namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

// class StoreTransitCargoRequest extends FormRequest
// {
//     /**
//      * Determine if the user is authorized to make this request.
//      */
//     public function authorize(): bool
//     {
//         return true;
//     }
    
//     /**
//      * Prepare the data for validation.
//      */
//     protected function prepareForValidation()
//     {
//         $this->merge([
//             's_nrc' => $this->s_nrc ?? 'N/A',
//             'r_nrc' => $this->r_nrc ?? 'N/A',
//         ]);
//     }

//     /**
//      * Get the validation rules that apply to the request.
//      *
//      * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
//      */
//     public static function rules(): array
//     {
//         return [
//             's_name'         => 'required|string|max:50',
//             's_phone'        => 'required|string|max:20',
//             's_nrc'          => 'required|string|max:20',
//             's_address'      => 'required|string|max:50',

//             'r_name'         => 'required|string|max:50',
//             'r_phone'        => 'required|string|max:20',
//             'r_nrc'          => 'required|string|max:20',
//             'r_address'      => 'required|string|max:50',

//             'cargo_no'       => 'nullable|string|max:50',
//             'from_city'      => 'required|string|max:50',
//             'to_city'        => 'required|string|max:50',
//             'from_gate'      => 'required|string|max:50',
//             'to_gate'        => 'required|string|max:50',
//             'quantity'       => 'required|integer|min:1',
//             'cargo_type_id'     => 'required|integer|exists:cargo_types,id',
//             'image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
//             'status'         => 'required|in:registered, delivered, taken, lost, deleted',

//             'service_charge' => 'required|numeric|min:0',
//             'is_debt'        => 'required|boolean',

//             'to_pick_date'   => 'required|date',
//             'voucher_number' => 'nullable|string|max:50',
//             'car_id'         => 'required|integer|exists:cars,id',
//         ];
//     }
// }
