<?php

namespace App\Repositories;
use App\Models\Gate;
use App\Repositories\Interfaces\GateRepositoryInterface;

class GateRepository implements GateRepositoryInterface
{
    protected $model;

    public function __construct(Gate $gate)
    {
        $this->model = $gate;
    }

    public function getList(){
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function getAllGates()
    {
        return $this->model->orderBy('name_my', 'asc')->get();
    }

    public function getGatesWithCityId($city_id){
        return $this->model->where('city_id', $city_id)->get();
    }

    public function createGate(array $data)
    {
        return $this->model->create($data);
    }

    public function getGateById($id)
    {
        return $this->model->find($id);
    }

    public function updateGate($id, array $data)
    {
        $gate = $this->getGateById($id);
        if (!$gate) {
            return false;
        }
        $gate->update($data);
        return $gate;
    }

    public function deleteGate($id)
    {
        $gate = $this->getGateById($id);
        if (!$gate) {
            return false;
        }
        $gate->delete();
        return true;
    }
}