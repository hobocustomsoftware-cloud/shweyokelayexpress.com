<?php
namespace App\Repositories\Interfaces;

interface CarRepositoryInterface
{
    public function getList();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}