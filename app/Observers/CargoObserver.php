<?php

namespace App\Observers;

use App\Models\Cargo;
use Carbon\Carbon;

class CargoObserver
{
    /**
     * Handle the Cargo "created" event.
     */
    public function created(Cargo $cargo): void
    {
        //
    }

    /**
     * Handle the Cargo "updated" event.
     */
    public function updated(Cargo $cargo): void
    {
        // $cargo->items()->update(['updated_at' => Carbon::now()]);
    }

    /**
     * Handle the Cargo "deleted" event.
     */
    public function deleted(Cargo $cargo): void
    {
        $cargo->carCargo()->update(['deleted_at' => Carbon::now()]);
    }

    /**
     * Handle the Cargo "restored" event.
     */
    public function restored(Cargo $cargo): void
    {
        $cargo->carCargo()->withTrashed()->restore();
    }

    /**
     * Handle the Cargo "force deleted" event.
     */
    public function forceDeleted(Cargo $cargo): void
    {
        $cargo->carCargo()->forceDelete();
    }
}
