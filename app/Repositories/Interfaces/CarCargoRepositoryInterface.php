<?php

namespace App\Repositories\Interfaces;

interface CarCargoRepositoryInterface
{
    public function getList(array $relations = []);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getById(int $id);
    public function getByVoucherNo($voucher_no);
    public function getByCargoNo($cargo_no);
    

}