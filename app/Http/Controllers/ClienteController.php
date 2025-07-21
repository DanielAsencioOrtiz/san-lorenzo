<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Cliente;
use App\Models\TipoDocumento;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('documento', 'distrito.provincia.departamento')->where('estado', 1)->get();
        $clientesEliminados = Cliente::where('estado', 0)->get();
        $documentos = TipoDocumento::where('estado', 1)->where('mostrar_cliente', 1)->get();
        $departamentos = Departamento::all();

        return view('clientes.index', compact('clientes', 'clientesEliminados', 'documentos', 'departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nro_documento' => [
                'required',
                Rule::unique('clientes', 'nro_documento')->where('estado', 1)
            ],
            'id_documento' => 'required',
            'nombre' => 'required',
            'direccion' => 'required',
            'id_distrito' => 'required',
        ], [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'Ya existe un cliente activo con ese número de documento.',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('mensaje', 'Cliente creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nro_documento' => [
                'required',
                Rule::unique('clientes', 'nro_documento')->where('estado', 1)->ignore($cliente->id)
            ],
            'id_documento' => 'required',
            'nombre' => 'required',
            'direccion' => 'required',
            'id_distrito' => 'required',
        ], [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'Ya existe un cliente activo con ese número de documento.',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('mensaje', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update(['estado' => 0]);

        return response()->json(['message' => 'Cliente eliminado correctamente.']);
    }

    public function restore($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Verificar si ya existe un cliente activo con el mismo número de documento
        $existeActivo = Cliente::where('nro_documento', $cliente->nro_documento)
            ->where('estado', 1)
            ->exists();

        if ($existeActivo) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un cliente activo con el mismo número de documento.'
            ]);
        }

        // Restaurar cliente
        $cliente->estado = 1;
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => 'Cliente restaurado correctamente.'
        ]);
    }

    public function getProvincias($id)
    {
        $provincias = Provincia::where('id_departamento', $id)->get();
        return response()->json($provincias);
    }

    public function getDistritos($id)
    {
        $distritos = Distrito::where('id_provincia', $id)->get();
        return response()->json($distritos);
    }


    public function consultaDocumento($tipo, $numero)
    {
        $token = config('services.apisnetpe.token');

        if (!in_array($tipo, ['dni', 'ruc'])) {
            return response()->json(['error' => 'Tipo de documento no válido'], 400);
        }

        $url = match($tipo) {
            'dni' => "https://api.apis.net.pe/v2/reniec/dni?numero={$numero}",
            'ruc' => "https://api.apis.net.pe/v2/sunat/ruc/full?numero={$numero}"
        };

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ])->get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo consultar el documento.'], 400);
        }

        return response()->json($response->json());
    }

}
