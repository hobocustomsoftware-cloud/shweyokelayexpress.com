<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TransitCargoRepositoryInterface;
use App\Http\Resources\TransitCargoCollection;
use App\Services\ApiResponseService;
use App\Http\Requests\StoreTransitCargoRequest;
use App\Http\Resources\TransitCargoResource;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\MerchantRepositoryInterface;
use App\Services\QrCodeService;
use Carbon\Carbon;
use App\Models\TransitCargo; 
use App\Models\CargoItem; 
use App\Http\Resources\CargoResource;

class TransitCargoApiController extends BaseApiController
{
    protected $mediaRepository;
    protected $merchantRepository;

    public function __construct(TransitCargoRepositoryInterface $transitCargoRepository, MediaRepositoryInterface $mediaRepository, MerchantRepositoryInterface $merchantRepository)
    {
        parent::__construct($transitCargoRepository);
        $this->mediaRepository = $mediaRepository;
        $this->merchantRepository = $merchantRepository;
    }

    public function index() {
        $transitCargoList = $this->repository->getList()->paginate(10);
        $dataCollection = new TransitCargoCollection($transitCargoList);
        return ApiResponseService::sendResponse($dataCollection, 'Successfully get transit cargo list', 200);
    }
    public function store(Request $request) {
    // 1. Validation မစစ်ခင် Android/Postman မှ Key များကို Laravel Rule နှင့် ကိုက်ညီအောင် ညှိပေးခြင်း
    $request->merge([
        'status' => 'registered',
        'from_city_id' => $request->from_city,
        'to_city_id'   => $request->to_city,
        'from_gate_id' => $request->from_gate,
        'to_gate_id'   => $request->to_gate,
        'total_fee'    => $request->service_charge, // service_charge ကို total_fee အဖြစ် validation အတွက် သုံးပေးခြင်း
    ]);

    // 2. Validation စစ်မယ် (Request Rule အတိုင်း)
    $validated = $request->validate((new StoreTransitCargoRequest())->rules());
    
    // 3. Image Upload Logic
    if ($request->hasFile('image')) {
        $media_id = $this->mediaRepository->create($request->file('image'), 'cargos');
        if (!$media_id) {
            return ApiResponseService::sendError('Failed to upload image', 500);
        }
        $validated['media_id'] = $media_id;
    }

    // 4. Sender Logic (Merchant ID သို့မဟုတ် String ဖြစ်နိုင်သည်)
    if ($request->has('s_name')) {
        if (is_numeric($request->s_name)) {
            $merchant = $this->merchantRepository->findById($request->s_name);
            if ($merchant) { 
                $validated['s_merchant_id'] = $merchant->id; 
            }
        } else { 
            $validated['s_name_string'] = $request->s_name; 
        }
    }

    // 5. Receiver Logic
    if ($request->has('r_name')) {
        if (is_numeric($request->r_name)) {
            $merchant = $this->merchantRepository->findById($request->r_name);
            if ($merchant) { 
                $validated['r_merchant_id'] = $merchant->id; 
            }
        } else { 
            $validated['r_name_string'] = $request->r_name; 
        }
    }
    
    // 6. Database Column Mapping (DB ထဲမှာ တကယ်ရှိတဲ့ column နာမည်များ)
    $validated['s_nrc'] = $request->s_nrc; 
    $validated['r_nrc'] = $request->r_nrc;
    $validated['from_city'] = $request->from_city; 
    $validated['to_city']   = $request->to_city;
    $validated['from_gate'] = $request->from_gate;
    $validated['to_gate']   = $request->to_gate;
    
    // Validation အတွက် merge ခဲ့သော Key အပိုများကို Database သိမ်းရန် မလိုအပ်ပါက ဖယ်ထုတ်ပါ
    unset($validated['s_name'], $validated['r_name']);
    
    // Default Values နှင့် Format ချခြင်း
    $validated['cargo_no'] = generateTransitCargoNumber();
    $validated['voucher_number'] = generateTransitCargoVoucherNumber();
    $validated['to_pick_date'] = \Carbon\Carbon::parse($request->to_pick_date)->format('Y-m-d');
    $validated['status'] = 'registered';
    
    // $transitCargo = $this->repository->create($validated); ရဲ့ အပေါ်မှာ ထည့်ပါ
    $validated['cargo_type_id'] = $request->items[0]['cargo_type_id'] ?? 1;

    // 7. ပင်မ Transit Cargo ကို Database ထဲ Create လုပ်မယ်
    $transitCargo = $this->repository->create($validated);
    
    if(!$transitCargo) {
        return ApiResponseService::sendError('Failed to create transit cargo', 500);
    }

    // 8. Multiple Items (Products) ကို Loop ပတ်ပြီး သိမ်းမယ်
    if ($request->has('items') && is_array($request->items)) {
        foreach ($request->items as $item) {
            $transitCargo->items()->create([
                'cargo_type_id' => $item['cargo_type_id'],
                'quantity'      => $item['quantity'],
                'detail'        => $item['detail'] ?? null,
                'notice'        => $item['notice'] ?? null,
            ]);
        }
    } else {
        \Log::warning('No items found in request for Cargo ID: ' . $transitCargo->id);
    }

    // 9. လိုအပ်သော Relationship များ Load လုပ်ပြီး Response ပြန်မယ်
    $transitCargo->load(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate', 'media']);

    return ApiResponseService::sendResponse(new TransitCargoResource($transitCargo), 'Cargo created successfully', 200);
}
       //     public function store(Request $request) {
//     // 1. Validation စစ်မယ်
//     $validated = $request->validate((new StoreTransitCargoRequest())->rules());
    
//     // 2. Image Upload Logic
//     if ($request->hasFile('image')) {
//         $media_id = $this->mediaRepository->create($request->file('image'), 'cargos');
//         if (!$media_id) {
//             return ApiResponseService::sendError('Failed to upload image');
//         }
//         $validated['media_id'] = $media_id;
//     }

//     // 3. Sender/Receiver Logic
//     if ($request->has('s_name')) {
//         if (is_numeric($request->s_name)) {
//             $merchant = $this->merchantRepository->findById($request->s_name);
//             if ($merchant) { $validated['s_merchant_id'] = $merchant->id; }
//         } else { $validated['s_name_string'] = $request->s_name; }
//     }
//     if ($request->has('r_name')) {
//         if (is_numeric($request->r_name)) {
//             $merchant = $this->merchantRepository->findById($request->r_name);
//             if ($merchant) { $validated['r_merchant_id'] = $merchant->id; }
//         } else { $validated['r_name_string'] = $request->r_name; }
//     }

//     // 4. Logistics & Fees Mapping
//     $validated['from_city_id'] = $request->from_city_id;
//     $validated['to_city_id']   = $request->to_city_id;
//     $validated['from_gate_id'] = $request->from_gate_id;
//     $validated['to_gate_id']   = $request->to_gate_id;
    
//     // အစ်ကို့ Postman error မှာတက်ခဲ့တဲ့ field အသစ်တွေကို Map လုပ်ခြင်း
//     $validated['short_deli_fee'] = $request->short_deli_fee ?? 0;
//     $validated['border_fee']     = $request->border_fee ?? 0;
//     $validated['transit_fee']    = $request->transit_fee ?? 0;

//     unset($validated['s_name'], $validated['r_name']);
    
//     $validated['cargo_no'] = generateTransitCargoNumber();
//     $validated['voucher_number'] = generateTransitCargoVoucherNumber();
//     $validated['to_pick_date'] = \Carbon\Carbon::parse($request->to_pick_date)->format('Y-m-d');
//     $validated['status'] = 'registered';

//     // 5. ပင်မ Cargo ကို သိမ်းမယ်
//     $transitCargo = $this->repository->create($validated);
    
//     if($transitCargo) {
//         // 🔹 ၆။ Cargo Items များကို Loop ပတ်၍ သိမ်းဆည်းခြင်း
//         // Postman JSON ၏ "items" key ကို တိုက်ရိုက်ယူသုံးပါသည်
//         // if ($request->has('items') && is_array($request->items)) {
//         //     foreach ($request->items as $item) {
//         //         // CargoItem Model သို့ relationship သုံး၍ create လုပ်ခြင်း
//         //         $transitCargo->items()->create([
//         //             'cargo_type_id' => $item['cargo_type_id'],
//         //             'quantity'      => $item['quantity'],
//         //             'detail'        => $item['notice_message'] ?? null, // UI/Postman မှလာသော message
//         //         ]);
//         //     }
//         // }
//         // 🔹 ၆။ Cargo Items များကို Loop ပတ်၍ သိမ်းဆည်းခြင်း
//         if ($request->has('items') && is_array($request->items)) {
//             foreach ($request->items as $item) {
//                 $transitCargo->items()->create([
//                     'cargo_type_id' => $item['cargo_type_id'],
//                     'quantity'      => $item['quantity'],
//                     'detail'        => $item['detail'] ?? null,  // Postman က 'detail' နဲ့ လာရင် detail ထဲသိမ်းပါ
//                     'notice'        => $item['notice'] ?? null,  // Database ထဲက field name အမှန်
//                 ]);
//             }
//         }

//         // ၇။ Relationship များအား Load လုပ်ပြီး Response ပြန်မည်
//         $transitCargo->load(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate', 'media']);
//         return ApiResponseService::sendResponse(new \App\Http\Resources\CargoResource($transitCargo), 'Cargo created successfully', 201);
//     }

//     return ApiResponseService::sendError('Failed to create transit cargo');
// }
    // public function store(Request $request) {
    //     // 1. Validation စစ်မယ်
    //     // မှတ်ချက်- StoreTransitCargoRequest ထဲမှာ 'products' ကို 'items' လို့ ပြောင်းထားဖို့ လိုပါတယ်
    //     $validated = $request->validate((new StoreTransitCargoRequest())->rules());
        
    //     // 2. Image Upload
    //     if ($request->hasFile('image')) {
    //         $media_id = $this->mediaRepository->create($request->file('image'), 'cargos');
    //         if (!$media_id) {
    //             return ApiResponseService::sendError('Failed to upload image');
    //         }
    //         $validated['media_id'] = $media_id;
    //     }
    
    //     // 3. Sender/Receiver Logic (Merchant ID လား String လား ခွဲခြားခြင်း)
    //     if ($request->has('s_name')) {
    //         if (is_numeric($request->s_name)) {
    //             $merchant = $this->merchantRepository->findById($request->s_name);
    //             if ($merchant) { $validated['s_merchant_id'] = $merchant->id; }
    //         } else { $validated['s_name_string'] = $request->s_name; }
    //     }
    //     if ($request->has('r_name')) {
    //         if (is_numeric($request->r_name)) {
    //             $merchant = $this->merchantRepository->findById($request->r_name);
    //             if ($merchant) { $validated['r_merchant_id'] = $merchant->id; }
    //         } else { $validated['r_name_string'] = $request->r_name; }
    //     }
    
    //     // Validation rules ထဲက နာမည်တွေနဲ့ DB column နာမည်တွေ မတူရင် ဒီမှာ Mapping ပြန်လုပ်ပေးရပါတယ်
    //     $validated['from_city'] = $request->from_city_id;
    //     $validated['to_city']   = $request->to_city_id;
    //     $validated['from_gate'] = $request->from_gate_id;
    //     $validated['to_gate']   = $request->to_gate_id;
    
    //     unset($validated['s_name'], $validated['r_name']);
        
    //     $validated['cargo_no'] = generateTransitCargoNumber();
    //     $validated['voucher_number'] = generateTransitCargoVoucherNumber();
    //     $validated['to_pick_date'] = \Carbon\Carbon::parse($validated['to_pick_date'])->format('Y-m-d');
    //     $validated['status'] = 'registered';
    
    //     // 4. ပင်မ Transit Cargo ကို Create လုပ်မယ်
    //     $transitCargo = $this->repository->create($validated);
        
    //     if(!$transitCargo) {
    //         return ApiResponseService::sendError('Failed to create transit cargo');
    //     }
    
    //     // 5. 🔹 Multiple Items (Products) ကို Loop ပတ်ပြီး သိမ်းမယ်
    //     // Postman က 'items' လို့ ပို့ရင် ဒီမှာလည်း 'items' လို့ သုံးရပါမယ်
    //     // if ($request->has('items') && is_array($request->items)) {
    //     //     foreach ($request->items as $item) {
    //     //         $transitCargo->items()->create([
    //     //             'cargo_type_id' => $item['cargo_type_id'],
    //     //             'quantity'      => $item['quantity'],
    //     //             'detail'        => $item['notice_message'] ?? null,
    //     //         ]);
    //     //     }
    //     // }
    //     if ($request->has('items') && is_array($request->items)) {
    //         foreach ($request->items as $item) {
    //             // 🔹 Debug လုပ်ရန်: log ထဲမှာ ဒေတာပါလား စစ်မယ်
    //             \Log::info('Storing Item:', $item); 
        
    //             $newItem = $transitCargo->items()->create([
    //                 'cargo_type_id' => $item['cargo_type_id'],
    //                 'quantity'      => $item['quantity'],
    //                 'detail'        => $item['detail'] ?? null,
    //                 'notice'        => $item['notice'] ?? null,
    //             ]);
        
    //             // 🔹 Debug လုပ်ရန်: သိမ်းပြီးလို့ model ထွက်လာလား စစ်မယ်
    //             if (!$newItem) {
    //                 \Log::error('Failed to create CargoItem for Cargo ID: ' . $transitCargo->id);
    //             }
    //         }
    //     } else {
    //         // 🔹 Debug လုပ်ရန်: items array မရောက်လာရင် သိရအောင်
    //         \Log::warning('No items found in request or not an array');
    //     }
    
    //     // 6. Relationship တွေအကုန် Load လုပ်ပြီး Response ပြန်မယ်
    //     $transitCargo->load(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate', 'media']);
    
    //     return ApiResponseService::sendResponse(new TransitCargoResource($transitCargo), 'Cargo created successfully', 200);
    // }

    // public function store(Request $request) {
    //     $validated = $request->validate((new StoreTransitCargoRequest())->rules());
        
    //     // 1. Image Upload
    //     if ($request->hasFile('image')) {
    //         $media_id = $this->mediaRepository->create($request->file('image'), 'cargos');
    //         if (!$media_id) {
    //             return ApiResponseService::sendError('Failed to upload image');
    //         }
    //         $validated['media_id'] = $media_id;
    //     }

    //     // 2. Sender/Receiver Logic
    //     if ($request->has('s_name')) {
    //         if (is_numeric($request->s_name)) {
    //             $merchant = $this->merchantRepository->findById($request->s_name);
    //             if ($merchant) { $validated['s_merchant_id'] = $merchant->id; }
    //         } else { $validated['s_name_string'] = $request->s_name; }
    //     }
    //     if ($request->has('r_name')) {
    //         if (is_numeric($request->r_name)) {
    //             $merchant = $this->merchantRepository->findById($request->r_name);
    //             if ($merchant) { $validated['r_merchant_id'] = $merchant->id; }
    //         } else { $validated['r_name_string'] = $request->r_name; }
    //     }

    //     unset($validated['s_name'], $validated['r_name']);
        
    //     $validated['cargo_no'] = generateTransitCargoNumber();
    //     $validated['voucher_number'] = generateTransitCargoVoucherNumber();
        
    //     $qrcodeService = new QrCodeService();
    //     $validated['qrcode_image'] = $qrcodeService->saveQrcode(json_encode($validated));
    //     $validated['to_pick_date'] = Carbon::parse($validated['to_pick_date'])->format('Y-m-d');

    //     // 3. Create Main Transit Cargo
    //     $transitCargo = $this->repository->create($validated);
        
    //     if(!$transitCargo) {
    //         return ApiResponseService::sendError('Failed to create transit cargo');
    //     }

    //     // 4. Save Multiple Items (Products)
    //     if ($request->has('items') && is_array($request->items)) {
    //         foreach ($request->items as $item) {
    //             $transitCargo->items()->create([
    //                 'cargo_type_id' => $item['cargo_type_id'],
    //                 'quantity'      => $item['quantity'],
    //                 'detail'        => $item['notice_message'] ?? null, // အစ်ကို့ JSON ထဲက notice_message ကို detail ထဲသိမ်းတာပါ
    //             ]);
    //         }
    //     }

    //     // 5. 🔹 Eager Load Relationships (ဒါထည့်မှ Result မှာ Data တွေပါမှာပါ)
    //     $transitCargo->load(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate', 'media']);

    //     $dataResource = new TransitCargoResource($transitCargo);
    //     return ApiResponseService::sendResponse($dataResource, 'Cargo created successfully', 200);
    // }

    public function show($id) {
        $transitCargo = $this->repository->find($id);
        if (!$transitCargo) {
            return ApiResponseService::sendError('Transit cargo not found', 404);
        }
        $transitCargo->load(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate']);
        $dataResource = new TransitCargoResource($transitCargo);
        return ApiResponseService::sendResponse($dataResource, 'Successfully get transit cargo', 200);
    }
}