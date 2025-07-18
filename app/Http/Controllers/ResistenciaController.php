<?php

namespace App\Http\Controllers;

use App\Models\Resistencia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResistenciaController extends Controller
{
    public function index()
    {
        $resistencias = Resistencia::where('estado', 1)->get();
        $resistenciasEliminadas = Resistencia::where('estado', 0)->get();
        return view('resistencia.index', compact('resistencias','resistenciasEliminadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_resistencia' => [
                'required',
                'string',
                Rule::unique('resistencias', 'nombre_resistencia')->where('estado', 1)
            ],
        ], [
            'nombre_resistencia.required' => 'El nombre de la resistencia es obligatorio.',
            'nombre_resistencia.unique' => 'Ya existe una resistencia activa con ese nombre.',
        ]);

        Resistencia::create([
            'nombre_resistencia' => $request->nombre_resistencia,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Resistencia registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $resistencia = Resistencia::findOrFail($id);

        $request->validate([
            'nombre_resistencia' => [
                'required',
                'string',
                Rule::unique('resistencias', 'nombre_resistencia')
                    ->where('estado', 1)
                    ->ignore($resistencia->id)
            ],
        ], [
            'nombre_resistencia.unique' => 'Ya existe otra resistencia activa con ese nombre.',
        ]);

        $resistencia->update([
            'nombre_resistencia' => $request->nombre_resistencia,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Resistencia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $resistencia = Resistencia::findOrFail($id);
        $resistencia->estado = 0;
        $resistencia->save();

        return response()->json(['success' => true, 'message' => 'Resistencia eliminada correctamente.']);
    }

    public function restore($id)
    {
        $resistencia = Resistencia::findOrFail($id);
        $existeActiva = Resistencia::where('nombre_resistencia', $resistencia->nombre_resistencia)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una resistencia activa con el mismo nombre.'
            ]);
        }

        $resistencia->estado = 1;
        $resistencia->save();

        return response()->json([
            'success' => true,
            'message' => 'Resistencia activada correctamente.'
        ]);
    }
}
