<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Resources\CarCollection;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Services\ApiResponseService;

class CarApiController extends BaseApiController
{
    public function __construct(CarRepositoryInterface $carRepository)
    {
        parent::__construct($carRepository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $cars = $this->repository->getList()->get();
        $carCollection = new CarCollection($cars);
        return ApiResponseService::sendResponse($carCollection, 'Cars retrieved successfully', 200);
    }
}
