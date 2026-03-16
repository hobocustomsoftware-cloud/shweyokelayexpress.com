<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTableAbstract;
use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Carbon\Carbon;
use App\Enums\PermissionStatus;

class PermissionController extends BaseController
{

    public $repository;
    public $viewPath = 'admin.permissions';
    public $module = 'permissions';

    public function __construct(PermissionRepositoryInterface $repository)
    {
        parent::__construct($repository, $this->viewPath, $this->module);
    }

    /**
     * Show permission list
     * @return view
     */
    public function index($params = [])
    {
        return parent::index($params);
    }

    /**
     * Get permission list
     * @return json
     */
    public function getList(Request $request)
    {
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
        return $query;
    }

    /**
     * Prepare permission data table
     * @return DataTableAbstract
     */
    protected function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable
            ->addColumn('name', function ($permission) {
                return $permission->name;
            })
            ->addColumn('description', function ($permission) {
                return $permission->description;
            })
            ->addColumn('status', function ($permission) {
                return PermissionStatus::from($permission->status)->labelMM();
            })
            ->addColumn('date', function ($permission) {
                return Carbon::parse($permission->created_at)->format('d-m-Y');
            });
    }

    /**
     * Create permission
     * @return view
     */
    public function create()
    {
        return parent::create();
    }


    /**
     * Store permission
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        $permission = $this->repository->create($validated);
        if ($permission) {
            return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
        }
        return redirect()->route('admin.permissions.index')->with('error', 'Permission created failed.');
    }

    /**
     * Edit permission
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        $permission = $this->repository->getById($id);
        return view($this->viewPath . '.edit', compact('permission'));
    }

    /**
     * Update permission
     * @param Request $request
     * @param int $id
     * @return redirect
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        $permission = $this->repository->update($id, $validated);
        if ($permission) {
            return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
        }
        return redirect()->route('admin.permissions.index')->with('error', 'Permission updated failed.');
    }

    /**
     * Destroy permission
     * @param int $id
     * @return redirect
     */
    public function destroy($id)
    {
        $permission = $this->repository->delete($id);
        if ($permission) {
            return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
        }
        return redirect()->route('admin.permissions.index')->with('error', 'Permission deleted failed.');
    }
}
