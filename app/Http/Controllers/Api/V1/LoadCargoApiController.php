<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Repositories\Interfaces\CarCargoRepositoryInterface;
use App\Http\Resources\LoadCargoCollection;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use App\Http\Resources\LoadCargoResource;
use Carbon\Carbon;

class LoadCargoApiController extends BaseApiController
{

    protected $carCargoRepository;
    public function __construct(CarCargoRepositoryInterface $carCargoRepository)
    {
        parent::__construct($carCargoRepository);
        $this->carCargoRepository = $carCargoRepository;
    }

    /**
     * Get all cargos
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-08-01
     */
    public function index()
    {
        $carCargoList = $this->carCargoRepository->getList()->paginate(10);
        $dataCollection = new LoadCargoCollection($carCargoList);
        return ApiResponseService::sendResponse($dataCollection, 'Successfully get load cargo list', 200);
    }

    /**
     * Assign car to cargo
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-08-04
     */
    public function assignCar(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'cargo_id' => 'required|integer|exists:cargos,id',
            'user_id' => 'required|integer|exists:users,id',
            'arrived_at' => 'required|date',
        ], [
            'car_id.required' => 'Car is required',
            'cargo_id.required' => 'Cargo is required',
            'user_id.required' => 'User is required',
            'arrived_at.required' => 'Arrived at is required',
        ]);
        $carCargo = $this->carCargoRepository->getById($validated['cargo_id']);
        if (!$carCargo) {
            return ApiResponseService::sendError('Car cargo not found', 404);
        }
        $validated['arrived_at'] = Carbon::parse($validated['arrived_at'])->format('Y-m-d');
        $validated['assigned_at'] = Carbon::now()->format('Y-m-d');
        $carCargo->update(['car_id' => $validated['car_id'], 'user_id' => $validated['user_id'], 'status' => 'assigned', 'assigned_at' => $validated['assigned_at'], 'arrived_at' => $validated['arrived_at']]);
        return ApiResponseService::sendResponse(new LoadCargoResource($carCargo), 'Successfully assign car', 200);
    }


    /**
     * Get car cargo by id
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-08-05
     */
    public function show($id)
    {
        $carCargo = $this->carCargoRepository->getById($id);
        if (!$carCargo) {
            return ApiResponseService::sendError('Cargo not found', 404);
        }
        return ApiResponseService::sendResponse(new LoadCargoResource($carCargo), 'Successfully get cargo', 200);
    }

    /**
     * Search car cargo by voucher no, cargo no
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-08-05
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'cargo_no' => 'required|string',
            'voucher_no' => 'nullable|string',
        ]);
        $carCargo = null;
        if ($validated['voucher_no']) {
            $carCargo = $this->carCargoRepository->getByVoucherNo($validated['voucher_no']);
        }
        if ($validated['cargo_no']) {
            $carCargo = $this->carCargoRepository->getByCargoNo($validated['cargo_no']);
        }
        if (!$carCargo) {
            return ApiResponseService::sendError('Cargo not found', 404);
        }
        return ApiResponseService::sendResponse(new LoadCargoResource($carCargo), 'Successfully get cargo', 200);
    }
}
