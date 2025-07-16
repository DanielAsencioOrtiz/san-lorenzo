<?php

namespace App\Http\Controllers;

use App\Models\Movil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovilController extends Controller
{
    public function index()
    {
        $movils = Movil::where('estado', 1)->get();
        return view('movil.index', compact('movils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string',
            'placa' => [
                'required',
                'string',
                Rule::unique('movils', 'placa')->where('estado', 1)
            ],
        ], [
            'placa.unique' => 'Ya existe una movilidad activa con esa placa.',
            'marca.required' => 'La marca es obligatoria.',
            'placa.required' => 'La placa es obligatoria.',
        ]);

        Movil::create([
            'marca' => $request->marca,
            'placa' => $request->placa,
        ]);

        return back()->with('mensaje', 'Movilidad registrada correctamente.');
    }


    public function update(Request $request, $id)
    {
        $movil = Movil::findOrFail($id);

        $request->validate([
            'marca' => 'required|string',
            'placa' => [
                'required',
                'string',
                Rule::unique('movils', 'placa')
                    ->where('estado', 1)
                    ->ignore($movil->id)
            ],
        ], [
            'placa.unique' => 'Ya existe otra movilidad activa con esa placa.',
        ]);

        $movil->update([
            'marca' => $request->marca,
            'placa' => $request->placa,
        ]);

        return back()->with('mensaje', 'Movilidad actualizada correctamente.');
    }


    public function destroy($id)
    {
        $movil = Movil::findOrFail($id);
        $movil->estado = 0;
        $movil->save();

        return response()->json(['success' => true, 'message' => 'Movilidad eliminada correctamente.']);

    }
}
