<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $sedesEliminadas = Sede::where('estado', 0)->orderBy('created_at', 'desc')->get();

        return view('sede.index', compact('sedes', 'sedesEliminadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_sede' => [
                'required',
                'string',
                Rule::unique('sedes', 'nombre_sede')->where('estado', 1)
            ],
        ], [
            'nombre_sede.required' => 'El nombre de la sede es obligatorio.',
            'nombre_sede.unique' => 'Ya existe una sede activa con ese nombre.',
        ]);

        Sede::create($request->only('nombre_sede'));

        return redirect()->back()->with('mensaje', 'Sede registrada.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_sede' => [
                'required',
                'string',
                Rule::unique('sedes', 'nombre_sede')->where('estado', 1)->ignore($id)
            ],
        ], [
            'nombre_sede.required' => 'El nombre de la sede es obligatorio.',
            'nombre_sede.unique' => 'Ya existe una sede activa con ese nombre.',
        ]);

        $sede = Sede::findOrFail($id);
        $sede->update($request->only('nombre_sede'));

        return redirect()->back()->with('mensaje', 'Sede actualizada.');
    }

    public function destroy($id)
    {
        $sede = Sede::findOrFail($id);
        $sede->update(['estado' => 0]);

        return redirect()->back()->with('mensaje', 'Sede desactivada.');
    }

    public function restore($id)
    {
        $sede = Sede::findOrFail($id);
        $existeActiva = Sede::where('nombre_sede', $sede->nombre_sede)->where('estado', 1)->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una sede activa con el mismo nombre.'
            ]);
        }

        $sede->estado = 1;
        $sede->save();

        return response()->json([
            'success' => true,
            'message' => 'Sede activada correctamente.'
        ]);
    }
}
