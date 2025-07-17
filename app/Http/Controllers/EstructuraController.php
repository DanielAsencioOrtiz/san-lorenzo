<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Estructura;

class EstructuraController extends Controller
{
    public function index()
    {
        $estructuras = Estructura::where('estado', 1)->get();
        $estructurasEliminadas = Estructura::where('estado', 0)->get();
        return view('estructura.index', compact('estructuras', 'estructurasEliminadas'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'nombre_estructura' => [
                'required',
                'string',
                Rule::unique('estructuras', 'nombre_estructura')->where('estado', 1)
            ],
        ], [
            'nombre_estructura.required' => 'El nombre de la estructura es obligatorio.',
            'nombre.unique' => 'Ya existe una estructura activa con ese nombre.',
        ]);

        Estructura::create([
            'nombre_estructura' => $request->nombre_estructura,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Estructura registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $estructura = Estructura::findOrFail($id);

        $request->validate([
            'nombre_estructura' => [
                'required',
                'string',
                Rule::unique('estructuras', 'nombre_estructura')
                    ->where('estado', 1)
                    ->ignore($estructura->id)
            ],
        ], [
            'nombre_estructura.unique' => 'Ya existe otra estructura activa con ese nombre.',
        ]);

        $estructura->update([
            'nombre_estructura' => $request->nombre_estructura,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Estructura actualizada correctamente.');
    }

    public function destroy($id)
    {
        $estructura = Estructura::findOrFail($id);
        $estructura->estado = 0;
        $estructura->save();

        return response()->json(['success' => true, 'message' => 'Estructura eliminada correctamente.']);
    }

    public function restore($id)
    {
        $estructura = Estructura::findOrFail($id);
        $existeActiva = Estructura::where('nombre_estructura', $estructura->nombre_estructura)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una estructura activa con el mismo nombre.'
            ]);
        }

        $estructura->estado = 1;
        $estructura->save();

        return response()->json([
            'success' => true,
            'message' => 'Estructura activada correctamente.'
        ]);
    }
}
