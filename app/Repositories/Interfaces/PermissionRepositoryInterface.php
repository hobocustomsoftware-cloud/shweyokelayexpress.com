<?php
namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function getList();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getById($id);
}
