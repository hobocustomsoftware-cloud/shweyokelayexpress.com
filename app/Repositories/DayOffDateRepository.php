<?php
namespace App\Repositories;

use App\Models\DayOffDate;
use App\Repositories\Interfaces\DayOffDateRepositoryInterface;

class DayOffDateRepository implements DayOffDateRepositoryInterface
{
    public function getList()
    {
        return DayOffDate::all();
    }

    public function create(array $data)
    {
        return DayOffDate::create($data);
    }
    public function update(string $id, array $data)
    {
        return DayOffDate::find($id)->update($data);
    }

    public function find(string $id)
    {
        return DayOffDate::find($id);
    }

    public function getByCarId(int $carId)
    {
        return DayOffDate::where('car_id', $carId)->orderBy('day_off_date')->get();
    }

    public function deleteByCarId(int $carId)
    {
        return DayOffDate::where('car_id', $carId)->delete();
    }
}
