<?php

namespace App\Http\Controllers;

use App\Models\Cantera;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CanteraController extends Controller
{
    public function index()
    {
        $canteras = Cantera::where('estado', 1)->orderBy('created_at', 'desc')->get(); 
        $canterasEliminadas = Cantera::where('estado', 0)->orderBy('created_at', 'desc')->get();

        return view('cantera.index', compact('canteras', 'canterasEliminadas'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre_cantera' => [
                'required',
                'string',
                Rule::unique('canteras', 'nombre_cantera')->where('estado', 1)
            ],
        ], [
            'nombre_cantera.required' => 'El nombre del tipo de cantera es obligatorio.',
            'nombre_cantera.unique' => 'Ya existe el tipo de cantera activa con ese nombre.',
        ]);

        Cantera::create($request->only('nombre_cantera'));

        return redirect()->back()->with('mensaje', 'Cantera registrada.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_cantera' => [
                'required',
                'string',
                Rule::unique('canteras', 'nombre_cantera')->where('estado', 1)
            ],
        ], [
            'nombre_cantera.required' => 'El nombre del tipo de cantera es obligatorio.',
            'nombre_cantera.unique' => 'Ya existe el tipo de cantera activa con ese nombre.',
        ]);

        $cantera = Cantera::findOrFail($id);
        $cantera->update($request->only('nombre_cantera'));

        return redirect()->back()->with('mensaje', 'Cantera actualizada.');
    }

    public function destroy($id)
    {
        $cantera = Cantera::findOrFail($id);
        $cantera->update(['estado' => 0]);

        return redirect()->back()->with('mensaje', 'Cantera desactivada.');
    }

    public function restore($id)
    {
        $cantera = Cantera::findOrFail($id);
        $existeActiva = Cantera::where('nombre_cantera', $cantera->nombre_cantera)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una cantera activa con el mismo nombre.'
            ]);
        }

        $cantera->estado = 1;
        $cantera->save();

        return response()->json([
            'success' => true,
            'message' => 'Cantera activada correctamente.'
        ]);
    }
}
