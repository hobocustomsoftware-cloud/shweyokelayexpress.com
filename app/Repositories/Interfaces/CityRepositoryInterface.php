<?php
namespace App\Repositories\Interfaces;

interface CityRepositoryInterface
{
    public function getList();
    public function getAllCities();
    public function createCity(array $data);
    public function getCityById($id);
    public function updateCity($id, array $data);
    public function deleteCity($id);
}
