<?php
namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Gate;
use App\Models\CargoItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Repositories\CityRepository;
use App\Repositories\CargoRepository;
use App\Repositories\MediaRepository;
use App\Http\Requests\StoreCargoRequest;
use App\Repositories\CarCargoRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\CargoTypeRepository;
use App\Repositories\GateRepository;
use Illuminate\Validation\ValidationException;

class CargoForm extends Component
{
    use WithFileUploads;

    public $cities = [];
    public $gates = [];
    public $merchants = [];
    public $cargotypes = [];
    public $fromGates = [], $toGates = [];
    public $s_nrc = 'N/A', $r_nrc = 'N/A';
    public $s_phone, $s_address, $r_phone, $r_address;
    public $s_name, $r_name = null;
    public $from_city_id, $to_city_id, $from_gate_id, $to_gate_id;

    // Repositories
    protected $cityRepository;
    protected $merchantRepository;
    protected $cargoTypeRepository;
    protected $cargoRepository;
    protected $mediaRepository;
    protected $carCargoRepository;
    protected $gateRepository;

    // Cargo Main Fields
    public $cargo_no, $quantity, $cargo_type_id, $media_id, $status = 'registered';
    public $service_charge = 0, $short_deli_fee = 0, $final_deli_fee = 0;
    public $border_fee = 0, $transit_fee = 0, $total_fee = 0, $total_receive_fee = 0;
    public $to_pick_date, $voucher_number, $image, $qrcode_image;

    public $form_type = 'create';
    public $is_debt = false;
    public $cargo_id;

    public $s_merchant_id, $r_merchant_id, $s_name_string, $r_name_string;
    public $is_home = false;
    public $is_transit = false;

    public $from_city_name, $to_city_name;
    public $cargo_detail_name;
    public $notice_message;

    public $cargo;
    public $items = [];

    public function boot(CityRepository $cityRepository, MerchantRepository $merchantRepository, CargoTypeRepository $cargoTypeRepository, CargoRepository $cargoRepository, MediaRepository $mediaRepository, CarCargoRepository $carCargoRepository, GateRepository $gateRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->merchantRepository = $merchantRepository;
        $this->cargoTypeRepository = $cargoTypeRepository;
        $this->cargoRepository = $cargoRepository;
        $this->mediaRepository = $mediaRepository;
        $this->carCargoRepository = $carCargoRepository;
        $this->gateRepository = $gateRepository;
    }

    public function mount($form_type = 'create', $cargo_id = null)
    {
        $this->form_type = $form_type;
        $this->cargo_id = $cargo_id;

        // Load Basic Data
        $this->cities = $this->cityRepository->getAllCities();
        $this->merchants = $this->merchantRepository->getAll();
        $this->cargotypes = $this->cargoTypeRepository->getAllCargoTypes();

        if ($this->form_type === 'edit' && $this->cargo_id) {
            $cargo = $this->cargoRepository->getCargoById($this->cargo_id);
            if ($cargo) {
                $this->cargo = $cargo;
                $this->fill($cargo->toArray());

                // Load Items Data from Relationship
                $this->items = $cargo->items->map(function ($item) {
                    return [
                        'quantity' => $item->quantity,
                        'cargo_type_id' => $item->cargo_type_id,
                        'detail' => $item->detail,
                        'notice' => $item->notice
                    ];
                })->toArray();

                // Set Names & Phone for UI
                $this->s_name = $cargo->s_merchant_id ?: $cargo->s_name_string;
                $this->r_name = $cargo->r_merchant_id ?: $cargo->r_name_string;
                
                // Load Gates based on City
                $this->fromGates = Gate::where('city_id', $cargo->from_city_id)->get();
                $this->toGates = Gate::where('city_id', $cargo->to_city_id)->get();

                if ($cargo->media) {
                    $this->image = $cargo->media->path;
                }
            }
        } else {
            // Default values for Create
            $this->status = 'registered';
            $this->cargo_no = $this->generateCargoNumber();
            $this->to_pick_date = Carbon::now()->addDays(1)->format('Y-m-d');
            $this->voucher_number = $this->generateVoucherNumber();
            $this->items = [['quantity' => 1, 'cargo_type_id' => '', 'detail' => '', 'notice' => '']];
        }
    }

