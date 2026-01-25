<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('backend.setting_management.roles_and_permission.roles.index', compact('roles'));
    }

    public function create()
    {
        $routes = collect(Route::getRoutes())
            ->filter(function ($route) {
                $middlewares = $route->gatherMiddleware();
                return $route->getName() &&
                    $route->getAction('controller') &&
                    collect($middlewares)->contains('auth');
            })
            ->groupBy(function ($route) {
                return class_basename(explode('@', $route->getActionName())[0]);
            });

        return view('backend.setting_management.roles_and_permission.roles.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            // No need to validate permissions.* here
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->filled('permissions')) {
            foreach ($request->permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        // Group permissions by prefix (before first dot)
        $groupedPermissions = $role->permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view(
            'backend.setting_management.roles_and_permission.roles.show',
            compact('role', 'groupedPermissions')
        );
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $rolePermissions = $role->permissions()->pluck('name')->toArray();

        // Paginate permissions
        $permissions = Permission::orderBy('name')->paginate(500);

        // Group paginated items only
        $groupedPermissions = $permissions->getCollection()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });
        return view('backend.setting_management.roles_and_permission.roles.edit', compact(
            'role',
            'rolePermissions',
            'permissions',
            'groupedPermissions',
        ));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        // Update role name
        $role->name = $request->name;
        $role->save();

        // Handle permissions
        if ($request->filled('permissions')) {
            foreach ($request->permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $role->syncPermissions($request->permissions);
        } else {
            // If no permissions sent, remove all
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return back()->with('error', 'Role not found.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }
}
