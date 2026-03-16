<?php
namespace App\Repositories;

use App\Models\TransitCargo;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\TransitCargoRepositoryInterface;

class TransitCargoRepository extends BaseRepository implements TransitCargoRepositoryInterface
{
    protected array $relations = ['cargoType', 'media', 'fromCity', 'toCity', 'fromGate', 'toGate', 'car'];
    public function __construct(TransitCargo $model)
    {
        parent::__construct($model);
    }

    public function getList(array $relations = [])
    {
        $relations = !empty($relations) ? $relations : $this->relations;
        return parent::getList($relations);
    }

    public function find($id)
    {
        return TransitCargo::with('cargoType', 'media', 'fromCity', 'toCity', 'fromGate', 'toGate', 'car')->find($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $cargo = TransitCargo::create($data);
            DB::commit();
            return $cargo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
