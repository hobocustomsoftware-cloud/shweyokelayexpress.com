<?php
namespace App\Repositories\Interfaces;

interface TransitPassengerRepositoryInterface
{
    public function getList(array $relations = []);
    public function getById($id);
    public function create(array $data);
    public function update(int $id,array $data);
    public function delete(int $id);
}
