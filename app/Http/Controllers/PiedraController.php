<?php

namespace App\Http\Controllers;

use App\Models\Piedra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PiedraController extends Controller
{
    public function index()
    {
        $piedras = Piedra::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $piedrasEliminadas = Piedra::where('estado', 0)->orderBy('created_at', 'desc')->get();
        return view('piedra.index', compact('piedras','piedrasEliminadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_piedra' => [
                'required',
                'string',
                Rule::unique('piedras', 'nombre_piedra')->where('estado', 1)
            ],
        ], [
            'nombre_piedra.required' => 'El nombre de la piedra es obligatorio.',
            'nombre_piedra.unique' => 'Ya existe una piedra activa con ese nombre.',
        ]);

        Piedra::create([
            'nombre_piedra' => $request->nombre_piedra,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Piedra registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $piedra = Piedra::findOrFail($id);

        $request->validate([
            'nombre_piedra' => [
                'required',
                'string',
                Rule::unique('piedras', 'nombre_piedra')
                    ->where('estado', 1)
                    ->ignore($piedra->id)
            ],
        ], [
            'nombre_piedra.unique' => 'Ya existe otro piedra activa con ese nombre.',
        ]);

        $piedra->update([
            'nombre_piedra' => $request->nombre_piedra,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Piedra actualizada correctamente.');
    }

    public function destroy($id)
    {
        $piedra = Piedra::findOrFail($id);
        $piedra->estado = 0;
        $piedra->save();

        return response()->json(['success' => true, 'message' => 'Piedra eliminada correctamente.']);
    }

    public function restore($id)
    {
        $piedra = Piedra::findOrFail($id);
        $existeActiva = Piedra::where('nombre_piedra', $piedra->nombre_piedra)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un piedra activa con el mismo nombre.'
            ]);
        }

        $piedra->estado = 1;
        $piedra->save();

        return response()->json([
            'success' => true,
            'message' => 'Piedra activado correctamente.'
        ]);
    }
}
