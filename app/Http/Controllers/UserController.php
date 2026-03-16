<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTableAbstract;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends BaseController
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository, 'admin.users', 'users');
    }

    /**
     * Show user list
     * @return view
     */
    public function index($params = [])
    {
        return parent::index($params);
    }

    /**
     * Get users list data
     * @param Request $request
     * @return json
     */
    public function getList(Request $request)
    {
        return parent::getList($request, $this->repository, $this->viewPath, $this->module);
    }

    public function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable->addColumn('roles', function ($user) {
            $roles = $user->getRoleNames();
            foreach ($roles as $role) {
                return $role;
            }
        });
    }

    public function applyFilter(Request $request, $query)
    {
        return $query;
    }

    /**
     * Show user details
     * @param int $id
     * @return view
     */
    public function show($id)
    {
        $user = $this->repository->getUserById($id);
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * Show user create form
     * @return view
     */
    public function create()
    {
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store user
     * @param CreateUserRequest $request
     * @return redirect
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate((new CreateUserRequest())->rules());
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        }
        $user = $this->repository->create($validated);
        if ($user) {
            $user->assignRole($request->role);
            return redirect()->route('admin.users.index')->with('success', 'User created successfully');
        }
        return redirect()->route('admin.users.index')->with('error', 'User created failed');
    }

    public function edit($id)
    {
        $user = $this->repository->getUserById($id);
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'User not found');
        }
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate((new UpdateUserRequest())->rules());
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        }
        $user = $this->repository->getUserById($id);
        if ($user) {
            $user->update($validated);
            $user->syncRoles($request->role);
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        }
        return redirect()->route('admin.users.index')->with('error', 'User updated failed');
    }

    public function destroy($id)
    {
        $user = $this->repository->getUserById($id);
        if ($user) {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
        }
        return redirect()->route('admin.users.index')->with('error', 'User deleted failed');
    }
}
