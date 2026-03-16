<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Repositories\CarRepository;
use App\Repositories\CarCargoRepository;
use Illuminate\Support\Facades\Auth;

class CarChoosingForm extends Component
{
    protected $cars;
    protected $carRepository;
    protected $carCargoRepository;
    public $car_numbers;
    public $departure_date;
    public $car_id;
    public $cargo_id;
    public $status = 'assigned';
    public $assigned_at;
    public $user_id;
    public $arrived_at;

    /**
     * Boot
     */
    public function boot(CarRepository $carRepository, CarCargoRepository $carCargoRepository)
    {
        $this->carRepository = $carRepository;
        $this->carCargoRepository = $carCargoRepository;
        $this->car_numbers = collect();
        $this->assigned_at = Carbon::now();
        $this->user_id = Auth::user()->id;
    }

    /**
     * mount component
     */
     /**
     * mount component
     */
    public function mount($cargo_id)
    {
        $this->cargo_id = $cargo_id;
        $this->cars = $this->carRepository->getList()->get();
        $this->car_numbers = $this->cars->pluck('id', 'number')->toArray();

        if ($cargo_id) {
            // repository ကနေ data ကို အရင်ယူထားမယ်
            $carCargo = $this->carCargoRepository->getById($cargo_id);

            // data ရှိမှသာ ရှေ့ဆက်မယ် (Null safe check)
            if ($carCargo) {
                $this->car_id = $carCargo->car_id;
                $this->departure_date = $carCargo->departure_date;

                if ($this->car_id) {
                    $this->car_numbers = $this->cars->where('id', $this->car_id)
                                             ->pluck('id', 'number')
                                             ->toArray();
                }
            } else {
                // Record မရှိရင် default တန်ဖိုးတွေပေးထားမယ်
                $this->car_id = null;
                $this->departure_date = null;
            }
        }
    }
    // public function mount($cargo_id)
    // {
    //     $this->cargo_id = $cargo_id;
    //     $this->cars = $this->carRepository->getList()->get();
    //     $this->car_numbers = $this->cars->pluck('id', 'number')->toArray();
    //     if ($cargo_id){
    //         $this->car_id = $this->carCargoRepository->getById($cargo_id)->car_id;
    //         if ($this->car_id){
    //             $this->car_numbers = $this->cars->where('id', $this->car_id)->pluck('id', 'number')->toArray();
    //         }
    //         $this->departure_date = $this->carCargoRepository->getById($cargo_id)->departure_date;
    //     }
    // }

    public function updatedDepartureDate($date)
    {
        if ($date) {
            $this->cars = $this->carRepository->getList(['dayOff'])->get();

            $filter_cars = $this->cars->filter(function ($car) use ($date) {
                $day_off_dates = collect($car->dayOff)
                    ->pluck('day_off_date')
                    ->flatten()
                    ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
                    ->toArray();
                return !in_array($date, $day_off_dates);
            });
            $this->car_numbers = $filter_cars->pluck('id', 'number')->toArray();
        } else {
            $this->car_numbers = [];
        }
    }

    /**
     * Back to putin cargos index
     */
    public function back()
    {
        return redirect()->route('admin.putin_cargos.index');
    }

    /**
     * Save
     */
    public function save()
    {
        $this->validate([
            'car_id' => 'required|exists:cars,id',
        ]);
        $carCargoData = [
            'car_id' => $this->car_id,
            'cargo_id' => $this->cargo_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'departure_date' => $this->departure_date,
            'assigned_at' => $this->assigned_at,
            'arrived_at' => $this->arrived_at,
        ];
        $this->carCargoRepository->update($this->cargo_id, $carCargoData);
        return redirect()->route('admin.putin_cargos.index');
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.car-choosing-form');
    }
}
