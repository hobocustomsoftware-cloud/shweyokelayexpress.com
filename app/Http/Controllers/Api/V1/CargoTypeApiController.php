<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Repositories\Interfaces\CargoTypeRepositoryInterface;
use App\Http\Resources\CargoTypeCollection;
use App\Services\ApiResponseService;

class CargoTypeApiController extends BaseApiController
{
    public function __construct(CargoTypeRepositoryInterface $cargoTypeRepository)
    {
        $this->repository = $cargoTypeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargo_types = $this->repository->getAllCargoTypes();
        return ApiResponseService::sendResponse(new CargoTypeCollection($cargo_types), 'Cargo types retrieved successfully', 200);
    }
    
    
}

