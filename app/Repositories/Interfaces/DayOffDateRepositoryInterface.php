<?php
namespace App\Repositories\Interfaces;

interface DayOffDateRepositoryInterface
{
    public function getList();
    public function create(array $data);
    public function update(string $id, array $data);
    public function find(string $id);
    public function getByCarId(int $carId);
    public function deleteByCarId(int $carId);
}