<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Services\ApiResponseService;

class CityApiController extends Controller
{
    protected $cityRepository;
    public function __construct(CityRepositoryInterface $cityRepository){
        $this->cityRepository = $cityRepository;
    }

    /**
     * Get all cities
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-07-21
     */
    public function index(){
        $cities = $this->cityRepository->getAllCities();
        return ApiResponseService::sendResponse(
            new CityCollection($cities),
            $cities->isEmpty() ? 'No cities found' : 'Cities found successfully',
            200
        );
    }
}
