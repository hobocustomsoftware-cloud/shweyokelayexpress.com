<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TransitCargoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray($request)
    {
        return [
            "id" => $this->id,
            "cargo_no" => $this->cargo_no,
            "voucher_number" => $this->voucher_number,
            "from" => $this->fromCity->name . ", " . $this->fromGate->name,
            "to" => $this->toCity->name . ", " . $this->toGate->name,
            
            // 🔹 ပစ္စည်းအများကြီးကို array အနေနဲ့ ပြန်ပြပေးခြင်း
            "items" => $this->items->map(function($item) {
                return [
                    "quantity" => $item->quantity,
                    "cargo_type" => $item->cargoType->name ?? 'N/A',
                    "detail" => $item->detail,
                    "notice" => $item->notice
                ];
            }),
    
            "status" => $this->status,
            "is_debt" => (bool)$this->is_debt,
            "to_pick_date" => Carbon::parse($this->to_pick_date)->format('d-m-Y'),
            "registered_date" => $this->created_at->format('d-m-Y'),
            "qrcode" => $this->qrcode_image,
            
            "sender" => [
                "name" => $this->s_name_string ?? ($this->sender_merchant->name ?? 'N/A'),
                "phone" => $this->s_phone,
                "address" => $this->s_address
            ],
            "receiver" => [
                "name" => $this->r_name_string ?? ($this->receiver_merchant->name ?? 'N/A'),
                "phone" => $this->r_phone,
                "address" => $this->r_address
            ],
            "financial" => [
                "service_charge" => $this->service_charge,
                "short_deli_fee" => $this->short_deli_fee,
                "border_fee" => $this->border_fee,
                "total_fee" => $this->total_fee
            ]
        ];
    }
    // public function toArray(Request $request): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'cargo_no' => $this->cargo_no,
    //         'voucher_number' => $this->voucher_number,
    //         'from' => optional($this->fromCity)->name . ', ' . optional($this->fromGate)->name,
    //         'to' => optional($this->toCity)->name . ', ' . optional($this->toGate)->name,
    //         'quantity' => $this->quantity,
    //         'cargo_type' => optional($this->cargoType)->name,
    //         'notice_message' => $this->notice_message,
    //         'cargo_detail_name' => $this->cargo_detail_name,
    //         'image' => 'public/uploads/' . optional($this->media)->path,
    //         'status' => $this->status,
    //         'qrcode_image' => $this->qrcode_image,
    //         'is_debt' => (bool) $this->is_debt,
    //         'car_number' => $this->car->number,
    //         'car_id' => $this->car_id,
    //         'to_pick_date' => Carbon::parse($this->to_pick_date)->format('d-m-Y'),
    //         'registered_date' => Carbon::parse($this->created_at)->format('d-m-Y'),
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
    //         ]
    //     ];
    // }
}    
