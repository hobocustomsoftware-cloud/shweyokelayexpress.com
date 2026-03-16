<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enums\CargoStatus;
use App\Models\TransitCargo;
use Illuminate\Http\Request;
use App\Services\QrCodeService;
use App\Repositories\CityRepository;
use Yajra\DataTables\DataTableAbstract;
use App\Http\Controllers\BaseController;
use App\Repositories\CargoTypeRepository;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\CargoTypeRepositoryInterface;
use App\Repositories\Interfaces\TransitCargoRepositoryInterface;

class TransitCargoController extends BaseController
{
    protected $transitCargoRepository;
    protected $cityRepository;
    protected $cargoTypeRepository;
    protected $qrcodeService;
    protected $module = 'transit_cargos';
    protected $viewPath = 'admin.transit_cargos';
    protected $repository;
    protected $view_btn;
    public function __construct(TransitCargoRepositoryInterface $transitCargoRepository, QrcodeService $qrcodeService, CityRepositoryInterface $cityRepository, CargoTypeRepositoryInterface $cargoTypeRepository){
        parent::__construct($transitCargoRepository, $this->viewPath, $this->module);
        $this->transitCargoRepository = $transitCargoRepository;
        $this->cityRepository = $cityRepository;
        $this->cargoTypeRepository = $cargoTypeRepository;
        $this->qrcodeService = $qrcodeService;
        $this->repository = $transitCargoRepository;
        $this->view_btn = true;
    }

    /**
     * Listing
     * @Author HeinHtetAung
     * @Date 2025-07-07
     */
    public function index($params = ''){
        $cities = $this->cityRepository->getAllCities();
        $cargoTypes = $this->cargoTypeRepository->getAllCargoTypes();
        return view('admin.transit_cargos.index', compact('cargoTypes', 'cities'));
    }

    /**
     * Get list of cargo
     * @Author HeinHtetAung
     * @Date 2025-07-07
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request){
        return parent::getList($request);
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
            $query->where('status', $request->status);
        }
        
        if ($request->has('daterange') && $request->get('daterange') != '') {
            $daterange = explode(' - ', $request->get('daterange'));
            $start = Carbon::parse($daterange[0])->startOfDay();
            $end = Carbon::parse($daterange[1])->endOfDay();
        
            $query->whereBetween('created_at', [$start, $end]);
        }
        if ($request->s_name && $request->s_name !== '') {
            $query->where('s_name', $request->s_name);
        }

        return $query;
    }

    /**
     * Prepare data table
     * @Author HeinHtetAung
     * @Date 2025-07-07
     * @return \Illuminate\Http\Response
     */
    protected function prepareDataTable(DataTableAbstract $datatable){
        return $datatable
            ->addColumn('cargo_type', function($transitCargo){
                return $transitCargo->cargoType->name;
            })
            ->addColumn('from', function($transitCargo){
                return $transitCargo->fromCity->name_my . ' - ' . $transitCargo->fromGate->name_my;
            })
            ->addColumn('to', function($transitCargo){
                return $transitCargo->toCity->name_my . ' - ' . $transitCargo->toGate->name_my;
            })
            ->addColumn('s_name', function($transitCargo){
                return $transitCargo->sender_merchant->name ?? $transitCargo->s_name_string;
            })
            ->addColumn('r_name', function($transitCargo){
                return $transitCargo->receiver_merchant->name ?? $transitCargo->r_name_string;
            })
            ->addColumn('car', function($transitCargo){
                return $transitCargo->car->number;
            })
            ->addColumn('to_pick_date', function($transitCargo){
                return Carbon::parse($transitCargo->to_pick_date)->format('d/m/Y');
            })
            ->addColumn('date', function($transitCargo){
                return Carbon::parse($transitCargo->created_at)->format('d/m/Y');
            })
            ->addColumn('status', function($transitCargo){
                $status = CargoStatus::from($transitCargo->status);
                return $status->labelMM();
            });
    }

    /**
     * Show cargo detail
     * @Author HeinHtetAung
     * @Date 2025-07-07
     * @return View
     */
    public function show($id){
        $user = auth()->user();
        $transit_cargo = $this->transitCargoRepository->find($id);
        if (!$transit_cargo) {
            return redirect()->route('admin.transit_cargos.index');
        }
        if($transit_cargo->media){
            $transit_cargo_image = $transit_cargo->media->path; 
            $transit_cargo_image = str_replace('\\', '/', $transit_cargo_image);
            $transit_cargo_image = 'uploads/' . $transit_cargo_image;
        }
        $entry_date = Carbon::parse($transit_cargo->created_at)->format('d/m/Y');
        $to_take_date = Carbon::parse($transit_cargo->to_pick_date)->format('d/m/Y');
        $service_charge = number_format($transit_cargo->service_charge, 2);
        $transit_cargo_status = CargoStatus::from($transit_cargo->status)->labelMM();
        $qrcode_image = $transit_cargo->qrcode_image;
        return view('admin.transit_cargos.show', compact('transit_cargo', 'user', 'transit_cargo_image', 'entry_date', 'to_take_date', 'service_charge', 'transit_cargo_status', 'qrcode_image'));
    }

    public function create(){
        return view('admin.transit_cargos.create');
    }
}
