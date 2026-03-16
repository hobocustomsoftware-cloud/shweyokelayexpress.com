<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Models\Media;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\CargoRepositoryInterface;

class CargoRepository implements CargoRepositoryInterface
{
    public function getList(?\App\Models\User $user = null)
    {
        $query = Cargo::with(['fromCity', 'toCity', 'fromGate', 'toGate', 'sender_merchant', 'receiver_merchant', 'items'])
            ->orderBy('id', 'desc');

        $hasCreatedByColumn = Schema::hasColumn((new Cargo)->getTable(), 'created_by_user_id');
        if ($user && $hasCreatedByColumn) {
            try {
                if (!$user->hasRole(['Admin', 'Accountant'])) {
                    $query->where('created_by_user_id', $user->id);
                }
            } catch (\Throwable $e) {
                $query->where('created_by_user_id', $user->id);
            }
        }

        return $query->paginate(10);
    }

    /**
     * Retrieve all cargo records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Cargo[]
     */
    public function getQuery()
    {
        return Cargo::with(['fromCity', 'toCity', 'fromGate', 'toGate', 'cargoType', 'sender_merchant', 'receiver_merchant'])->orderBy('id', 'desc');
    }

    /**
     * Create a new cargo record.
     *
     * @param array $data
     * @return Cargo
     */
    public function createCargo(array $data): Cargo
    {
        if (!isset($data)) {
            throw new \InvalidArgumentException('Data is required to create a cargo record.');
        }
        return Cargo::create($data);
    }

    /**
     * Update an existing cargo record.
     *
     * @param Cargo $cargo
     * @param array $data
     * @return Cargo
     */
    public function updateCargo(Cargo $cargo, array $data): Cargo
    {
        $cargo->update($data);
        return $cargo;
    }

    /**
     * Delete a cargo record.
     *
     * @param Cargo $cargo
     * @return void
     */
    public function deleteCargo(Cargo $cargo): void
    {
        $cargo->delete();
    }

    /**
     * Retrieve a cargo record by its ID.
     *
     * @param int $id
     * @return Cargo|null
     */
    public function getCargoById($id): ?Cargo
    {
        return Cargo::with([
            'fromCity',
            'toCity',
            'fromGate',
            'toGate',
            'cargoType',
            'sender_merchant',
            'receiver_merchant',
            'media'
        ])->find($id);
    }
}
