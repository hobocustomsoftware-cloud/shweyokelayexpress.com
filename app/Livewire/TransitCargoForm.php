<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Repositories\CityRepository;
use App\Repositories\CargoRepository;
use App\Repositories\MediaRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\CargoTypeRepository;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreTransitCargoRequest;
use App\Repositories\Interfaces\MerchantRepositoryInterface;
use App\Repositories\Interfaces\TransitCargoRepositoryInterface;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Services\QrCodeService;

class TransitCargoForm extends Component
{
    use WithFileUploads;
    public $cities = [];
    public $gates = [];
    public $cargotypes = [];
    public $fromGates, $toGates = [];
    public $s_nrc = 'N/A', $r_nrc = 'N/A';
    public $s_phone, $s_address, $r_phone, $r_address;
    public $s_name, $r_name = null;
    public $from_city, $to_city, $from_gate, $to_gate;
    protected $cityRepository;
    protected $cargoTypeRepository;
    protected $mediaRepository;
    protected $transitCargoRepository;
    protected $merchantRepository;
    protected $carRepository;
    public $cargo_no, $quantity, $cargo_type_id, $media_id, $image, $status, $service_charge, $short_deli_fee, $border_fee, $total_fee, $instant_cash, $loan_cash, $to_pick_date, $voucher_number;
    public $is_short_fee_paid = false;
    public $is_debt = false;
    public $form_type = 'create';
    public $merchants = [];
    public $s_merchant_id, $r_merchant_id;
    public $s_name_string, $r_name_string;
    public $car_id;
    public $cars = [];
    public $qrcode_image;

    /**
     * component boot
     * 
     * @return void
     */
    public function boot(CityRepository $cityRepository, CargoTypeRepository $cargoTypeRepository, MediaRepository $mediaRepository, TransitCargoRepositoryInterface $transitCargoRepository, MerchantRepositoryInterface $merchantRepository, CarRepositoryInterface $carRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->cargoTypeRepository = $cargoTypeRepository;
        $this->mediaRepository = $mediaRepository;
        $this->transitCargoRepository = $transitCargoRepository;
        $this->merchantRepository = $merchantRepository;
        $this->carRepository = $carRepository;
    }

    /**
     * component mount
     * 
     * @return void
     */
    public function mount($form_type = 'create')
    {
        $this->cities = $this->cityRepository->getAllCities();
        $this->gates = collect();
        $this->fromGates = collect();
        $this->toGates = collect();
        $this->cargotypes = $this->cargoTypeRepository->getAllCargoTypes();
        $this->status = 'registered';
        $this->cargo_no = $this->generateCargoNumber();
        $this->quantity = 1;
        $this->service_charge = 0;
        $this->short_deli_fee = 0;
        $this->border_fee = 0;
        $this->total_fee = 0;
        $this->instant_cash = 0;
        $this->loan_cash = 0;
        $this->to_pick_date = Carbon::now()->addDays(1)->format('Y-m-d');
        $this->voucher_number = $this->generateVoucherNumber();
        $this->form_type = $form_type;
        $this->merchants = $this->merchantRepository->getAll();
        $this->cars = $this->carRepository->getList()->get();
    }

    /**
     * component updated selected from city
     * 
     * @param int $cityId
     * @return void
     */
    public function updatedFromCity($cityId)
    {
        $this->fromGates = Gate::where('city_id', $cityId)->orderBy('name_my')->get();
        $this->from_gate = null;
    }

    /**
     * component updated selected to city
     * 
     * @param int $cityId
     * @return void
     */
    public function updatedToCity($cityId)
    {
        $this->toGates = Gate::where('city_id', $cityId)->orderBy('name_my')->get();
        $this->to_gate = null;
    }

    /**
     * component updated selected s name
     * 
     * @param int $s_name
     * @return void
     */
    public function updatedSName($s_name)
    {
        if (is_numeric($s_name)) {
            $this->s_merchant_id = $s_name;
            if ($this->merchantRepository) {
                $this->s_name = $this->merchantRepository->getMerchantNameById($s_name);
                $this->s_phone = $this->merchantRepository->getPhoneByMerchantId($s_name);
                $s_nrc = $this->merchantRepository->getNrcByMerchantId($s_name);
                $this->s_nrc = $s_nrc ?? 'N/A';
                $this->s_address = $this->merchantRepository->getAddressByMerchantId($s_name);
            }
        }else{
            $this->s_merchant_id = null;
            $this->s_name_string = $s_name;
        }
    }

