<?php

namespace App\Livewire;

use App\Repositories\CityRepository;
use App\Repositories\CarRepository;
use App\Repositories\DayOffDateRepository;
use Livewire\Component;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CarRegistrationForm extends Component
{
    public $cities;
    public $number;
    public $departure_date;
    public $from;
    public $to;
    public $driver_name;
    public $driver_phone_number;
    public $assistant_driver_name;
    public $assistant_driver_phone;
    public $spare_name;
    public $spare_phone;
    public $crew_name;
    public $crew_phone;

    protected $cityRepository;
    protected $carRepository;
    protected $dayOffDateRepository;

    public $id;
    public $form_type;
    public $departure_time;
    public $day_off_date;
    public $reason;

    public function boot(CityRepository $cityRepository, CarRepository $carRepository, DayOffDateRepository $dayOffDateRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->carRepository = $carRepository;
        $this->dayOffDateRepository = $dayOffDateRepository;
    }

    public function mount($form_type, $id = null)
    {
        $this->cities = $this->cityRepository->getAllCities();
        $this->form_type = $form_type;

        if ($id) {
            $this->id = $id;
            $car = $this->carRepository->getById($id);

            if (!$car) {
                return redirect()->route('admin.cars.index')->with('error', 'ကားအချက်အလက်များ မတွေ့ရှိပါ။');
            }

            if ($form_type == 'edit') {
                $this->fill($car->toArray());
                
                // Day off dates ကို ဆွဲထုတ်ပြီး String ပြောင်းမယ်
                $dayOff = $this->dayOffDateRepository->getByCarId($id)->first();
                if ($dayOff) {
                    $dates = is_array($dayOff->day_off_date) ? $dayOff->day_off_date : [];
                    $this->day_off_date = implode(', ', $dates);
                    $this->reason = $dayOff->reason;
                } else {
                    $this->day_off_date = '';
                }
            }
        }
    }

    public function updatedFrom($from)
    {
        $this->dispatch('reinitDatePickers');
    }

    public function updatedTo($to)
    {
        $this->dispatch('reinitDatePickers');
    }

    public function save()
    {
        try {
            $rules = (new StoreCarRequest())->rules();
            $validated = $this->validate($rules);

            // Create car (exclude day_off_date logic)
            $carData = $validated;
            unset($carData['day_off_date']);
            
            $car = $this->carRepository->create($carData);

            if ($car) {
                // Day off dates သွင်းမယ်
                $datesInput = $validated['day_off_date'] ?? '';
                $dates = array_values(array_filter(array_map('trim', explode(',', (string)$datesInput))));

                $this->dayOffDateRepository->create([
                    'car_id' => $car->id,
                    'day_off_date' => $dates,
                    'reason' => $this->reason ?? ''
                ]);

                return redirect()->route('admin.cars.index')->with('success', 'ကားအချက်အလက်များ အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
            }

            return redirect()->back()->with('error', 'ကားအချက်အလက်သွင်းခြင်း မအောင်မြင်ပါ။');

        } catch (ValidationException $e) {
            Log::error('Car Creation Validation failed', ['errors' => $e->errors()]);
            throw $e;
        }
    }

    public function update()
    {
        try {
            $rules = (new StoreCarRequest())->rules();
            $validated = $this->validate($rules);

            $carData = $validated;
            unset($carData['day_off_date']);
            
            $car = $this->carRepository->update($this->id, $carData);

            if ($car) {
                $datesInput = $validated['day_off_date'] ?? '';
                $dates = array_values(array_filter(array_map('trim', explode(',', (string)$datesInput))));

                $existing = $this->dayOffDateRepository->getByCarId($this->id)->first();
                
                $dayOffData = [
                    'car_id' => $this->id,
                    'day_off_date' => $dates,
                    'reason' => $this->reason ?? ''
                ];

                if ($existing) {
                    $this->dayOffDateRepository->update($existing->id, $dayOffData);
                } else {
                    $this->dayOffDateRepository->create($dayOffData);
                }

                return redirect()->route('admin.cars.index')->with('success', 'ကားအချက်အလက်များ အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
            }

            return redirect()->back()->with('error', 'ပြုပြင်ခြင်း မအောင်မြင်ပါ။');

        } catch (ValidationException $e) {
            Log::error('Car Update Validation failed', ['errors' => $e->errors()]);
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.car-registration-form');
    }
}