<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CargoTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminCargoController;
use App\Http\Controllers\PutinCargoController;
use App\Http\Controllers\TransitCargoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransitPassengerController;
use App\Http\Controllers\PassengerReportController;
use App\Http\Controllers\RolePermissionController;

use Illuminate\Support\Facades\Artisan;

Route::get('/clear-all-cache', function() {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');

    return "Cache အားလုံးကို ရှင်းလင်းပြီးပါပြီ။";
})->middleware('auth');

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('send-reset-link');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('show-reset-password');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('admin.dashboard');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('admin.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // City
    Route::resource('cities', CityController::class)->names('admin.cities');
    Route::get('/get-cities', [CityController::class, 'getCities'])->name('cities.getCities');

    // Gate
    Route::resource('gates', GateController::class)->names('admin.gates');
    Route::get('/get-gates', [GateController::class, 'getGates'])->name('gates.getGates');

    // User
    Route::resource('users', UserController::class)->names('admin.users');
    Route::get('/get-users', [UserController::class, 'getList'])->name('users.getList');

    // Cargo TYpes
    Route::resource('cargo_types', CargoTypeController::class)->names('admin.cargo_types');
    Route::get('/get-cargo-types', [CargoTypeController::class, 'getCargoTypes'])->name('cargo_types.getCargoTypes');

    // Cargo
    Route::resource('cargos', AdminCargoController::class)->names('admin.cargos');
    Route::get('/getCargos', [AdminCargoController::class, 'getCargos'])->name('cargos.getCargos');

    // Merchant
    Route::resource('merchants', MerchantController::class)->names('admin.merchants');
    Route::get('/get-merchants', [MerchantController::class, 'getMerchants'])->name('admin.merchants.getMerchants');

    // Report
    Route::resource('reports', ReportController::class)->names('admin.reports');
    Route::get('/get-reports', [ReportController::class, 'getList'])->name('admin.reports.getList');
    Route::get('/exportPdf', [ReportController::class, 'exportPdf'])->name('admin.reports.exportPdf');
    Route::get('/passenger_reports', [PassengerReportController::class, 'index'])->name('admin.reports.passenger_reports');
    Route::get('/get-passengers', [PassengerReportController::class, 'getList'])->name('admin.reports.passengers.getList');

    // Transit Cargo
    Route::resource('transit_cargos', TransitCargoController::class)->names('admin.transit_cargos');
    Route::get('/get-transit-cargos', [TransitCargoController::class, 'getList'])->name('admin.transit_cargos.getList');

    // Transit passenger
    Route::resource('transit_passengers', TransitPassengerController::class)->names('admin.transit_passengers');
    Route::get('/get-transit-passengers', [TransitPassengerController::class, 'getList'])->name('admin.transit_passengers.getList');

    // PutinCargo
    Route::resource('putin_cargos', PutinCargoController::class)->names('admin.putin_cargos');
    Route::get('/get-putin-cargos', [PutinCargoController::class, 'getList'])->name('admin.putin_cargos.getList');

    // Cars
    Route::resource('cars', CarController::class)->names('admin.cars');
    Route::get('/get-cars', [CarController::class, 'getList'])->name('cars.getList');

    // Permission
    Route::resource('permissions', PermissionController::class)->names('admin.permissions');
    Route::get('/get-permissions', [PermissionController::class, 'getList'])->name('admin.permissions.getList');

    // Role Permission
    Route::resource('role_permissions', RolePermissionController::class)->names('admin.role_permissions');

    // Print voucher
    Route::get('/print-voucher/{id}', [AdminCargoController::class, 'printVoucher'])->name('admin.cargos.printVoucher');
});
Route::get('/clear', function() {
    \Artisan::call('view:clear');
    return "Cleared!";
})->middleware('auth');
