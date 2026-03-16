<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Repositories\CarRepository;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTableAbstract;
use App\Http\Controllers\BaseController;
use Illuminate\Validation\ValidationException;
use App\Models\City;

class CarController extends BaseController
{
    protected $repository;
    protected $viewPath;
    protected $module;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
        $this->viewPath = 'admin.cars';
        $this->module = 'cars';
    }
    /**
     * Display a listing of the resource.
     */
    public function index($params = [])
    {
        return parent::index($params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.cars.create', compact('cities'));
    }

    public function getList(Request $request)
    {
        return parent::getList($request);
    }

    protected function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable
            ->addColumn('departure_date', function ($car) {
                return Carbon::parse($car->departure_date)->format('d/m/Y');
            })
            ->addColumn('route', function ($car) {
                return $car->from . ' - ' . $car->to;
            });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.cars.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = $this->repository->getById($id);
        $cities = City::all();
        if (!$car) {
            return redirect()->back()->with('error', 'ကားအချက်အလက်များပြုမည့်အောင်မြင်မှုမရှိပါ');
        }
        return view($this->viewPath . '.edit', compact('car', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = $this->repository->getById($id);
        if (!$car) {
            return redirect()->back()->with('error', 'ကားအချက်အလက်များဖျက်မည့်အောင်မြင်မှုမရှိပါ');
        }
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'ကားအချက်အလက်များဖျက်မည့်အောင်မြင်ပါသည်');
    }
}