    public function addItem()
    {
        $this->items[] = ['quantity' => 1, 'cargo_type_id' => '', 'detail' => '', 'notice' => ''];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedFromCityId($cityId)
    {
        $this->fromGates = Gate::where('city_id', $cityId)->orderBy('name_my')->get();
        $this->from_gate_id = null;
    }

    public function updatedToCityId($cityId)
    {
        $this->toGates = Gate::where('city_id', $cityId)->orderBy('name_my')->get();
        $this->to_gate_id = null;
    }

    public function updatedSName($value)
    {
        if (is_numeric($value)) {
            $this->s_merchant_id = $value;
            $this->s_phone = $this->merchantRepository->getPhoneByMerchantId($value);
            $this->s_address = $this->merchantRepository->getAddressByMerchantId($value);
            $this->s_nrc = $this->merchantRepository->getNrcByMerchantId($value) ?? 'N/A';
        } else {
            $this->s_merchant_id = null;
            $this->s_name_string = $value;
        }
    }

    public function updatedRName($value)
    {
        if (is_numeric($value)) {
            $this->r_merchant_id = $value;
            $this->r_phone = $this->merchantRepository->getPhoneByMerchantId($value);
            $this->r_address = $this->merchantRepository->getAddressByMerchantId($value);
            $this->r_nrc = $this->merchantRepository->getNrcByMerchantId($value) ?? 'N/A';
        } else {
            $this->r_merchant_id = null;
            $this->r_name_string = $value;
        }
    }

    public function calculateTotalFee()
    {
        $this->total_fee = (float)$this->service_charge + (float)$this->short_deli_fee + (float)$this->final_deli_fee + (float)$this->transit_fee;
        $this->total_receive_fee = $this->total_fee - (float)$this->border_fee;
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['service_charge', 'short_deli_fee', 'final_deli_fee', 'border_fee', 'transit_fee'])) {
            $this->calculateTotalFee();
        }
    }

    public function save()
    {
        $rules = \App\Http\Requests\StoreCargoRequest::rules();
        $validated = $this->validate($rules);

        try {
            DB::beginTransaction();

            $masterData = $validated;
            unset($masterData['cargo_type_id'], $masterData['quantity']);
            $masterData['s_merchant_id'] = $this->s_merchant_id;
            $masterData['r_merchant_id'] = $this->r_merchant_id;
            $masterData['s_name_string'] = $this->s_name_string;
            $masterData['r_name_string'] = $this->r_name_string;

            $cargo = $this->cargoRepository->createCargo($masterData);

            if ($cargo) {
                foreach ($this->items as $item) {
                    CargoItem::create([
                        'cargo_id' => $cargo->id,
                        'quantity' => $item['quantity'],
                        'cargo_type_id' => $item['cargo_type_id'],
                        'detail' => $item['detail'] ?? null,
                        'notice' => $item['notice'] ?? null,
                    ]);
                }

                $this->carCargoRepository->create([
                    'cargo_id' => $cargo->id,
                    'status' => 'pending',
                    'assigned_at' => now(),
                ]);

                DB::commit();
                return redirect()->route('admin.cargos.index')->with('success', 'သိမ်းဆည်းပြီးပါပြီ');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    public function update()
    {
        $rules = \App\Http\Requests\StoreCargoRequest::rules();
        $rules['image'] = 'nullable';
        $validated = $this->validate($rules);

        try {
            DB::beginTransaction();

            $cargo = $this->cargoRepository->getCargoById($this->cargo_id);
            
            $masterData = $validated;
            unset($masterData['cargo_type_id'], $masterData['quantity']);
            $masterData['s_merchant_id'] = $this->s_merchant_id;
            $masterData['r_merchant_id'] = $this->r_merchant_id;
            $masterData['s_name_string'] = $this->s_name_string;
            $masterData['r_name_string'] = $this->r_name_string;

            $this->cargoRepository->updateCargo($cargo, $masterData);

            // Update Items (Delete old and insert new)
            CargoItem::where('cargo_id', $this->cargo_id)->delete();
            foreach ($this->items as $item) {
                CargoItem::create([
                    'cargo_id' => $this->cargo_id,
                    'quantity' => $item['quantity'],
                    'cargo_type_id' => $item['cargo_type_id'],
                    'detail' => $item['detail'] ?? null,
                    'notice' => $item['notice'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.cargos.index')->with('success', 'ပြုပြင်ပြီးပါပြီ');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    protected function generateCargoNumber() { return now()->format('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT); }

    public function generateVoucherNumber()
    {
        $latest = DB::table('cargos')->orderBy('voucher_number', 'desc')->first();
        return $latest ? str_pad(intval($latest->voucher_number) + 1, 5, '0', STR_PAD_LEFT) : '10001';
    }

    public function render()
    {
        return view('livewire.cargo-form');
    }
}
// namespace App\Livewire;

// use Carbon\Carbon;
// use App\Models\Gate;
// use Livewire\Component;
// use Livewire\WithFileUploads;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
// use App\Repositories\CityRepository;
// use App\Repositories\CargoRepository;
// use App\Repositories\MediaRepository;
// use App\Http\Requests\StoreCargoRequest;
// use App\Repositories\CarCargoRepository;
// use App\Repositories\MerchantRepository;
// use App\Repositories\CargoTypeRepository;
// use App\Repositories\GateRepository;
// use Illuminate\Validation\ValidationException;
// use App\Services\QrCodeService;
// use Illuminate\Support\Facades\Storage;

// class CargoForm extends Component
// {
//     // use WithFileUploads;
//     // public $cities = [];
//     // public $gates = [];
//     // public $merchants = [];
//     // public $cargotypes = [];
//     // public $fromGates, $toGates = [];
//     // public $s_nrc = 'N/A', $r_nrc = 'N/A';
//     // public $s_phone, $s_address, $r_phone, $r_address;
//     // public $s_name, $r_name = null;
//     // public $from_city_id, $to_city_id, $from_gate_id, $to_gate_id;
//     // protected $cityRepository;
//     // protected $merchantRepository;
//     // protected $cargoTypeRepository;
//     // protected $cargoRepository;
//     // protected $mediaRepository;
//     // protected $carCargoRepository;
//     // protected $gateRepository;
//     // public $cargo_no, $quantity, $cargo_type_id, $media_id, $status, $service_charge, $short_deli_fee, $final_deli_fee, $border_fee, $transit_fee, $total_fee, $to_pick_date, $voucher_number, $image;

//     // public $form_type = 'create';
//     // public $is_debt = false;
//     // public $cargo_id;

//     // public $s_merchant_id, $r_merchant_id, $s_name_string, $r_name_string;
//     // public $is_home = false;
//     // public $total_receive_fee;
//     // public $to_pick_date, $voucher_number, $image;
//     // public $qrcode_image;

//     // public $from_city_name, $to_city_name;

//     // public $cargo_detail_name;
//     // public $notice_message;

//     // public $cargo;
//     // protected $initial_cargo_id = null;
//     // public $is_transit = false;
//     // public $items = [];
    
//     use WithFileUploads;

//     public $cities = [];
//     public $gates = [];
//     public $merchants = [];
//     public $cargotypes = [];
//     public $fromGates = [], $toGates = []; // Initial value ထည့်ထားပါ
//     public $s_nrc = 'N/A', $r_nrc = 'N/A';
//     public $s_phone, $s_address, $r_phone, $r_address;
//     public $s_name, $r_name = null;
//     public $from_city_id, $to_city_id, $from_gate_id, $to_gate_id;

//     // Repositories
//     protected $cityRepository;
//     protected $merchantRepository;
//     protected $cargoTypeRepository;
//     protected $cargoRepository;
//     protected $mediaRepository;
//     protected $carCargoRepository;
//     protected $gateRepository;

//     // Cargo Main Fields (ဒီနေရာမှာ တစ်ခါပဲ ကြေညာပါ)
//     public $cargo_no, $quantity, $cargo_type_id, $media_id, $status = 'registered';
//     public $service_charge = 0, $short_deli_fee = 0, $final_deli_fee = 0;
//     public $border_fee = 0, $transit_fee = 0, $total_fee = 0, $total_receive_fee = 0;
    
//     // ဒီ ၄ ခုကို အောက်မှာ ထပ်မရေးပါနဲ့တော့
//     public $to_pick_date, $voucher_number, $image, $qrcode_image;

//     public $form_type = 'create';
//     public $is_debt = false;
//     public $cargo_id;

//     public $s_merchant_id, $r_merchant_id, $s_name_string, $r_name_string;
//     public $is_home = false;
//     public $is_transit = false;

//     public $from_city_name, $to_city_name;
//     public $cargo_detail_name;
//     public $notice_message;

//     public $cargo;
//     protected $initial_cargo_id = null;
//     public $items = [];

    
//     /**
//      * component boot
//      * 
//      * @return void
//      */
//     public function boot(CityRepository $cityRepository, MerchantRepository $merchantRepository, CargoTypeRepository $cargoTypeRepository, CargoRepository $cargoRepository, MediaRepository $mediaRepository, CarCargoRepository $carCargoRepository, GateRepository $gateRepository)
//     {
//         $this->cityRepository = $cityRepository;
//         $this->merchantRepository = $merchantRepository;
//         $this->cargoTypeRepository = $cargoTypeRepository;
//         $this->cargoRepository = $cargoRepository;
//         $this->mediaRepository = $mediaRepository;
//         $this->carCargoRepository = $carCargoRepository;
//         $this->gateRepository = $gateRepository;
//     }

//     /**
//      * component mount
//      * 
//      * @return void
//      */
//     public function mount($form_type = 'create', $cargo_id = null)
//     {
//         $this->cities = $this->cityRepository->getAllCities();
//         $this->gates = collect();
//         $this->fromGates = collect();
//         $this->toGates = collect();
//         $this->merchants = $this->merchantRepository->getAll();
//         $this->cargotypes = $this->cargoTypeRepository->getAllCargoTypes();
//         $this->status = 'registered';
//         $this->cargo_no = $this->generateCargoNumber();
//         $this->quantity = 1;
//         $this->service_charge = 0;
//         $this->short_deli_fee = 0;
//         $this->final_deli_fee = 0;
//         $this->border_fee = 0;
//         $this->transit_fee = 0;
//         $this->total_fee = 0;
//         $this->total_receive_fee = 0;
//         $this->to_pick_date = Carbon::now()->addDays(1)->format('Y-m-d');
//         $this->voucher_number = $this->generateVoucherNumber();
//         $this->form_type = $form_type;
//         $this->cargo_id = $cargo_id ?? null;
//         $this->initial_cargo_id = $this->cargo_id;
//         // if ($this->cargo_id) {
//         //     $cargo = $this->cargoRepository->getCargoById($this->cargo_id);
//         //     $this->cargo = $cargo;

//         //     if ($this->form_type === 'edit') {
//         //         $this->fill($cargo->toArray());
//         //         $this->s_name = ($cargo->s_merchant_id) ? $this->merchantRepository->getMerchantNameById($cargo->s_merchant_id) : $cargo->s_name_string;
//         //         $this->r_name = ($cargo->r_merchant_id) ? $this->merchantRepository->getMerchantNameById($cargo->r_merchant_id) : $cargo->r_name_string;

//         //         $this->fromGates = $this->gateRepository->getAllGates();
//         //         $this->toGates = $this->gateRepository->getAllGates();
//         //         $media = $this->mediaRepository->getMediaById($cargo->media_id);
//         //         $this->image = $media->path;
//         //     }
//         // }
//         if ($this->cargo_id) {
//             $cargo = $this->cargoRepository->getCargoById($this->cargo_id);
//             $this->cargo = $cargo;
    
//             if ($this->form_type === 'edit') {
//                 $this->fill($cargo->toArray());
                
//                 // --- ဒီနေရာမှာ items တွေကို define လုပ်ပေးရပါမယ် ---
//                 // Cargo model နဲ့ Items က relationship ချိတ်ထားရင် အောက်ပါအတိုင်း ရေးပါ
//                 $this->items = $cargo->items ?? collect(); 
//                 // -------------------------------------------
    
//                 $this->s_name = ($cargo->s_merchant_id) ? $this->merchantRepository->getMerchantNameById($cargo->s_merchant_id) : $cargo->s_name_string;
//                 $this->r_name = ($cargo->r_merchant_id) ? $this->merchantRepository->getMerchantNameById($cargo->r_merchant_id) : $cargo->r_name_string;
    
//                 $this->fromGates = $this->gateRepository->getAllGates();
//                 $this->toGates = $this->gateRepository->getAllGates();
                
//                 // Media စစ်ဆေးတဲ့နေရာမှာလည်း error ထပ်မတက်အောင် optional စစ်ထားသင့်ပါတယ်
//                 if ($cargo->media_id) {
//                     $media = $this->mediaRepository->getMediaById($cargo->media_id);
//                     $this->image = $media ? $media->path : null;
//                 }
//             }
//         }
//         $this->items = [
//             ['quantity' => '', 'cargo_type_id' => '', 'detail' => '', 'notice' => '']
//         ]; //new
//         if (empty($this->items)) {
//             $this->addItem(); 
//         }//new
//     }
//     public function addItem() {
//     // ခလုတ်နှိပ်ရင် Array ထဲကို item အသစ်တစ်ခု ထည့်ပေးမယ်
//     $this->items[] = ['quantity' => '', 'cargo_type_id' => '', 'detail' => '', 'notice' => ''];
//     }
    
//     public function removeItem($index) {
//         unset($this->items[$index]);
//         $this->items = array_values($this->items); // index ပြန်စီရန်
//     }

//     /**
//      * Ensure state persists across Livewire hydration cycles
//      */
//     public function hydrate()
//     {
//         if (empty($this->cargo_id) && !empty($this->initial_cargo_id)) {
//             $this->cargo_id = $this->initial_cargo_id;
//         }
//     }

//     /**
//      * component updated selected from city
//      * 
//      * @param int $cityId
//      * @return void
//      */
//     public function updatedFromCityId($cityId)
//     {
//         $this->fromGates = Gate::where('city_id', $cityId)->orderBy('name_my')->get();
//         $this->from_gate_id = null;
//         $this->from_city_name = $this->cityRepository->getCityNameById($cityId);
//     }
//     // public function updatedFromCityId($value)
//     // {
//     //     if ($value) {
//     //         $this->cityName = $this->cityRepository->getCityNameById($value);
//     //     } else {
//     //         $this->cityName = ''; // ID မရှိရင် အမည်ကို အလွတ်ထားမယ်
//     //     }
//     // }

//     /**
//      * component updated selected to city
//      * 
//      * @param int $cityId
//      * @return void
//      */
//     public function updatedToCityId($cityId)
//     {
//         $this->toGates = Gate::where('city_id', $cityId)->orderBy('name_my')->get();
//         $this->to_gate_id = null;
//         $this->to_city_name = $this->cityRepository->getCityNameById($cityId);
//     }

//     /**
//      *
//      */
//     public function updatedToGateId($gateId)
//     {
//         if (!$gateId) {
//             $this->is_transit = false;
//             return;
//         }
//         $gate = $this->gateRepository->getGateById($gateId);
//         if (!$gate) {
//             $this->is_transit = false;
//             return;
//         }
//         $is_transit = $gate->is_transit;
//         $this->is_transit = $is_transit;
//     }

//     /**
//      * component updated selected s name
//      * 
//      * @param int $s_name
//      * @return void
//      */
//     public function updatedSName($s_name)
//     {
//         if (is_numeric($s_name)) {
//             $this->s_merchant_id = $s_name;
//             if ($this->merchantRepository) {
//                 $this->s_name = $this->merchantRepository->getMerchantNameById($s_name);
//                 $this->s_phone = $this->merchantRepository->getPhoneByMerchantId($s_name);
//                 $s_nrc = $this->merchantRepository->getNrcByMerchantId($s_name);
//                 $this->s_nrc = $s_nrc ?? 'N/A';
//                 $this->s_address = $this->merchantRepository->getAddressByMerchantId($s_name);
//             }
//         } else {
//             $this->s_merchant_id = null;
//             $this->s_name_string = $s_name;
//         }
//     }

//     /**
//      * component updated selected r name
//      * 
//      * @param int $r_name
//      * @return void
//      */
//     public function updatedRName($r_name)
//     {
//         if (is_numeric($r_name)) {
//             $this->r_merchant_id = $r_name;
//             if ($this->merchantRepository) {
//                 $this->r_name = $this->merchantRepository->getMerchantNameById($r_name);
//                 $this->r_phone = $this->merchantRepository->getPhoneByMerchantId($r_name);
//                 $r_nrc = $this->merchantRepository->getNrcByMerchantId($r_name);
//                 $this->r_nrc = $r_nrc ?? 'N/A';
//                 $this->r_address = $this->merchantRepository->getAddressByMerchantId($r_name);
//             }
//         } else {
//             $this->r_merchant_id = null;
//             $this->r_name_string = $r_name;
//         }
//     }

//     /**
//      * component clear form
//      * 
//      * @return void
//      */
//     public function clearForm()
//     {
//         $this->reset([
//             's_name',
//             'r_name',
//             'from_city_id',
//             'to_city_id',
//             'from_gate_id',
//             'to_gate_id',
//             's_phone',
//             's_nrc',
//             's_address',
//             'r_phone',
//             'r_nrc',
//             'r_address',
//             'cargo_no',
//             'quantity',
//             'cargo_type_id',
//             'cargo_detail_name',
//             'notice_message',
//             'media_id',
//             'status',
//             'service_charge',
//             'short_deli_fee',
//             'final_deli_fee',
//             'border_fee',
//             'transit_fee',
//             'total_fee',
//             'to_pick_date',
//             'voucher_number',
//             'image',
//             'from_city_name',
//             'to_city_name',
//             'image',
//         ]);
//     }

//     /**
//      * Cargo Number Generate Function
//      */
//     protected function generateCargoNumber()
//     {
//         $date = now()->format('Y');
//         $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
//         return "{$date}-{$random}";
//     }

//     /**
//      * component generate voucher number
//      * 
//      * @return string
//      */
//     public function generateVoucherNumber()
//     {
//         // Get the latest voucher number and increment
//         $latestVoucher = DB::table('cargos')
//             ->select('voucher_number')
//             ->orderBy('voucher_number', 'desc')
//             ->first();

//         if ($latestVoucher) {
//             $lastNumber = intval($latestVoucher->voucher_number);
//             $serial = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
//         } else {
//             $serial = '10001';
//         }

//         return $serial;
//     }


//     /**
//      * component updated
//      * 
//      * @param string $propertyName
//      * @return void
//      */
//     public function updated($propertyName)
//     {
//         if (in_array($propertyName, ['service_charge', 'short_deli_fee', 'final_deli_fee', 'border_fee', 'transit_fee'])) {
//             $this->calculateTotalFee();
//         }
//     }

//     /**
//      * component calculate total fee
//      * 
//      * @return void
//      */
//     private function calculateTotalFee()
//     {
//         $this->total_receive_fee =
//             (floatval($this->service_charge) -
//                 floatval($this->border_fee)) +
//             floatval($this->short_deli_fee) +
//             floatval($this->final_deli_fee) +
//             floatVal($this->transit_fee);
//         $this->total_fee = (floatval($this->service_charge) +
//             floatval($this->short_deli_fee) +
//             floatval($this->final_deli_fee) +
//             floatVal($this->transit_fee));
//     }

//     /**
//      * component updated is home
//      * 
//      * @param int $is_home
//      * @return void
//      */
//     public function updatedIsHome($is_home)
//     {
//         $this->is_home = $is_home;
//     }


//     /**
//      * component save
//      * 
//      * @return void
//      */
//     // public function save()
//     // {
//     //     try {
//     //         DB::beginTransaction();
//     //         try {
//     //             $rules = StoreCargoRequest::rules();
//     //             $validated = $this->validate($rules);
//     //             $validated['s_nrc'] = $validated['s_nrc'] ?? $this->s_nrc;
//     //             $validated['r_nrc'] = $validated['r_nrc'] ?? $this->r_nrc;
//     //             $qrcodeService = new QrCodeService();
//     //             $path = $qrcodeService->saveQrcode('test');
//     //             $this->qrcode_image = $path;
//     //         } catch (ValidationException $e) {
//     //             $this->setErrorBag($e->validator->errors());
//     //             return;
//     //         }
//     //         if ($this->image) {
//     //             $media_id = $this->mediaRepository->create($this->image, 'cargos');
//     //             if (!$media_id) {
//     //                 return redirect()->route('admin.cargos.index');
//     //             }
//     //             $validated['media_id'] = $media_id;
//     //         }
//     //         unset($validated['s_name']);
//     //         unset($validated['r_name']);
//     //         $validated['s_merchant_id'] = $this->s_merchant_id;
//     //         $validated['r_merchant_id'] = $this->r_merchant_id;
//     //         $validated['s_name_string'] = $this->s_name_string;
//     //         $validated['r_name_string'] = $this->r_name_string;
//     //         $validated['qrcode_image'] = $this->qrcode_image;
//     //         $cargo = $this->cargoRepository->createCargo($validated);
//     //         $carCargo = $this->carCargoRepository->create([
//     //             'car_id' => null,
//     //             'cargo_id' => $cargo->id,
//     //             'user_id' => null,
//     //             'status' => 'pending',
//     //             'assigned_at' => now(),
//     //             'arrived_at' => null,
//     //         ]);
//     //         if ($cargo) {
//     //             DB::commit();
//     //             return redirect()->route('admin.cargos.index');
//     //         } else {
//     //             DB::rollBack();
//     //             $this->setErrorBag($cargo->errors());
//     //             return;
//     //         }
//     //     } catch (\Illuminate\Validation\ValidationException $e) {
//     //         DB::rollBack();
//     //         $this->setErrorBag($e->validator->errors());
//     //         return;
//     //     }
//     // }
//     // public function save()
//     // {
//     //     $rules = StoreCargoRequest::rules();
//     //     $validated = $this->validate($rules);
    
//     //     try {
//     //         DB::beginTransaction();
    
//     //         // ၁။ Cargo Master ကို သိမ်းပါ
//     //         $cargo = $this->cargoRepository->createCargo($validated);
    
//     //         if ($cargo) {
//     //             // ၂။ ကုန်ပစ္စည်းစာရင်းများကို Loop ပတ်ပြီး CargoItem ထဲသိမ်းပါ
//     //             foreach ($this->items as $item) {
//     //                 \App\Models\CargoItem::create([
//     //                     'cargo_id'      => $cargo->id,
//     //                     'quantity'      => $item['quantity'],
//     //                     'cargo_type_id' => $item['cargo_type_id'],
//     //                     'detail'        => $item['detail'] ?? null,
//     //                     'notice'        => $item['notice'] ?? null,
//     //                 ]);
//     //             }
    
//     //             // ၃။ Car Cargo Assignment
//     //             $this->carCargoRepository->create([
//     //                 'cargo_id'    => $cargo->id,
//     //                 'status'      => 'pending',
//     //                 'assigned_at' => now(),
//     //             ]);
    
//     //             DB::commit();
//     //             return redirect()->route('admin.cargos.index');
//     //         }
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         session()->flash('error', $e->getMessage());
//     //     }
//     // }
//     // public function save()
//     // {
//     //     $rules = StoreCargoRequest::rules();
//     //     // Master table မှာ မပါတော့တဲ့ column တွေကို validation logic ထဲက ခဏ ဖယ်ထားမယ်
//     //     $validated = $this->validate($rules);
    
//     //     try {
//     //         DB::beginTransaction();
    
//     //         // SQL Error မတက်အောင် Master table (cargos) ထဲ မထည့်ချင်တဲ့ field တွေကို ဖယ်ထုတ်ခြင်း
//     //         // အခု phpMyAdmin မှာ Null ပေးထားလို့ ဒီ logic က အလုပ်လုပ်ပါလိမ့်မယ်
//     //         unset($validated['cargo_type_id']);
//     //         unset($validated['quantity']);
    
//     //         // ၁။ Cargo Master ကို အရင်သိမ်းပါ
//     //         $cargo = $this->cargoRepository->createCargo($validated);
    
//     //         if ($cargo) {
//     //             // ၂။ ကုန်ပစ္စည်းစာရင်းများကို Loop ပတ်ပြီး CargoItem table ထဲ အကုန်သိမ်းပါ
//     //             foreach ($this->items as $item) {
//     //                 \App\Models\CargoItem::create([
//     //                     'cargo_id'      => $cargo->id,
//     //                     'quantity'      => $item['quantity'],
//     //                     'cargo_type_id' => $item['cargo_type_id'],
//     //                     'detail'        => $item['detail'] ?? null,
//     //                     'notice'        => $item['notice'] ?? null,
//     //                 ]);
//     //             }
    
//     //             // ၃။ Car Assignment အပိုင်း
//     //             $this->carCargoRepository->create([
//     //                 'cargo_id'    => $cargo->id,
//     //                 'status'      => 'pending',
//     //                 'assigned_at' => now(),
//     //             ]);
    
//     //             DB::commit();
//     //             return redirect()->route('admin.cargos.index');
//     //         }
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         // တကယ်လို့ error ထပ်တက်ရင် ဘာကြောင့်လဲဆိုတာ အတိအကျ သိရအောင် dd ပြန်ပြထားပါ
//     //         dd("Database Save Error: " . $e->getMessage());
//     //     }
//     // }
//     public function save()
//     {
//         // ၁။ Validation အရင်စစ်ပါ
//         $rules = \App\Http\Requests\StoreCargoRequest::rules();
//         $validated = $this->validate($rules); // ဒီမှာ $validated ကို သတ်မှတ်ထားပါတယ်
    
//         try {
//             DB::beginTransaction();
    
//             // ၂။ Master Table (cargos) အတွက် Data ပြင်ဆင်ခြင်း
//             $masterData = $validated;
//             unset($masterData['cargo_type_id']); // master table မှာ မပါချင်တာတွေကို ဖယ်ထုတ်ပါ
//             unset($masterData['quantity']);
    
//             // ၃။ Cargo Master ကို သိမ်းပါ ($validated အစား $masterData ကို သုံးရပါမယ်)
//             $cargo = $this->cargoRepository->createCargo($masterData);
    
//             if ($cargo) {
//                 // ၄။ ကုန်ပစ္စည်းစာရင်းများကို Loop ပတ်ပြီး CargoItem ထဲသိမ်းပါ
//                 foreach ($this->items as $item) {
//                     \App\Models\CargoItem::create([
//                         'cargo_id'      => $cargo->id,
//                         'quantity'      => (int)$item['quantity'],
//                         'cargo_type_id' => $item['cargo_type_id'],
//                         'detail'        => $item['detail'] ?? null,
//                         'notice'        => $item['notice'] ?? null,
//                     ]);
//                 }
    
//                 // ၅။ Car Assignment
//                 $this->carCargoRepository->create([
//                     'cargo_id'    => $cargo->id,
//                     'status'      => 'pending',
//                     'assigned_at' => now(),
//                 ]);
    
//                 DB::commit();
                
//                 session()->flash('success', 'ဘောက်ချာအမှတ် ' . $cargo->voucher_number . ' သိမ်းဆည်းပြီးပါပြီ။');
//                 return redirect()->route('admin.cargos.index');
//             }
//         } catch (\Exception $e) {
//             DB::rollBack();
//             // Error တက်ရင် ဘာကြောင့်လဲဆိုတာ မြင်ရအောင် dd ပြပါ
//             dd("Final Save Error: " . $e->getMessage());
//         }
//     }
//     /**
//      * component update
//      * 
//      * @return void
//      */
//     public function update()
//     {
//         if (empty($this->cargo_id)) {
//             $routeId = optional(request()->route())->parameter('cargo')
//                 ?? optional(request()->route())->parameter('id')
//                 ?? optional(request()->route())->parameter('cargo_id');
//             $inputId = request()->input('cargo_id');
//             $recovered = $this->initial_cargo_id
//                 ?? $inputId
//                 ?? $routeId
//                 ?? ($this->cargo->id ?? null);
//             if ($recovered) {
//                 $this->cargo_id = $recovered;
//             }
//         }
        
//         if (!$this->cargo_id) {
//             session()->flash('error', 'Cargo ID is missing');
//             return;
//         }
        
//         try {
//             DB::beginTransaction();
//             try {
//                 $rules = StoreCargoRequest::rules();
//                 $rules['image'] = 'nullable';
//                 $validated = $this->validate($rules);
//             } catch (ValidationException $e) {
//                 $this->setErrorBag($e->validator->errors());
//                 return;
//             }
            
//             if ($this->image && is_object($this->image)) {
//                 $media_id = $this->mediaRepository->update($this->image, 'cargos', $this->cargo_id);
//                 if (!$media_id) {
//                     session()->flash('error', 'Failed to update image');
//                     return redirect()->route('admin.cargos.index');
//                 }
//                 $validated['media_id'] = $media_id;
//             }
//             $cargo = $this->cargoRepository->getCargoById($this->cargo_id);
//             if (!$cargo) {
//                 DB::rollBack();
//                 $this->setErrorBag(['cargo_id' => ['Cargo not found.']]);
//                 return;
//             }
//             unset($validated['s_name']);
//             unset($validated['r_name']);
//             $validated['s_name_string'] = $this->s_name_string;
//             $validated['r_name_string'] = $this->r_name_string;
//             $validated['s_merchant_id'] = $this->s_merchant_id;
//             $validated['r_merchant_id'] = $this->r_merchant_id;
//             $updatedCargo = $this->cargoRepository->updateCargo($cargo, $validated);
//             if ($updatedCargo) {
//                 DB::commit();
//                 return redirect()->route('admin.cargos.index');
//             } else {
//                 DB::rollBack();
//                 $this->setErrorBag(['update' => ['Update failed.']]);
//                 return;
//             }
//         } catch (\Illuminate\Validation\ValidationException $e) {
//             DB::rollBack();
//             $this->setErrorBag($e->validator->errors());
//             return;
//         }
//     }

//     /**
//      * component cancel
//      * 
//      * @return void
//      */
//     public function cancel()
//     {
//         return redirect()->route('admin.cargos.index');
//     }
//     /**
//      * component render
//      * 
//      * @return view
//      */
//     public function render()
//     {
//         return view('livewire.cargo-form');
//     }
// }

