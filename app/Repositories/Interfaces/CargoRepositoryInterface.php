<?php
namespace App\Repositories\Interfaces;

use App\Models\Cargo;

interface CargoRepositoryInterface
{
    /**
     * @param  \App\Models\User|null  $user  When provided and not admin, only cargos created by this user are returned.
     */
    public function getList(?\App\Models\User $user = null);

    /**
     * Retrieve all cargo records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Cargo[]
     */
    public function getQuery();

    public function getCargoById($id);

    /**
     * Create a new cargo record.
     *
     * @param array $data
     * @return Cargo
     */
    public function createCargo(array $data);

    /**
     * Update an existing cargo record.
     *
     * @param Cargo $cargo
     * @param array $data
     * @return Cargo
     */
    public function updateCargo(Cargo $cargo, array $data);

    /**
     * Delete a cargo record.
     *
     * @param Cargo $cargo
     * @return void
     */
    public function deleteCargo(Cargo $cargo);
}