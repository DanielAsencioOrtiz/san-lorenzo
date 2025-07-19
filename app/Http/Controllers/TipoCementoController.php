<?php

namespace App\Http\Controllers;

use App\Models\TipoCemento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoCementoController extends Controller
{
    public function index()
    {
        $tipo_cementos = TipoCemento::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $tipo_cementosEliminados = TipoCemento::where('estado', 0)->orderBy('created_at', 'desc')->get();
        
        return view('tipo_cemento.index', compact('tipo_cementos', 'tipo_cementosEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:255'
        ]);

        $request->validate([
            'nombre_tipo' => [
                'required',
                'string',
                Rule::unique('tipo_cementos', 'nombre_tipo')->where('estado', 1)
            ],
        ], [
            'nombre_tipo.required' => 'El nombre del tipo de cemento es obligatorio.',
            'nombre_tipo.unique' => 'Ya existe el tipo de cemento activa con ese nombre.',
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
            'nombre_tipo' => [
                'required',
                'string',
                Rule::unique('tipo_cementos', 'nombre_tipo')->where('estado', 1)
            ],
        ], [
            'nombre_tipo.required' => 'El nombre del tipo de cemento es obligatorio.',
            'nombre_tipo.unique' => 'Ya existe el tipo de cemento activa con ese nombre.',
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
        $existeActiva = TipoCemento::where('nombre_tipo', $tipo->nombre_tipo)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una tipo activa con el mismo nombre.'
            ]);
        }

        $tipo->estado = 1;
        $tipo->save();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de cemento restaurado correctamente.'
        ]);
    }



}
