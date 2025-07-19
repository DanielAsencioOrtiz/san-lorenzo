<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObraController extends Controller
{
    public function index()
    {
        $obras = Obra::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $obrasEliminadas = Obra::where('estado', 0)->orderBy('created_at', 'desc')->get();
        return view('obra.index', compact('obras', 'obrasEliminadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_obra' => [
                'required',
                'string',
                Rule::unique('obras', 'nombre_obra')->where('estado', 1)
            ],
        ], [
            'nombre_obra.required' => 'El nombre de la obra es obligatorio.',
            'nombre_obra.unique' => 'Ya existe una obra activa con ese nombre.',
        ]);

        Obra::create([
            'nombre_obra' => $request->nombre_obra,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Obra registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $obra = Obra::findOrFail($id);

        $request->validate([
            'nombre_obra' => [
                'required',
                'string',
                Rule::unique('obras', 'nombre_obra')
                    ->where('estado', 1)
                    ->ignore($obra->id)
            ],
        ], [
            'nombre_obra.required' => 'El nombre de la obra es obligatorio.',
            'nombre_obra.unique' => 'Ya existe otra obra activa con ese nombre.',
        ]);

        $obra->update([
            'nombre_obra' => $request->nombre_obra,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Obra actualizada correctamente.');
    }

    public function destroy($id)
    {
        $obra = Obra::findOrFail($id);
        $obra->estado = 0;
        $obra->save();

        return response()->json(['success' => true, 'message' => 'Obra eliminada correctamente.']);
    }

    public function restore($id)
    {
        $obra = Obra::findOrFail($id);
        $existeActiva = Obra::where('nombre_obra', $obra->nombre_obra)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una obra activa con el mismo nombre.'
            ]);
        }

        $obra->estado = 1;
        $obra->save();

        return response()->json([
            'success' => true,
            'message' => 'Obra activada correctamente.'
        ]);
    }
}
