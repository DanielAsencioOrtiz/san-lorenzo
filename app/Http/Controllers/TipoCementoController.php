<?php

namespace App\Http\Controllers;

use App\Models\TipoCemento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoCementoController extends Controller
{
    public function index()
    {
        $tipo_cementos = TipoCemento::where('estado', 1)->get();
        $tipo_cementosEliminados = TipoCemento::where('estado', 0)->get();
        
        return view('tipo_cemento.index', compact('tipo_cementos', 'tipo_cementosEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:255'
        ]);

        TipoCemento::create([
            'nombre_tipo' => $request->nombre_tipo,
            'estado' => 1
        ]);
        return back()->with('mensaje', 'Tipo de cemento creado correctamente.');
    }

    

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:255'
        ]);

        $tipo = TipoCemento::findOrFail($id);
        $tipo->update([
            'nombre_tipo' => $request->nombre_tipo
        ]);

        return back()->with('mensaje', 'Tipo de cemento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $tipo = TipoCemento::findOrFail($id);
        $tipo->estado = 0;
        $tipo->save();

        return response()->json(['success' => true, 'message' => 'Tipo de cemento eliminado correctamente.']);
    }

    public function restore($id)
    {
        $tipo = TipoCemento::findOrFail($id);
        $tipo->estado = 1;
        $tipo->save();

        return response()->json(['success' => true, 'message' => 'Tipo de cemento restaurado correctamente.']);
    }



}
