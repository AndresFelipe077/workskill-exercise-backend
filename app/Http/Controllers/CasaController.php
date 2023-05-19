<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use Illuminate\Http\Request;

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
        $casa->save();

        return response()->json($casa, 200);
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
