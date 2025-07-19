<?php

namespace App\Http\Controllers;

use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoDocumentoController extends Controller
{
    public function index()
    {
        $documentos = TipoDocumento::where('estado', 1)->orderBy('created_at', 'desc')->get();
        $documentosEliminados = TipoDocumento::where('estado', 0)->orderBy('created_at', 'desc')->get();

        return view('tipo_documento.index', compact('documentos', 'documentosEliminados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_documento' => [
                'required',
                Rule::unique('tipo_documentos', 'nombre_documento')->where('estado', 1)
            ],
        ], [
            'nombre_documento.required' => 'El nombre del documento es obligatorio.',
            'nombre_documento.unique' => 'Ya existe un tipo de documento activo con ese nombre.',
        ]);

        TipoDocumento::create([
            'nombre_documento' => $request->nombre_documento,
            'mostrar_cliente' => $request->has('mostrar_cliente'),
            'mostrar_personal' => $request->has('mostrar_personal'),
            'estado' => 1,
        ]);

        return redirect()->back()->with('mensaje', 'Tipo de documento registrado.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_documento' => [
                'required',
                Rule::unique('tipo_documentos', 'nombre_documento')->where('estado', 1)->ignore($id)
            ],
        ], [
            'nombre_documento.required' => 'El nombre del documento es obligatorio.',
            'nombre_documento.unique' => 'Ya existe un tipo de documento activo con ese nombre.',
        ]);

        $documento = TipoDocumento::findOrFail($id);
        $documento->update([
            'nombre_documento' => $request->nombre_documento,
            'mostrar_cliente' => $request->has('mostrar_cliente'),
            'mostrar_personal' => $request->has('mostrar_personal'),
        ]);

        return redirect()->back()->with('mensaje', 'Tipo de documento actualizado.');
    }

    public function destroy($id)
    {
        $doc = TipoDocumento::findOrFail($id);
        $doc->update(['estado' => 0]);

        return redirect()->back()->with('mensaje', 'Documento desactivado.');
    }

    public function restore($id)
    {
        $doc = TipoDocumento::findOrFail($id);
        $existe = TipoDocumento::where('nombre_documento', $doc->nombre_documento)->where('estado', 1)->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un tipo de documento activo con el mismo nombre.'
            ]);
        }

        $doc->update(['estado' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Tipo de documento restaurado correctamente.'
        ]);
    }
}
