<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function getList(){
        return User::all();
    }

    public function getUserById($id){
        return User::find($id);
    }

    public function create(array $data){
        $user = User::create($data);
        return $user;
    }
}