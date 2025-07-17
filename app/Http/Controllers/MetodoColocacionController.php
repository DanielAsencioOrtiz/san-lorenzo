<?php

namespace App\Http\Controllers;

use App\Models\MetodoColocacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MetodoColocacionController extends Controller
{
    public function index()
    {
        $metodosColocacion = MetodoColocacion::where('estado', 1)->get();
        $metodosEliminados = MetodoColocacion::where('estado', 0)->get();

        return view('metodo_colocacion.index', compact('metodosColocacion', 'metodosEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_metodo' => 'required|string|unique:metodo_colocacions,nombre_metodo',
        ]);

        MetodoColocacion::create([
            'nombre_metodo' => $request->nombre_metodo
        ]);

        return back()->with('mensaje', 'Método de colocación registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $metodo = MetodoColocacion::findOrFail($id);

        $request->validate([
            'nombre_metodo' => [
                'required',
                'string',
                Rule::unique('metodo_colocacions', 'nombre_metodo')->ignore($metodo->id)
            ]
        ]);

        $metodo->update([
            'nombre_metodo' => $request->nombre_metodo
        ]);

        return back()->with('mensaje', 'Método de colocación actualizado correctamente.');
    }

    public function destroy($id)
    {
        $metodo = MetodoColocacion::findOrFail($id);
        $metodo->estado = 0;
        $metodo->save();

        return response()->json(['success' => true, 'message' => 'Método de colocación eliminado correctamente.']);
    }

    public function restore($id)
    {
        $metodo = MetodoColocacion::findOrFail($id);
        $metodo->estado = 1;
        $metodo->save();

        return response()->json(['success' => true, 'message' => 'Método de colocación restaurado correctamente.']);
    }
}
