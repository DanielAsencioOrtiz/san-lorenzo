<?php

namespace App\Http\Controllers;

use App\Models\TipoPersonal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoPersonalController extends Controller
{
    public function index()
    {
        $tipos = TipoPersonal::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $tiposEliminados = TipoPersonal::where('estado', 0)->orderBy('created_at', 'desc')->get();

        return view('tipo_personal.index', compact('tipos', 'tiposEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => [
                'required',
                'string',
                Rule::unique('tipo_personals', 'nombre_tipo')->where('estado', 1)
            ],
        ], [
            'nombre_tipo.required' => 'El nombre del tipo de personal es obligatorio.',
            'nombre_tipo.unique' => 'Ya existe un tipo de personal activo con ese nombre.',
        ]);

        TipoPersonal::create($request->only('nombre_tipo'));

        return redirect()->back()->with('mensaje', 'Tipo de personal registrado.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_tipo' => [
                'required',
                'string',
                Rule::unique('tipo_personals', 'nombre_tipo')->where('estado', 1)->ignore($id)
            ],
        ], [
            'nombre_tipo.required' => 'El nombre del tipo de personal es obligatorio.',
            'nombre_tipo.unique' => 'Ya existe un tipo de personal activo con ese nombre.',
        ]);

        $tipo = TipoPersonal::findOrFail($id);
        $tipo->update($request->only('nombre_tipo'));

        return redirect()->back()->with('mensaje', 'Tipo de personal actualizado.');
    }

    public function destroy($id)
    {
        $tipo = TipoPersonal::findOrFail($id);
        $tipo->update(['estado' => 0]);

        return redirect()->back()->with('mensaje', 'Tipo de personal desactivado.');
    }

    public function restore($id)
    {
        $tipo = TipoPersonal::findOrFail($id);
        $existeActivo = TipoPersonal::where('nombre_tipo', $tipo->nombre_tipo)->where('estado', 1)->exists();

        if ($existeActivo) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un tipo de personal activo con el mismo nombre.'
            ]);
        }

        $tipo->estado = 1;
        $tipo->save();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de personal activado correctamente.'
        ]);
    }
}
