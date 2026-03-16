<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
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
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        $rules = [
            // 's_name'         => 'required|string|max:50',
            // 's_phone'        => 'required|string|max:20',
            // 's_nrc'          => 'required|string|max:20',
            // 's_address'      => 'required|string|max:50',

            // 'r_name'         => 'required|string|max:50',
            // 'r_phone'        => 'required|string|max:20',
            // 'r_nrc'          => 'required|string|max:20',
            // 'r_address'      => 'required|string|max:50',

            // 'cargo_no'       => 'string|max:50',
            // 'from_city_id'      => 'required|integer|exists:cities,id',
            // 'to_city_id'        => 'required|integer|exists:cities,id',
            // 'from_gate_id'      => 'required|integer|exists:gates,id',
            // 'to_gate_id'        => 'required|integer|exists:gates,id',
            // 'quantity'       => 'required|integer|min:1',
            // 'cargo_type_id'     => 'required|integer|exists:cargo_types,id',
            // 'cargo_detail_name' => 'nullable|string|max:50',
            // 'notice_message' => 'nullable|string|max:50',
            // 'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
            // 'status'         => 'required|in:registered, delivered, taken, lost, deleted',

            // 'service_charge' => 'required|numeric|min:0',
            // 'short_deli_fee' => 'required|numeric|min:0',
            // 'border_fee'     => 'required|numeric|min:0',
            // 'transit_fee'    => 'required|numeric|min:0',
            // 'total_fee'      => 'required|numeric|min:0',
            // 'total_receive_fee' => 'nullable|numeric|min:0',

            // 'is_debt'        => 'required|boolean',

            // 'to_pick_date'   => 'required|date',
            // 'voucher_number' => 'string|max:50',
            // ပို့သူ အချက်အလက်
            's_name'         => 'required|string|max:100',
            's_phone'        => 'required|string|max:20',
            's_nrc'          => 'required|string|max:30',
            's_address'      => 'required|string|max:255',

            // လက်ခံသူ အချက်အလက်
            'r_name'         => 'required|string|max:100',
            'r_phone'        => 'required|string|max:20',
            'r_nrc'          => 'required|string|max:30',
            'r_address'      => 'required|string|max:255',

            // မြို့နှင့် ဂိတ်
            'from_city_id'   => 'required|integer|exists:cities,id',
            'to_city_id'     => 'required|integer|exists:cities,id',
            'from_gate_id'   => 'required|integer|exists:gates,id',
            'to_gate_id'     => 'required|integer|exists:gates,id',

            /** * အဓိက ပြင်ဆင်ချက်- ကုန်ပစ္စည်းစာရင်း (Items Array) Validation
             * Single quantity နှင့် cargo_type_id နေရာတွင် အစားထိုးသည်
             */
            'items'                 => 'required|array|min:1',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.cargo_type_id' => 'required|integer|exists:cargo_types,id',
            'items.*.detail'        => 'nullable|string|max:255',
            'items.*.notice'        => 'nullable|string|max:255',

            // အခြား အချက်အလက်များ
            'cargo_no'       => 'nullable|string|max:50',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
            'status'         => 'nullable|string',

            // ငွေကြေးဆိုင်ရာ
            'service_charge' => 'required|numeric|min:0',
            'short_deli_fee' => 'required|numeric|min:0',
            'border_fee'     => 'required|numeric|min:0',
            'transit_fee'    => 'required|numeric|min:0',
            'total_fee'      => 'required|numeric|min:0',
            'total_receive_fee' => 'nullable|numeric|min:0',
            'final_deli_fee' => 'nullable|numeric|min:0',

            'is_debt'        => 'boolean',
            'to_pick_date'   => 'required|date',
            'voucher_number' => 'nullable|string|max:50',
        ];
        return $rules;
    }
}