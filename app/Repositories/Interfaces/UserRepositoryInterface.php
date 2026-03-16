<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface {
    public function getList();
    public function getUserById($id);
    public function create(array $data);
}
