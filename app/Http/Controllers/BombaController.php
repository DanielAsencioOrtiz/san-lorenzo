<?php

namespace App\Http\Controllers;

use App\Models\Bomba;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BombaController extends Controller
{
    public function index()
    {
        $bombas = Bomba::where('estado', 1)->orderBy('created_at', 'desc')->get(); 
        $bombasEliminadas = Bomba::where('estado', 0)->orderBy('created_at', 'desc')->get();

        return view('bomba.index', compact('bombas', 'bombasEliminadas'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre_bomba' => [
                'required',
                'string',
                Rule::unique('bombas', 'nombre_bomba')->where('estado', 1)
            ],
        ], [
            'nombre_bomba.required' => 'El nombre del tipo de bomba es obligatorio.',
            'nombre_bomba.unique' => 'Ya existe el tipo de bomba activa con ese nombre.',
        ]);

        Bomba::create($request->only('nombre_bomba'));

        return redirect()->back()->with('mensaje', 'Bomba registrada.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_bomba' => [
                'required',
                'string',
                Rule::unique('bombas', 'nombre_bomba')->where('estado', 1)
            ],
        ], [
            'nombre_bomba.required' => 'El nombre del tipo de bomba es obligatorio.',
            'nombre_bomba.unique' => 'Ya existe el tipo de bomba activa con ese nombre.',
        ]);

        $bomba = Bomba::findOrFail($id);
        $bomba->update($request->only('nombre_bomba'));

        return redirect()->back()->with('mensaje', 'Bomba actualizada.');
    }

    public function destroy($id)
    {
        $bomba = Bomba::findOrFail($id);
        $bomba->update(['estado' => 0]);

        return redirect()->back()->with('mensaje', 'Bomba desactivada.');
    }

    public function restore($id)
    {
        $bomba = Bomba::findOrFail($id);
        $existeActiva = Bomba::where('nombre_bomba', $bomba->nombre_bomba)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una bomba activa con el mismo nombre.'
            ]);
        }

        $bomba->estado = 1;
        $bomba->save();

        return response()->json([
            'success' => true,
            'message' => 'Bomba activada correctamente.'
        ]);
    }
}
