<?php
namespace App\Repositories\Interfaces;

interface GateRepositoryInterface
{
    public function getList();
    public function getAllGates();
    public function getGatesWithCityId($city_id);
    public function createGate(array $data);
    public function getGateById($id);
    public function updateGate($id, array $data);
    public function deleteGate($id);
}