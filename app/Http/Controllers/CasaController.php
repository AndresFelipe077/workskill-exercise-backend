<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Casa::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $casa = new Casa($data);
        if ($request->hasFile('urlFoto')) {

            $cadena = $request->file('urlFoto')->getClientOriginalName();
            $cadenaConvert = str_replace(" ", "_", $cadena);
            $nombre = Str::random(10) . '_' . $cadenaConvert;
            $rutaAlmacenamiento = 'casas/disponibles/' . $nombre;
            $request->file('urlFoto')->storeAs('public', $rutaAlmacenamiento);

            $casa->urlFoto = $rutaAlmacenamiento;
        }
        $casa->save();

        return response()->json($casa, 200);
    }

    public function casasDisponibles()
    {
        $casasDisponibles = Casa::whereHas('estado', function ($query) {
            $query->where('id', 3);
        })->get();

        $casasDisponibles->transform(function ($casa) {
            $casa->urlFoto = Storage::url($casa->urlFoto);
            return $casa;
        });

        return response()->json($casasDisponibles, 200);
    }


    public function show($id)
    {
        $data = Casa::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $casaActualizada = Casa::findOrFail($id);

        $casaActualizada->update($data); // Actualiza los datos de la casa con los datos enviados en la solicitud

        return response()->json($casaActualizada, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Casa::findOrFail($id);
        $data->delete();
        return response()->json("Se elimino", 200);
    }
}
