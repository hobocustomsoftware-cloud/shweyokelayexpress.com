<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Resources\TransitPassengerCollection;
use App\Http\Resources\TransitPassengerResource;
use App\Repositories\TransitPassengerRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransitPassengerRequest;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Services\ApiResponseService;


class TransitPassengerApiController extends BaseApiController
{
    public function __construct(TransitPassengerRepository $repository)
    {
        parent::__construct($repository);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TransitPassengerCollection($this->repository->getList()->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = (new StoreTransitPassengerRequest())->rules();
            $validated = $request->validate($rules);
            $validated['voucher_number'] = generateTransitPassengerVoucherNumber();
            $transitPassenger = $this->repository->create($validated);
            DB::commit();
            if ($transitPassenger) {
                return ApiResponseService::sendResponse(new TransitPassengerResource($transitPassenger), 'Transit Passenger created successfully', 201);
            }
            return ApiResponseService::sendError('Transit Passenger created failed', 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseService::sendError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $transitPassenger = $this->repository->getById($id);
            if ($transitPassenger) {
                return ApiResponseService::sendResponse(new TransitPassengerResource($transitPassenger), 'Transit Passenger retrieved successfully', 200);
            }
            return ApiResponseService::sendError('Transit Passenger not found', 404);
        } catch (\Exception $e) {
            return ApiResponseService::sendError($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
