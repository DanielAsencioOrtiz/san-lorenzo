<?php

namespace App\Http\Controllers;

use App\Models\Slam;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SlamController extends Controller
{
    public function index()
    {
        $slams = Slam::where('estado', 1)->get();
        $slamsEliminadas = Slam::where('estado', 0)->get();
        return view('slam.index', compact('slams','slamsEliminadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_slam' => [
                'required',
                'string',
                Rule::unique('slams', 'nombre_slam')->where('estado', 1)
            ],
        ], [
            'nombre_slam.required' => 'El nombre de la slam es obligatorio.',
            'nombre_slam.unique' => 'Ya existe una slam activa con ese nombre.',
        ]);

        Slam::create([
            'nombre_slam' => $request->nombre_slam,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Slam registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $slam = Slam::findOrFail($id);

        $request->validate([
            'nombre_slam' => [
                'required',
                'string',
                Rule::unique('slams', 'nombre_slam')
                    ->where('estado', 1)
                    ->ignore($slam->id)
            ],
        ], [
            'nombre_slam.unique' => 'Ya existe otro slam activa con ese nombre.',
        ]);

        $slam->update([
            'nombre_slam' => $request->nombre_slam,
            'estado' => $request->estado ?? 1,
        ]);

        return back()->with('mensaje', 'Slam actualizada correctamente.');
    }

    public function destroy($id)
    {
        $slam = Slam::findOrFail($id);
        $slam->estado = 0;
        $slam->save();

        return response()->json(['success' => true, 'message' => 'Slam eliminada correctamente.']);
    }

    public function restore($id)
    {
        $slam = Slam::findOrFail($id);
        $existeActiva = Slam::where('nombre_slam', $slam->nombre_slam)
            ->where('estado', 1)
            ->exists();

        if ($existeActiva) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un slam activa con el mismo nombre.'
            ]);
        }

        $slam->estado = 1;
        $slam->save();

        return response()->json([
            'success' => true,
            'message' => 'Slam activado correctamente.'
        ]);
    }
}
