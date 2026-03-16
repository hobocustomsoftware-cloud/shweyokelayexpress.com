<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Facades\DataTables;

abstract class BaseController extends Controller
{
    protected $repository;
    protected $viewPath;
    protected $module;

    /**
     * Constructor
     * @Date 2025-07-07
     * @param $repository
     * @param $viewPath
     * @param $module
     */
    public function __construct($repository, $viewPath, $module)
    {
        $this->repository = $repository;
        $this->viewPath = $viewPath;
        $this->module = $module;
    }

    /**
     * Display a listing of the resource.
     * @Author HeinHtetAung
     * @Date 2025-07-07
     */
    public function index($params = [])
    {
        if($params){
            return view($this->viewPath . '.index', ['params'=>$params]);
        }
        return view($this->viewPath . '.index');
    }

    /**
     * Get list of data using Yajra Datatables
     * @Author HeinHtetAung
     * @Date 2025-07-07
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data = $this->repository->getList();
        if (method_exists($this, 'applyFilter')) {
            $data = $this->applyFilter($request, $data);
        }
        if ($request->ajax()) {
            $datatable = DataTables::of($data)
                ->addIndexColumn();
            if (method_exists($this, 'prepareDataTable')) {
                $datatable = $this->prepareDataTable($datatable);
            }
            $datatable->addColumn('action', function ($data) {
                $module = $this->module;
                return view('admin.partials.action', compact('data', 'module'))->render();
            });
            $datatable->rawColumns(['action']);
            return $datatable->make(true);
        }
        return view($this->viewPath . '.index', compact('data'));
    }

    /**
     * Apply filter
     * @param Request $request
     * @param $query
     * @return mixed
     */
    protected function applyFilter(Request $request, $query)
    {
        return $query;
    }

    /**
     * Prepare datatable
     * @Author HeinHtetAung
     * @Date 2025-07-07
     * @return \Illuminate\Http\Response
     */
    protected function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->viewPath . '.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        return $this->repository->delete($id);
    }
}
