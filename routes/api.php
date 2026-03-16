<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\CargoApiController;
use App\Http\Controllers\Api\V1\CityApiController;
use App\Http\Controllers\Api\V1\GateApiController;
use App\Http\Controllers\Api\V1\LoadCargoApiController;
use App\Http\Controllers\Api\V1\MerchantApiController;
use App\Http\Controllers\Api\V1\CarApiController;
use App\Http\Controllers\Api\V1\CargoTypeApiController;
use App\Http\Controllers\Api\V1\TransitCargoApiController;
use App\Http\Controllers\Api\V1\TransitPassengerApiController;

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'name'    => 'Cargo Shwe Yoke Lay Express API',
            'version' => 'v1',
            'base_url'=> url('/api/v1'),
            'endpoints' => [
                'auth' => [
                    'POST /api/v1/login'    => 'Login (name, password)',
                    'POST /api/v1/register' => 'Register (name, email, password)',
                    'POST /api/v1/logout'   => 'Logout (Bearer token required)',
                ],
                'cargos'    => 'GET/POST /api/v1/cargos, GET/PUT/DELETE /api/v1/cargos/{id}',
                'cities'    => 'GET /api/v1/cities',
                'gates'     => 'GET /api/v1/gates/{city_id}',
                'cargo_types'=> 'GET /api/v1/cargo_types',
                'merchants' => 'GET /api/v1/merchants',
                'cars'      => 'GET /api/v1/cars',
                'transit_cargos' => 'GET/POST /api/v1/transit_cargos, GET /api/v1/transit_cargos/{id}',
                'transit_passengers' => 'apiResource /api/v1/transit_passengers',
                'load_cargos' => 'GET /api/v1/load_cargos, GET /api/v1/load_cargos/{id}, POST assign, POST search',
            ],
        ], 200);
    });
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('register', [AuthApiController::class, 'register']);

    // GET /login and /register: return helpful message (browser often sends GET)
    Route::get('login', function () {
        return response()->json([
            'message' => 'Use POST to login.',
            'method'  => 'POST',
            'body'    => ['name' => 'string', 'password' => 'string'],
        ], 405);
    });
    Route::get('register', function () {
        return response()->json([
            'message' => 'Use POST to register.',
            'method'  => 'POST',
            'body'    => ['name' => 'string', 'email' => 'string', 'password' => 'string (min 8)'],
        ], 405);
    });
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::apiResource('cargos', CargoApiController::class);
    Route::apiResource('cities', CityApiController::class);
    Route::get('gates/{city_id}', [GateApiController::class, 'getGateByCity']);
    Route::get('load_cargos', [LoadCargoApiController::class, 'index']);
    Route::post('load_cargos/assign', [LoadCargoApiController::class, 'assignCar']);
    Route::post('load_cargos/search', [LoadCargoApiController::class, 'search']);
    Route::get('load_cargos/{id}', [LoadCargoApiController::class, 'show'])
        ->where('id', '[0-9]+');
    Route::get('merchants', [MerchantApiController::class, 'index']);
    Route::get('cars', [CarApiController::class, 'index']);
    Route::get('cargo_types', [CargoTypeApiController::class, 'index']);

    Route::get('transit_cargos', [TransitCargoApiController::class, 'index']);
    Route::post('transit_cargos', [TransitCargoApiController::class, 'store']);
    Route::get('transit_cargos/{id}', [TransitCargoApiController::class, 'show']);

    Route::apiResource('transit_passengers', TransitPassengerApiController::class);
});
