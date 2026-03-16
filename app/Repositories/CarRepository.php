<?php
namespace App\Repositories;

use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;

class CarRepository extends BaseRepository implements CarRepositoryInterface
{
    public function __construct(Car $model)
    {
        parent::__construct($model);
    }

    public function getList(array $relations = ['dayOff'])
    {
        return parent::getList($relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }
}