<?php
namespace App\Repositories;

use App\Models\TransitPassenger;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TransitPassengerRepositoryInterface;

class TransitPassengerRepository extends BaseRepository implements TransitPassengerRepositoryInterface
{
    protected $transitPassenger;
    protected array $relations = [
        'car',
    ];

    public function __construct(TransitPassenger $transitPassenger)
    {
        parent::__construct($transitPassenger);
        $this->transitPassenger = $transitPassenger;
    }

    public function getList(array $relations = [])
    {
        $relations = !empty($relations) ? $relations : $this->relations;
        return parent::getList($relations);
    }

    public function getById($id)
    {
        if (!empty($this->relations)) {
            return $this->transitPassenger->newQuery()->with($this->relations)->find($id);
        }
        return $this->transitPassenger->find($id);
    }

    public function create(array $data)
    {
        return parent::create($data);
    }

    public function update(int $id,array $data)
    {
        return parent::update($id, $data);
    }

    public function delete(int $id)
    {
        return parent::delete($id);
    }

    public function getBySeatNumber($seat_number, $car_id)
    {
        return $this->transitPassenger->where('seat_number', $seat_number)->where('car_id', $car_id)->first();
    }
}