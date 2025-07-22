<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        // Agrupar por prefijo/categoría
        $groupedPermissions = $permissions->groupBy(function($perm) {
            return explode(' ', $perm->name)[1] ?? 'otros';
        });

        return view('roles.index', [
            'roles' => $roles,
            'permissions' => $groupedPermissions,
            'totalPermissions' => $permissions->count()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Permisos actualizados.');
    }


    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Protege ciertos roles si quieres (opcional)
        if (in_array($role->name, ['admin'])) {
            return back()->with('error', 'No puedes eliminar el rol administrador.');
        }

        // Verifica si algún usuario tiene el rol (opcional)
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Este rol está asignado a usuarios y no se puede eliminar.');
        }

        $role->delete();

        return back()->with('success', 'Rol eliminado correctamente.');
    }

}
