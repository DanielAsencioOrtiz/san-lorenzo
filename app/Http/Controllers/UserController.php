<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use App\Models\Sede;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles', 'sede')->where('estado', 1)->get();
        $usuariosEliminados = User::with('roles', 'sede')->where('estado', 0)->get();
        $roles = Role::where('name', '!=', 'SUPERADMINISTRADOR')->get();
        $sedes = Sede::where('estado', 1)->get();

        return view('usuarios.index', compact('usuarios', 'usuariosEliminados', 'roles', 'sedes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'dni' => 'required|unique:users',
            'roles' => 'array'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 100 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'Este DNI ya está registrado.',

            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',

            'roles.array' => 'El formato de los roles no es válido.'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dni' => $request->dni,
            'password' => bcrypt($request->password),
            'id_sede' => $request->id_sede,
        ]);

        $user->syncRoles($request->roles);

        return back()->with('mensaje', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'dni' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:6',
            'roles' => 'array'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 100 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'Este DNI ya está registrado.',

            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',

            'roles.array' => 'El formato de los roles no es válido.'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->dni = $request->dni;
        $user->id_sede = $request->id_sede;
        $user->save();

        $user->syncRoles($request->roles);

        return back()->with('mensaje', 'Usuario actualizado correctamente.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('admin')) {
            return back()->with('error', 'No puedes eliminar un administrador.');
        }

        $user->estado = 0;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente.']);
    }

    public function restore($id)
    {
        $user = User::findOrFail($id);

        $existeActiva = User::where('dni', $user->dni)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un usuario activo con el mismo DNI.'
            ]);
        }

        $existeEmail = User::where('email', $user->email)
            ->where('estado', 1)
            ->exists();
            
        if ($existeEmail) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un usuario activo con el mismo correo electrónico.'
            ]);
        }

        if ($user->estado == 1) {
            return response()->json(['success' => false, 'message' => 'El usuario ya está activo.']);
        }

        $user->estado = 1;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Usuario restaurado correctamente.']);
    }


}
