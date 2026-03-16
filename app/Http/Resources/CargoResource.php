<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CargoItemResource;

class CargoResource extends JsonResource
{
    // public function toArray(Request $request): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'cargo_no' => $this->cargo_no,
    //         'voucher_number' => $this->voucher_number,
    //         'from' => optional($this->fromCity)->name . ', ' . optional($this->fromGate)->name,
    //         'to' => optional($this->toCity)->name . ', ' . optional($this->toGate)->name,
            
    //         // 🔹 ဤနေရာတွင် ပစ္စည်းစာရင်း (Multiple Items) ကို ပြန်ပေးပါမည်
    //         'items' => CargoItemResource::collection($this->whenLoaded('items')),
            
    //         // ကျန်တဲ့ field တွေကတော့ အစ်ကို့ code အတိုင်းပါပဲ
    //         'status' => $this->status,
    //         'is_debt' => (bool) $this->is_debt,
    //         'to_pick_date' => Carbon::parse($this->to_pick_date)->format('d-m-Y'),
    //         'registered_date' => Carbon::parse($this->created_at)->format('d-m-Y'),
    //         'qrcode' => $this->qrcode_image,
    //         'sender' => [
    //             'name' => ($this->s_name_string) ? $this->s_name_string : optional($this->sender_merchant)->name,
    //             'phone' => $this->s_phone,
    //             'nrc' => $this->s_nrc,
    //             'address' => $this->s_address,
    //         ],
    //         'receiver' => [
    //             'name' => ($this->r_name_string) ? $this->r_name_string : optional($this->receiver_merchant)->name,
    //             'phone' => $this->r_phone,
    //             'nrc' => $this->r_nrc,
    //             'address' => $this->r_address,
    //         ],
    //         'finicial' => [
    //             'service_charge' => $this->service_charge,
    //             'short_deli_fee' => $this->short_deli_fee,
    //             'transit_fee' => $this->transit_fee,
    //             'border_fee' => $this->border_fee,
    //             'total_fee' => $this->total_fee,
    //         ]
    //     ];
    // }
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cargo_no' => $this->cargo_no,
            'voucher_number' => $this->voucher_number,
            'from' => optional($this->fromCity)->name . ', ' . optional($this->fromGate)->name,
            'to' => optional($this->toCity)->name . ', ' . optional($this->toGate)->name,
            'from_city_id' => $this->from_city_id,
            'to_city_id' => $this->to_city_id,
            'from_gate_id' => $this->from_gate_id,
            'to_gate_id' => $this->to_gate_id,
            'items' => CargoItemResource::collection($this->whenLoaded('items')),
            'image' => 'public/uploads/' . optional($this->media)->path,
            'status' => $this->status,
            'is_debt' => (bool) $this->is_debt,
            'to_pick_date' => Carbon::parse($this->to_pick_date)->format('d-m-Y'),
            'registered_date' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'qrcode' => $this->qrcode_image,
            'sender' => [
                'name' => ($this->s_name_string) ? $this->s_name_string : optional($this->sender_merchant)->name,
                'phone' => $this->s_phone,
                'nrc' => $this->s_nrc,
                'address' => $this->s_address,
            ],
            'receiver' => [
                'name' => ($this->r_name_string) ? $this->r_name_string : optional($this->receiver_merchant)->name,
                'phone' => $this->r_phone,
                'nrc' => $this->r_nrc,
                'address' => $this->r_address,
            ],
            'finicial' => [
                'service_charge' => $this->service_charge,
                'short_deli_fee' => $this->short_deli_fee,
                'final_deli_fee' => $this->final_deli_fee,
                'transit_fee' => $this->transit_fee,
                'border_fee' => $this->border_fee,
                'total_fee' => $this->total_fee,
                'total_receive_fee' => $this->total_receive_fee,
            ]
        ];
    }
}

