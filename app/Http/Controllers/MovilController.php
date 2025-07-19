<?php

namespace App\Http\Controllers;

use App\Models\Movil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovilController extends Controller
{
    public function index()
    {
        $movils = Movil::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $movilsEliminados = Movil::where('estado', 0)->orderBy('created_at', 'desc')->get();
        return view('movil.index', compact('movils','movilsEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string',
            'placa' => 'required|string',
            'serie' => [
                'required',
                'string',
                Rule::unique('movils', 'serie')->where('estado', 1)
            ],
        ], [
            'serie.unique' => 'Ya existe una maquinaria activa con esa serie.',
            'modelo.required' => 'La modelo es obligatoria.',
            'placa.required' => 'La placa es obligatoria.',
            'serie.required' => 'La serie es obligatoria.',
        ]);

        Movil::create([
            'modelo' => $request->modelo,
            'placa' => $request->placa,
            'serie' => $request->serie,
            'descripcion'=> $request->descripcion,
            'forms'=> $request->forms
        ]);

        return back()->with('mensaje', 'Maquinaria registrada correctamente.');
    }


    public function update(Request $request, $id)
    {
        $movil = Movil::findOrFail($id);

        $request->validate([
            'modelo' => 'required|string',
            'placa' => 'required|string',
            'serie' => [
                'required',
                'string',
                Rule::unique('movils', 'serie')->where('estado', 1)->ignore($movil->id)
            ],
        ], [
            'serie.unique' => 'Ya existe una maquinaria activa con esa serie.',
            'modelo.required' => 'La modelo es obligatoria.',
            'placa.required' => 'La placa es obligatoria.',
            'serie.required' => 'La serie es obligatoria.',
        ]);

        $movil->update([
            'modelo' => $request->modelo,
            'placa' => $request->placa,
            'serie' => $request->serie,
            'descripcion'=> $request->descripcion,
            'forms'=> $request->forms
        ]);

        return back()->with('mensaje', 'Maquinaria actualizada correctamente.');
    }


    public function destroy($id)
    {
        $movil = Movil::findOrFail($id);
        $movil->estado = 0;
        $movil->save();

        return response()->json(['success' => true, 'message' => 'Maquinaria eliminada correctamente.']);

    }

    public function restore($id)
    {
        $movil = Movil::findOrFail($id);
        $existeActiva = Movil::where('serie', $movil->serie)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una maquinaria activa con la misma serie.'
            ]);
        }

        $movil->estado = 1;
        $movil->save();

        return response()->json([
            'success' => true,
            'message' => 'Maquinaria restaurada correctamente.'
        ]);
    }

}
