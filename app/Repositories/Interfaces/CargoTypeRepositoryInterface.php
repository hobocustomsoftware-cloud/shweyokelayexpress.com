<?php
namespace App\Repositories\Interfaces;

interface CargoTypeRepositoryInterface
{
    public function getList();
    public function getAllCargoTypes();
    public function createCargoType($data);
    public function updateCargoType($id, $data);
    public function deleteCargoType($id);
    public function getCargoTypeById($id);
}
