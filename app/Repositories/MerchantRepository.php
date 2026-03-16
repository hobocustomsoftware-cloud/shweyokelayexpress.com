<?php
namespace App\Repositories;

use App\Repositories\Interfaces\MerchantRepositoryInterface;
use App\Models\Merchant;

class MerchantRepository implements MerchantRepositoryInterface {
    protected $model;
    public function __construct(Merchant $merchant){
        $this->model = $merchant;
    }

    public function getList(){
        return $this->model->orderBy('created_at', 'desc')->get();
    }
    
    public function getAll(){
        return $this->model->orderBy('name', 'asc')->get();
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function findById($id){
        return $this->model->find($id);
    }

    public function update($id, array $data){
        return $this->model->find($id)->update($data);
    }

    public function delete($id){
        return $this->model->destroy($id);
    }

    public function getMerchantNameById($id){
        return $this->model->find($id)->name;
    }

    public function getPhoneByMerchantId($id){
        return $this->model->find($id)->phone;
    }

    public function getNrcByMerchantId($id){
        return $this->model->find($id)->nrc;
    }
    
    public function getAddressByMerchantId($id){
        return $this->model->find($id)->address;
    }
}