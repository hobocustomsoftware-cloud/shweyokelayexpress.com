<?php
namespace App\Repositories;

use App\Models\CargoType;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\CargoTypeRepositoryInterface;

class CargoTypeRepository implements CargoTypeRepositoryInterface
{
    public function getList()
    {
        return CargoType::orderBy('created_at', 'desc')->get();
    }

    public function getAllCargoTypes()
    {
        return CargoType::orderBy('name', 'asc')->get();
    }

    public function createCargoType($data)
    {
        return CargoType::create($data);
    }

    public function updateCargoType($id, $data)
    {
        return CargoType::find($id)->update($data);
    }

    public function deleteCargoType($id)
    {
        return CargoType::find($id)->delete();
    }

    public function getCargoTypeById($id)
    {
        return CargoType::find($id);
    }
    

}