    /**
     * component updated selected r name
     * 
     * @param int $r_name
     * @return void
     */
    public function updatedRName($r_name)
    {
        if (is_numeric($r_name)) {
            $this->r_merchant_id = $r_name;
            if ($this->merchantRepository) {
                $this->r_name = $this->merchantRepository->getMerchantNameById($r_name);
                $this->r_phone = $this->merchantRepository->getPhoneByMerchantId($r_name);
                $r_nrc = $this->merchantRepository->getNrcByMerchantId($r_name);
                $this->r_nrc = $r_nrc ?? 'N/A';
                $this->r_address = $this->merchantRepository->getAddressByMerchantId($r_name);
            }
        }else{
            $this->r_merchant_id = null;
            $this->r_name_string = $r_name;
        }
    }

    /**
     * component clear form
     * 
     * @return void
     */
    public function clearForm()
    {
        $this->reset([
            's_name',
            'r_name',
            's_name_string',
            'r_name_string',
            's_merchant_id',
            'r_merchant_id',
            'from_city',
            'to_city',
            'from_gate',
            'to_gate',
            's_phone',
            's_nrc',
            's_address',
            'r_phone',
            'r_nrc',
            'r_address',
            'cargo_no',
            'quantity',
            'cargo_type_id',
            'media_id',
            'status',
            'service_charge',
            'to_pick_date',
            'voucher_number',
            'is_short_fee_paid',
            'image',
            'is_debt',
        ]);
    }

    /**
     * Cargo Number Generate Function
     */
    protected function generateCargoNumber()
    {
        $date = now()->format('Y');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "{$date}-{$random}";
    }

    public function generateVoucherNumber()
    {
        // Get the latest voucher number and increment
        $latestVoucher = DB::table('transit_cargos')
            ->orderBy('voucher_number', 'desc')
            ->first();

        if ($latestVoucher) {
            $lastNumber = intval($latestVoucher->voucher_number);
            $serial = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $serial = '10001';
        }

        return $serial;
    }

    /**
     * component save
     * 
     * @return void
     */
    public function save()
    {
        try {
            DB::beginTransaction();
            try {
                $rules = StoreTransitCargoRequest::rules();
                $validated = $this->validate($rules);
                $validated['s_nrc'] = $validated['s_nrc'] ?? $this->s_nrc;
                $validated['r_nrc'] = $validated['r_nrc'] ?? $this->r_nrc;
                $qrcodeService = new QrcodeService();
                $cargo_data = json_encode([
                    'cargo_no' => $this->cargo_no,
                    'voucher_number' => $this->voucher_number,
                    'sender' => $this->s_name ?? $this->s_name_string,
                    'receiver' => $this->r_name ?? $this->r_name_string,
                    'from' => $this->from_city_name ?? '',
                    'to' => $this->to_city_name ?? '',
                    'quantity' => $this->quantity,
                    'cargo_type' => $this->cargo_type_id,
                    'service_charge' => $this->service_charge,
                    'to_pick_date' => $this->to_pick_date,
                ]);
                $path = $qrcodeService->saveQrcode($cargo_data);
                $this->qrcode_image = $path;
            } catch (ValidationException $e) {
                $this->setErrorBag($e->validator->errors());
                return;
            }
            if ($this->image) {
                $media_id = $this->mediaRepository->create($this->image, 'transit_cargos');
                if (!$media_id) {
                    return redirect()->route('admin.transit_cargos.index');
                }
                $validated['media_id'] = $media_id;
            }
            $validated['s_merchant_id'] = $this->s_merchant_id;
            $validated['r_merchant_id'] = $this->r_merchant_id;
            $validated['s_name_string'] = $this->s_name_string;
            $validated['r_name_string'] = $this->r_name_string;
            unset($validated['s_name']);
            unset($validated['r_name']);
            $validated['qrcode_image'] = $this->qrcode_image;
            $transitCargo = $this->transitCargoRepository->create($validated);
            if ($transitCargo) {
                DB::commit();
                return redirect()->route('admin.transit_cargos.index');
            } else {
                DB::rollBack();
                $this->setErrorBag($transitCargo->errors());
                return;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            $this->setErrorBag($e->validator->errors());
            return;
        }
    }

    /**
     * component cancel
     * 
     * @return void
     */
    public function cancel()
    {
        return redirect()->route('admin.transit_cargos.index');
    }

    /**
     * component render
     * 
     * @return view
     */
    public function render()
    {
        return view('livewire.transit-cargo-form');
    }

}
