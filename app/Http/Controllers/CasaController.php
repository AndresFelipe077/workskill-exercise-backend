<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Models\Casa;
use App\Models\User;
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
        $casa = Casa::with(
            [
                'categoria',
                'estado',
            ]
        );
        return response()->json($casa->get());
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
            $query->where('nombre', 'Disponible');
        })->get();

        $casasDisponibles->transform(function ($casa) {
            $casa->urlFoto = Storage::url($casa->urlFoto);
            return $casa;
        });

        return response()->json($casasDisponibles, 200);
    }


    public function show($id)
    {
        $casa = Casa::with(['categoria', 'estado'])->find($id);
        $casa->urlFoto = Storage::url($casa->urlFoto);
        return $casa->toJson();
    }

    public function casasCabanas()
    {
        $casasCabanas = Casa::whereHas('categoria', function ($query) {
            $query->where('nombre', 'cabaña');
        })->get();

        $casasCabanas->transform(function ($casa) {
            $casa->urlFoto = Storage::url($casa->urlFoto);
            return $casa;
        });

        return response()->json($casasCabanas, 200);
    }

    public function casasEcologicas()
    {
        $casasEcologicas = Casa::whereHas('categoria', function ($query) {
            $query->where('nombre', 'casa ecologica');
        })->get();

        $casasEcologicas->transform(function ($casa) {
            $casa->urlFoto = Storage::url($casa->urlFoto);
            return $casa;
        });

        return response()->json($casasEcologicas, 200);
    }

    public function casasFamiliares()
    {
        $casasFamiliares = Casa::whereHas('categoria', function ($query) {
            $query->where('nombre', 'casa familiar');
        })->get();

        $casasFamiliares->transform(function ($casa) {
            $casa->urlFoto = Storage::url($casa->urlFoto);
            return $casa;
        });

        return response()->json($casasFamiliares, 200);
    }

    public function casasPrefabricadas()
    {
        $casasPrefabricadas = Casa::whereHas('categoria', function ($query) {
            $query->where('nombre', 'casa prefabricada');
        })->get();

        $casasPrefabricadas->transform(function ($casa) {
            $casa->urlFoto = Storage::url($casa->urlFoto);
            return $casa;
        });

        return response()->json($casasPrefabricadas, 200);
    }

    public function alquiler(Request $request, $id)
    {
        $casa = Casa::find($id);

        if (!$casa) {
            return response()->json(['message' => 'Casa no encontrada'], 404);
        }

        // // Obtener datos del usuario actualmente autenticado
        // $userId = 1;
        // $user = auth()->user()->id;

        // Verificar si existe un registro de alquiler pendiente para la casa y el usuario actual
        // $alquilerPendiente = Alquiler::where('idCasa', $casa->id)
        //     ->where('idUser', 1)
        //     ->whereNull('fechaCancelacion')
        //     ->first();

        // if ($alquilerPendiente) {
        //     return response()->json(['message' => 'Ya tienes un alquiler pendiente para esta casa'], 400);
        // }

        // Crear el registro en la tabla "Alquilar"
        $alquiler = new Alquiler();
        $alquiler->idCasa = $casa->id;
        $alquiler->idUser = $request->input('idUser');
        // $alquiler->idEstadoAlquiler = $request->input('idEstadoAlquiler');
        $alquiler->descuento = 30;
        $alquiler->fechaInicio = $request->input('fechaInicio');
        $alquiler->fechaFin = $request->input('fechaFin');

        $alquiler->save();

        $nuevoIdEstado = 4; // Reemplaza con el nuevo ID de estado que deseas asignar
        $casa->estado()->associate($nuevoIdEstado);

        $casa->save();

        return response()->json(['message' => 'Casa alquilada exitosamente'], 200);
    }

    public function misCasas($idUser, $idCasa)
    {
        $dataUser = User::find($idUser);
        $dataCasa = Casa::find($idCasa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $casaActualizada = Casa::findOrFail($id);

        $casaActualizada->fill($data);


        if ($request->hasFile('urlFoto')) {
            $cadena = $request->file('urlFoto')->getClientOriginalName();
            $cadenaConvert = str_replace(" ", "_", $cadena);
            $nombre = Str::random(10) . '_' . $cadenaConvert;
            $rutaAlmacenamiento = 'casas/disponibles/' . $nombre;
            $request->file('urlFoto')->storeAs('public', $rutaAlmacenamiento);
        
            $casaActualizada->urlFoto = $rutaAlmacenamiento;
        }

        
        $casaActualizada->save();
    
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
