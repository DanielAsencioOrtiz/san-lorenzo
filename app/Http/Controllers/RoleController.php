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
        return view('roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Rol creado');
    }

    public function assignPermissions(Request $request, $roleId)
    {
        $role = Role::findById($roleId);
        $role->syncPermissions($request->permissions); // array de nombres de permisos
        return redirect()->back()->with('success', 'Permisos actualizados');
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
