<?php

namespace App\Repositories;

use App\Models\CarCargo;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\CarCargoRepositoryInterface;

class CarCargoRepository extends BaseRepository implements CarCargoRepositoryInterface
{
    protected $carCargo;
    protected $relations = [
        'car',
        'cargo', 
        'cargo.cargoType',
        'cargo.fromCity', 
        'cargo.fromGate',
        'cargo.toCity',
        'cargo.toGate',
        'cargo.sender_merchant',
        'cargo.receiver_merchant',
        'user'
    ];

    public function __construct(CarCargo $carCargo)
    {
        parent::__construct($carCargo);
        $this->carCargo = $carCargo;
    }

    public function getList(array $relations = [])
    {
        $relations = !empty($relations) ? $relations : $this->relations;
        $carCargoList = parent::getList($relations);
        return $carCargoList->where('cargo_id', '!=', null);
    }

    public function create(array $data)
    {
        return $this->carCargo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->carCargo->where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->carCargo->where('id', $id)->delete();
    }

    public function getById(int $id)
    {
        return $this->carCargo->with($this->relations)
        ->where('id', $id)
        ->where('deleted_at', null)
        ->first();
    }

    public function getByVoucherNo($voucher_no)
    {
        return $this->carCargo->with($this->relations)
        ->whereHas('cargo', function ($query) use ($voucher_no) {
            $query->where('voucher_number', $voucher_no);
        })
        ->where('deleted_at', null)
        ->first();
    }

    public function getByCargoNo($cargo_no)
    {
        return $this->carCargo->with($this->relations)
        ->whereHas('cargo', function ($query) use ($cargo_no) {
            $query->where('cargo_no', $cargo_no);
        })
        ->where('deleted_at', null)
        ->first();
    }
}