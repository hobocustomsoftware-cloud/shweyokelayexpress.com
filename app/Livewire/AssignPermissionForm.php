<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionForm extends Component
{

    public $roles = [];
    public $permissions = [];
    public $selected_role = '';
    public $selected_permissions = [];

    public function mount()
    {
        $this->permissions = Permission::all()->pluck('description', 'id');
        $this->roles = Role::all()->pluck('name', 'id');
        
        // Automatically select admin role if it exists
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $this->selected_role = $adminRole->id;
            $this->selected_permissions = $adminRole->permissions->pluck('id')->toArray();
        } else {
            $this->selected_permissions = [];
        }
    }

    public function updatedSelectedRole($value)
    {
        if ($value) {
            try {
                $role = Role::findById($value);
                $this->selected_permissions = $role->permissions->pluck('id')->toArray();
            } catch (\Exception $e) {
                $this->selected_permissions = [];
            }
        } else {
            $this->selected_permissions = [];
        }
    }

    public function save()
    {
        // Validate required fields
        $this->validate([
            'selected_role' => 'required|exists:roles,id',
            'selected_permissions' => 'array',
            'selected_permissions.*' => 'integer|exists:permissions,id'
        ], [
            'selected_role.required' => 'Please select a role',
            'selected_role.exists' => 'Selected role does not exist'
        ]);

        try {
            $role = Role::findById($this->selected_role);
            // Normalize to integers to avoid type issues (e.g., mixed strings/ints)
            $permissions = array_map('intval', $this->selected_permissions ?? []);
            $role->syncPermissions($permissions);
            $this->dispatch('PermissionAssigned', type: 'success', message: 'Permission assigned successfully');
        } catch (\Exception $e) {
            $this->dispatch('PermissionAssigned', type: 'error', message: 'Failed to assign permissions: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.assign-permission-form');
    }
}
