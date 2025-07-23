<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramaDespacho;
use App\Models\Sede;
use App\Models\Personal;

class ProgramaDespachoController extends Controller
{
        public function index()
    {
        $programas = ProgramaDespacho::where('estado', 1)->with('sede')->get();
        $programasEliminados = ProgramaDespacho::where('estado', 0)->with('sede')->get();
        $sedes = Sede::where('estado', 1)->get();
        $personalDisponible = Personal::where('estado', 1)->get();

        return view('programa_despacho.index', compact('programas', 'programasEliminados', 'sedes', 'personalDisponible'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_programa' => 'required|date',
            'id_sede' => 'required|exists:sedes,id',
            'hora_entrada_personal' => 'nullable',
        ]);

        $programa = ProgramaDespacho::create($request->all() + ['estado' => 1]);

        if ($request->has('id_personal')) {
            $programa->personalDespacho()->sync($request->input('id_personal'));
        }

        return redirect()->route('programas.index')->with('mensaje', 'Programa creado con éxito.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_programa' => 'required|date',
            'id_sede' => 'required|exists:sedes,id',
            'hora_entrada_personal' => 'nullable',
        ]);

        $programa = ProgramaDespacho::findOrFail($id);
        $programa->update($request->all());

        if ($request->has('id_personal')) {
            $programa->personalDespacho()->sync($request->input('id_personal'));
        } else {
            $programa->personalDespacho()->detach();
        }

        return redirect()->route('programas.index')->with('mensaje', 'Programa actualizado.');
    }

    public function destroy($id)
    {
        $programa = ProgramaDespacho::findOrFail($id);
        $programa->estado = 0;
        $programa->save();

        return response()->json(['message' => 'Programa marcado como eliminado.']);
    }

    public function restore($id)
    {
        $programa = ProgramaDespacho::findOrFail($id);
        $programa->estado = 1;
        $programa->save();

        return response()->json(['success' => true, 'message' => 'Programa restaurado.']);
    }
}
