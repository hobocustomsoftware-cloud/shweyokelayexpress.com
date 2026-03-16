<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargoResource;
use App\Repositories\MediaRepository;
use App\Http\Resources\CargoCollection;
use App\Http\Requests\StoreCargoRequest;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\MerchantRepositoryInterface;
use App\Services\ApiResponseService;
use App\Repositories\Interfaces\CarCargoRepositoryInterface;
use App\Services\QrCodeService;
use App\Models\Cargo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class CargoApiController extends Controller
{
    protected $cargoRepository;
    protected $mediaRepository;
    protected $merchantRepository;
    protected $carCargoRepository;
    public function __construct(CargoRepositoryInterface $cargoRepository, MediaRepositoryInterface $mediaRepository, MerchantRepositoryInterface $merchantRepository, CarCargoRepositoryInterface $carCargoRepository)
    {
        $this->cargoRepository = $cargoRepository;
        $this->mediaRepository = $mediaRepository;
        $this->merchantRepository = $merchantRepository;
        $this->carCargoRepository = $carCargoRepository;
    }

    /**
     * Get all cargos
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-07-21
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $cargos = $this->cargoRepository->getList($user);
        $cargoCollection = new CargoCollection($cargos);
        if ($cargoCollection->isEmpty()) {
            return ApiResponseService::sendResponse(null, 'Cargo list is empty', 200);
        }
        return ApiResponseService::sendResponse($cargoCollection, 'Successfully get cargo list', 200);
    }

    /**
     * Create a new cargo
     * @param StoreCargoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCargoRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $media_id = $this->mediaRepository->create($request->file('image'), 'cargos');
            $validated['media_id'] = $media_id;
        }

        if (is_numeric($request->s_name)) {
            $validated['s_merchant_id'] = (int) $request->s_name;
            unset($validated['s_name']);
        } else {
            $validated['s_name_string'] = $request->s_name;
            unset($validated['s_name']);
        }

        if (is_numeric($request->r_name)) {
            $validated['r_merchant_id'] = (int) $request->r_name;
            unset($validated['r_name']);
        } else {
            $validated['r_name_string'] = $request->r_name;
            unset($validated['r_name']);
        }

        $validated['s_nrc'] = $request->s_nrc ?? 'N/A';
        $validated['r_nrc'] = $request->r_nrc ?? 'N/A';
        $validated['to_pick_date'] = Carbon::parse($validated['to_pick_date'])->format('Y-m-d');
        $validated['status'] = $validated['status'] ?? 'registered';
        $validated['cargo_no'] = generateCargoNumber();
        $validated['voucher_number'] = generateVoucherNumber();
        if (Schema::hasColumn((new Cargo)->getTable(), 'created_by_user_id')) {
            $validated['created_by_user_id'] = $request->user()?->id;
        }

        $items = $validated['items'] ?? [];
        unset($validated['items'], $validated['image']);

        $cargo = $this->cargoRepository->createCargo($validated);

        if (!$cargo) {
            return ApiResponseService::sendError('Failed to create cargo', 500);
        }

        foreach ($items as $item) {
            $cargo->items()->create([
                'cargo_type_id' => $item['cargo_type_id'],
                'quantity'      => $item['quantity'],
                'detail'        => $item['detail'] ?? null,
                'notice'        => $item['notice'] ?? null,
            ]);
        }

        $this->carCargoRepository->create([
            'car_id'      => $request->car_id ?? null,
            'cargo_id'    => $cargo->id,
            'status'      => 'pending',
            'assigned_at' => now(),
        ]);

        return ApiResponseService::sendResponse(new CargoResource($cargo->load('items')), 'Cargo created successfully', 201);
    }

    /**
     * Get a cargo by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-07-21
     */
    public function show(Request $request, $id)
    {
        $cargo = $this->cargoRepository->getCargoById($id);
        if (!$cargo) {
            return ApiResponseService::sendError('Cargo not found', 404);
        }
        $user = $request->user();
        if ($user && !$this->userCanAccessCargo($user, $cargo)) {
            return ApiResponseService::sendError('Forbidden', 403);
        }
        return ApiResponseService::sendResponse(new CargoResource($cargo), 'Cargo found successfully', 200);
    }

    /**
     * Update a cargo
     * @param StoreCargoRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-07-21
     */
    public function update(StoreCargoRequest $request, $id)
    {
        $cargo = $this->cargoRepository->getCargoById($id);
        if (!$cargo) {
            return ApiResponseService::sendError('Cargo not found', 404);
        }
        $user = $request->user();
        if ($user && !$this->userCanAccessCargo($user, $cargo)) {
            return ApiResponseService::sendError('Forbidden', 403);
        }
        $cargoData = $request->validated();
        if ($request->has('s_name')) {
            if (is_numeric($request->s_name)) {
                $merchant = $this->merchantRepository->findById($request->s_name);
                if ($merchant) {
                    $cargoData['s_merchant_id'] = $merchant->id;
                }
            } else {
                $cargoData['s_name_string'] = $request->s_name;
            }
        }
        if ($request->has('r_name')) {
            if (is_numeric($request->r_name)) {
                $merchant = $this->merchantRepository->findById($request->r_name);
                if ($merchant) {
                    $cargoData['r_merchant_id'] = $merchant->id;
                }
            } else {
                $cargoData['r_name_string'] = $request->r_name;
            }
        }
        unset($cargoData['s_name']);
        unset($cargoData['r_name']);
        if ($request->hasFile('image')) {   
            $media = $this->mediaRepository->update($request->file('image'), 'cargos', $cargo->media_id);
            if (!$media) {
            return ApiResponseService::sendError('Failed to upload image', 500);
        }
        $cargoData['media_id'] = $media->id;
        }
        $cargoData['to_pick_date'] = Carbon::parse($cargoData['to_pick_date'])->format('Y-m-d');
        $updatedCargo = $this->cargoRepository->updateCargo($cargo, $cargoData);
        return ApiResponseService::sendResponse(new CargoResource($updatedCargo), 'Cargo updated successfully', 200);
    }

    /**
     * Delete a cargo
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @Author: Hein Htet Aung
     * @Date: 2025-07-21
     */
    public function destroy(Request $request, $id)
    {
        $cargo = $this->cargoRepository->getCargoById($id);
        if (!$cargo) {
            return ApiResponseService::sendError('Cargo not found', 404);
        }
        $user = $request->user();
        if ($user && !$this->userCanAccessCargo($user, $cargo)) {
            return ApiResponseService::sendError('Forbidden', 403);
        }
        $this->cargoRepository->deleteCargo($cargo);
        return ApiResponseService::sendResponse(null, 'Cargo deleted successfully', 204);
    }

    /**
     * Safe check: user is Admin/Accountant or owner of the cargo. Avoids 500 when role/column missing.
     */
    private function userCanAccessCargo($user, $cargo): bool
    {
        $ownerId = $cargo->created_by_user_id ?? null;
        if ($ownerId === null) {
            return true; // No owner set or column doesn't exist yet
        }
        try {
            if ($user->hasRole(['Admin', 'Accountant'])) {
                return true;
            }
        } catch (\Throwable $e) {
            // If role check fails (e.g. permission tables missing), fall back to owner check
        }
        return (int) $ownerId === (int) $user->id;
    }

}
