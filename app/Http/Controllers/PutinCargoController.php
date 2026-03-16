<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use Livewire\Livewire;
use App\Enums\CargoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTableAbstract;
use App\Http\Controllers\BaseController;
use App\Repositories\MerchantRepository;
use App\Repositories\Interfaces\CarCargoRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class PutinCargoController extends BaseController
{
    protected $carCargoRepository;
    protected $merchantRepository;
    protected $module = 'putin_cargos';
    protected $viewPath = 'admin.putin_cargos';
    protected $edit_btn = false;
    protected $delete_btn = false;
    protected $view_btn = true;
    public function __construct(CarCargoRepositoryInterface $carCargoRepository, MerchantRepository $merchantRepository)
    {
        $this->carCargoRepository = $carCargoRepository;
        $this->repository = $carCargoRepository;
        $this->merchantRepository = $merchantRepository;
        $this->viewPath = $this->viewPath;
        $this->module = $this->module;
        $this->edit_btn = $this->edit_btn;
        $this->delete_btn = $this->delete_btn;
    }

    /**
     * Listing
     * @Author HeinHtetAung
     * @Date 2025-07-07
     */
    public function index($params = [])
    {
        $merchants = $this->merchantRepository->getAll();
        $putin_cargos = $this->carCargoRepository->getList();
        if ($merchants) {
            $params['merchants'] = ($params && $params !== '') ? $params : $merchants;
            $params['putin_cargos'] = $putin_cargos;
            return parent::index($params);
        }
        return parent::index();
    }

    /**
     * Display a listing of the resource.
     * @Author HeinHtetAung
     * @Date 2025-07-07
     */
    public function getList(Request $request)
    {
        return parent::getList($request, $this->repository, $this->viewPath, $this->module);
    }

    /**
     * Prepare datatable
     * @Author HeinHtetAung
     * @Date 2025-07-08
     */
    protected function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable
            ->addColumn('cargo_no', fn($car_cargo) => $car_cargo->cargo->cargo_no ? $car_cargo->cargo->cargo_no : '')
            ->addColumn('cargo_type', fn($car_cargo) => $car_cargo->cargo->cargoType ? $car_cargo->cargo->cargoType->name : '')
            ->addColumn('from', fn($car_cargo) => $car_cargo->cargo->fromCity ? $car_cargo->cargo->fromCity->name_my . ',' . $car_cargo->cargo->fromGate->name_my : '')
            ->addColumn('to', fn($car_cargo) => $car_cargo->cargo->toCity ?$car_cargo->cargo->toCity->name_my . ',' . $car_cargo->cargo->toGate->name_my : '')
            ->addColumn('s_name', fn($car_cargo) => $car_cargo->cargo->sender_merchant ? $car_cargo->cargo->sender_merchant->name : $car_cargo->cargo->s_name_string)
            ->addColumn('r_name', fn($car_cargo) => $car_cargo->cargo->receiver_merchant ? $car_cargo->cargo->receiver_merchant->name : $car_cargo->cargo->r_name_string)
            ->addColumn('created_at', fn($car_cargo) => $car_cargo->cargo->created_at ? Carbon::parse($car_cargo->cargo->created_at)->format('d/m/Y') : '')
            ->addColumn('cargo_status', fn($car_cargo) => CargoStatus::from($car_cargo->cargo->status)->labelMM())
            ->addColumn('status', fn($car_cargo) => $car_cargo->status == 'assigned' ? 'ပြီး' : 'မပြီး')
            ->addColumn('car_number', fn($car_cargo) => $car_cargo->car ? $car_cargo->car->number : '')
            ->addColumn('arrived_at', fn($car_cargo) => $car_cargo->arrived_at ? Carbon::parse($car_cargo->arrived_at)->format('d/m/Y H:i') : '');
    }

    /**
     * Show PutinCargo
     * @param int $id
     * @return view
     * @Author: HeinHtetAung
     * @Date: 2025-07-14
     */
    public function show($id)
    {
        $user = Auth::user();
        $car_cargo = $this->carCargoRepository->getById($id);
        if (!$car_cargo) {
            return redirect()->route('admin.cargos.index');
        }
        $cargo_image = null;
        if ($car_cargo->cargo->media) {
            $cargo_image = $car_cargo->cargo->media->path;
            $cargo_image = str_replace('\\', '/', $cargo_image);
            $cargo_image = 'uploads/' . $cargo_image;
        }
        $entry_date = Carbon::parse($car_cargo->cargo->created_at)->format('d/m/Y');
        $to_take_date = Carbon::parse($car_cargo->cargo->to_pick_date)->format('d/m/Y');
        $delivery_type = $car_cargo->cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
        $service_charge = number_format($car_cargo->cargo->service_charge, 2);
        $transit_fee = number_format($car_cargo->cargo->transit_fee, 2);
        $short_deli_fee = number_format($car_cargo->cargo->short_deli_fee, 2);
        $final_deli_fee = number_format($car_cargo->cargo->final_deli_fee, 2);
        $total_fee = number_format($car_cargo->cargo->total_fee, 2);
        $border_fee = number_format($car_cargo->cargo->border_fee, 2);
        $cargo_status = CargoStatus::from($car_cargo->cargo->status)->labelMM();
        if($car_cargo->cargo->qrcode_image){
            $qrcode_image = $car_cargo->cargo->qrcode_image;
        }else{
            $qrcode_image = null;
        }
        return view('admin.putin_cargos.show', compact('car_cargo', 'user', 'entry_date', 'to_take_date', 'delivery_type', 'service_charge', 'transit_fee', 'short_deli_fee', 'final_deli_fee', 'border_fee', 'total_fee', 'cargo_status', 'qrcode_image', 'cargo_image'));
    }

    /**
     * Apply filter
     * @param Request $request
     * @param $query
     * @return mixed
     */
    protected function applyFilter(Request $request, $query)
    {
        if ($request->status) {
            $query = $query->whereHas('cargo', function ($query) use ($request) {
                $query->where('status', $request->status);
            });
        }
        
        if ($request->has('daterange') && $request->get('daterange') != '') {
            $daterange = explode(' - ', $request->get('daterange'));
            $start = Carbon::parse($daterange[0])->startOfDay();
            $end = Carbon::parse($daterange[1])->endOfDay();
        
            $query = $query->whereHas('cargo', function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            });
        }
        if ($request->s_name && $request->s_name !== '') {
            $query = $query->whereHas('cargo', function ($query) use ($request) {
                $query->where('s_name', $request->s_name);
            });
        }

        if ($request->assignStatus) {
            $query = $query->where('status', $request->assignStatus);
        }

        return $query;
    }
}
