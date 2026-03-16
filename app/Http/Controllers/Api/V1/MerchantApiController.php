<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseApiController;
use Illuminate\Http\Request;
use App\Http\Resources\MerchantCollection;
use App\Repositories\Interfaces\MerchantRepositoryInterface;
use App\Services\ApiResponseService;

class MerchantApiController extends BaseApiController
{
    public function __construct(MerchantRepositoryInterface $merchantRepository)
    {
        parent::__construct($merchantRepository);
    }

    public function index()
    {
        $merchants = $this->repository->getAll();
        $merchantCollection = new MerchantCollection($merchants);
        return ApiResponseService::sendResponse($merchantCollection, 'Merchants retrieved successfully', 200);
    }
}
