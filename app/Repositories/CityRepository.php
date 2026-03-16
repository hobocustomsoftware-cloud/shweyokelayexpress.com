<?php
namespace App\Repositories;
use App\Models\City;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
    protected $model;

    public function __construct(City $city)
    {
        $this->model = $city;
    }

    public function getList(){
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function getAllCities()
    {
        return $this->model->orderBy('name_my', 'asc')->get();
    }

    public function createCity(array $data)
    {
        return $this->model->create($data);
    }

    public function getCityById($id)
    {
        return $this->model->find($id);
    }

    public function updateCity($id, array $data)
    {
        $city = $this->getCityById($id);
        if (!$city) {
            throw new ValidationException('City not found');
        }
        $city->update($data);
        return $city;
    }

    public function deleteCity($id)
    {
        $city = $this->getCityById($id);
        if (!$city) {
            throw new ValidationException('City not found');
        }
        $city->delete();
        return $city;
    }

    // public function getCityNameById($id)
    // {
    //     return $this->model->find($id)->name;
    // }
    public function getCityNameById($id)
    {
        $city = City::find($id);
    
        if ($city) {
            return $city->name; // သို့မဟုတ် name_my (သင့် database column အတိုင်း)
        }
    
        return '-'; // ရှာမတွေ့ရင် default အနေနဲ့ မျဉ်းတိုလေး ပြန်ပေးမယ်
    }
}