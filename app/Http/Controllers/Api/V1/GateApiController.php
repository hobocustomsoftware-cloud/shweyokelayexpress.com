<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GateCollection;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Repositories\Interfaces\GateRepositoryInterface;
use App\Services\ApiResponseService;

class GateApiController extends BaseApiController
{
    protected $gateRepository;
    protected $apiResponseService;
    public function __construct(GateRepositoryInterface $gateRepository)
    {
        parent::__construct($gateRepository);
        $this->gateRepository = $gateRepository;
    }

    /**
     * Get gates by city id
     */
    public function getGateByCity($city_id){
        $gates = $this->gateRepository->getGatesWithCityId($city_id);
        $gateCollection = new GateCollection($gates);
        return ApiResponseService::sendResponse(
            $gateCollection,
            $gates->isEmpty() ? 'Gate list is empty' : 'Successfully get gate list',
            200
        );
    }
}
