<?php

namespace App\Http\Controllers;

use App\Models\TipoConcreto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoConcretoController extends Controller
{
    public function index()
    {
        $tipo_concretos = TipoConcreto::where('estado', 1)->get();
        $tipo_concretosEliminados = TipoConcreto::where('estado', 0)->get();
        return view('tipo_concretos.index', compact('tipo_concretos','tipo_concretosEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => [
                'required',
                'string',
                Rule::unique('tipo_concretos', 'nombre_tipo')->where('estado', 1)
            ],
        ], [
            'nombre_tipo.required' => 'El nombre del tipo es obligatorio.',
            'nombre_tipo.unique' => 'Ya existe un tipo de concreto activo con ese nombre.',
        ]);

        TipoConcreto::create([
            'nombre_tipo' => $request->nombre_tipo,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Tipo de concreto registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoConcreto::findOrFail($id);

        $request->validate([
            'nombre_tipo' => [
                'required',
                'string',
                Rule::unique('tipo_concretos', 'nombre_tipo')
                    ->where('estado', 1)
                    ->ignore($tipo->id)
            ],
        ], [
            'nombre_tipo.unique' => 'Ya existe otro tipo de concreto activo con ese nombre.',
        ]);

        $tipo->update([
            'nombre_tipo' => $request->nombre_tipo,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Tipo de concreto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $tipo = TipoConcreto::findOrFail($id);
        $tipo->estado = 0;
        $tipo->save();

        return response()->json(['success' => true, 'message' => 'Tipo de concreto eliminado correctamente.']);
    }

    public function restore($id)
    {
        $tipo = TipoConcreto::findOrFail($id);
        $existeActiva = TipoConcreto::where('nombre_tipo', $tipo->nombre_tipo)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un tipo de concreto activo con el mismo nombre.'
            ]);
        }

        $tipo->estado = 1;
        $tipo->save();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de concreto activado correctamente.'
        ]);
    }
}
