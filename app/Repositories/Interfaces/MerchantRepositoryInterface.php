<?php
namespace App\Repositories\Interfaces;

interface MerchantRepositoryInterface {
    public function getList();
    public function getAll();
    public function create(array $data);
    public function findById($id);
    public function update($id, array $data);
    public function delete($id);
    public function getPhoneByMerchantId($id);
    public function getNrcByMerchantId($id);
    public function getAddressByMerchantId($id);
}