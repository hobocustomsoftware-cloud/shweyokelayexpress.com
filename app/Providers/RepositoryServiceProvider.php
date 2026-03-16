<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Repositories\Interfaces\CityRepositoryInterface',
            'App\Repositories\CityRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\GateRepositoryInterface',
            'App\Repositories\GateRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CargoRepositoryInterface',
            'App\Repositories\CargoRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CargoTypeRepositoryInterface',
            'App\Repositories\CargoTypeRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CustomerRepositoryInterface',
            'App\Repositories\CustomerRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\MediaRepositoryInterface',
            'App\Repositories\MediaRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\MerchantRepositoryInterface',
            'App\Repositories\MerchantRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\ReportRepositoryInterface',
            'App\Repositories\ReportRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\TransitCargoRepositoryInterface',
            'App\Repositories\TransitCargoRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CarRepositoryInterface',
            'App\Repositories\CarRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CargoSummaryReportRepositoryInterface',
            'App\Repositories\CargoSummaryReportRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CarCargoRepositoryInterface',
            'App\Repositories\CarCargoRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\TransitPassengerRepositoryInterface',
            'App\Repositories\TransitPassengerRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\DayOffDateRepositoryInterface',
            'App\Repositories\DayOffDateRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\PassengerSummaryReportRepositoryInterface',
            'App\Repositories\PassengerSummaryReportRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\PermissionRepositoryInterface',
            'App\Repositories\PermissionRepository'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
