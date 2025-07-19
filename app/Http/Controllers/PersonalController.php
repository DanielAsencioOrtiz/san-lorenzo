<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\TipoDocumento;
use App\Models\TipoPersonal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    public function index()
    {
        $personales = Personal::with(['tipoDocumento', 'tipoPersonal'])->where('estado', 1)->orderBy('created_at', 'desc')->get();
        $eliminados = Personal::with(['tipoDocumento', 'tipoPersonal'])->where('estado', 0)->orderBy('created_at', 'desc')->get();
        $tiposDocumento = TipoDocumento::where('estado', 1)->where('mostrar_personal', 1)->get();
        $tiposPersonal = TipoPersonal::where('estado', 1)->get();

        return view('personal.index', compact('personales', 'eliminados', 'tiposDocumento', 'tiposPersonal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nro_documento' => [
                'required',
                'numeric',
                Rule::unique('personals')->where(function ($query) {
                    return $query->where('estado', 1);
                }),
            ],
            'id_documento' => 'required|exists:tipo_documentos,id',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'nullable|string',
            'id_tipo_personal' => 'required|exists:tipo_personals,id',
        ], [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.numeric' => 'El número de documento debe ser numérico.',
            'nro_documento.unique' => 'Ya existe un personal activo con este número de documento.',
        ]);

        Personal::create($request->all() + ['estado' => 1]);

        return redirect()->back()->with('mensaje', 'Personal registrado.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nro_documento' => [
                'required',
                'numeric',
                Rule::unique('personals')->where(function ($query) {
                    return $query->where('estado', 1);
                })->ignore($id),
            ],
            'id_documento' => 'required|exists:tipo_documentos,id',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'nullable|string',
            'id_tipo_personal' => 'required|exists:tipo_personals,id',
        ], [
            'nro_documento.unique' => 'Ya existe un personal activo con este número de documento.',
        ]);

        $personal = Personal::findOrFail($id);
        $personal->update($request->all());

        return redirect()->back()->with('mensaje', 'Personal actualizado.');
    }

    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->update(['estado' => 0]);

        return redirect()->back()->with('mensaje', 'Personal desactivado.');
    }

    public function restore($id)
    {
        $personal = Personal::findOrFail($id);

        // Verificar si ya hay un personal activo con el mismo nro_documento
        $existeActivo = Personal::where('nro_documento', $personal->nro_documento)
            ->where('estado', 1)
            ->exists();

        if ($existeActivo) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un personal activo con el mismo número de documento.'
            ]);
        }

        // Restaurar
        $personal->update(['estado' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Personal restaurado correctamente.'
        ]);
    }

}
