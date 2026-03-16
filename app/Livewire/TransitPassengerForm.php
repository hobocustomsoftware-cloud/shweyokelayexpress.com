<?php

namespace App\Livewire;

use App\Repositories\CarRepository;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransitPassengerRequest;
use App\Repositories\TransitPassengerRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TransitPassengerForm extends Component
{

    public $name;
    public $phone;
    public $address;
    public $nrc;
    public $car_id;
    public $seat_number;
    public $price = 0;
    public $transit_cargo_id;
    public $user_id;
    public $is_paid;
    public $status = 'active';
    public $voucher_number;

    public $cars;

    protected $carRepository;
    protected $transitPassengerRepository;

    public $form_type = 'create';
    public $id;

    public function boot(CarRepository $carRepository, TransitPassengerRepository $transitPassengerRepository)
    {
        $this->carRepository = $carRepository;
        $this->transitPassengerRepository = $transitPassengerRepository;
    }

    public function mount($form_type, $id)
    {
        $this->cars = $this->carRepository->getList()->get();
        $this->voucher_number = generateTransitPassengerVoucherNumber();

        if ($form_type == 'edit') {
            $this->fill($this->transitPassengerRepository->getById($id));
        }
    }

    public function validateSeatNumber()
    {
        $car_id = $this->car_id;
        $seat_number = $this->seat_number;
        $duplicated = $this->transitPassengerRepository->getBySeatNumber($seat_number, $car_id);
        if ($duplicated) {
            $this->seat_number = null;
            $this->addError('seat_number', 'Seat number already exists on this car');
        }else{
            $this->resetErrorBag('seat_number');
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();

            try {
                // Adapt rules to component property names
                $rules = (new StoreTransitPassengerRequest())->rules();
                $validated = $this->validate($rules);

                $this->transitPassengerRepository->create($validated);

                DB::commit();
                return redirect()->route('admin.transit_passengers.index');
            } catch (ValidationException $e) {
                DB::rollBack();

                // Log validation errors
                Log::error('Validation failed', [
                    'errors' => $e->errors(),
                ]);

                $this->setErrorBag($e->validator->errors());
                return;
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            // Log unexpected errors
            Log::error('Unexpected error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);

            // Optionally set a generic error for UI
            $this->addError('system', 'An unexpected error occurred. Please try again.');

            return;
        }
    }

    public function clearForm()
    {
        $this->reset();
    }

    public function cancel()
    {
        return redirect()->route('admin.transit_passengers.index');
    }

    public function update()
    {
        try {
            DB::beginTransaction();

            try {
                // Adapt rules to component property names
                $rules = (new StoreTransitPassengerRequest())->rules();
                $validated = $this->validate($rules);

                $this->transitPassengerRepository->update($this->id, $validated);

                DB::commit();
                return redirect()->route('admin.transit_passengers.index');
            } catch (ValidationException $e) {
                DB::rollBack();

                // Log validation errors
                Log::error('Validation failed', [
                    'errors' => $e->errors(),
                ]);

                $this->setErrorBag($e->validator->errors());
                return;
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            // Log unexpected errors
            Log::error('Unexpected error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);

            // Optionally set a generic error for UI
            $this->addError('system', 'An unexpected error occurred. Please try again.');

            return;
        }
    }

    public function render()
    {
        return view('livewire.transit-passenger-form');
    }
}
