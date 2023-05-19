<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function guardarImagen(Request $request)
    {
        if ($request->hasFile('utlFoto')) {
            $imagen = $request->file('urlFoto');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = public_path('/user') . $nombreImagen;
            // Guardar la imagen en el directorio especificado
            $imagen->move(public_path('/user'), $nombreImagen);

            // Aquí puedes guardar la ruta de la imagen en la base de datos o realizar otras operaciones necesarias

            return response()->json(['mensaje' => 'Imagen guardada correctamente']);
        }

        return response()->json(['error' => 'No se proporcionó ninguna imagen']);
    }


    public function register(Request $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($request->password);

        if ($request->hasFile('urlFoto')){

            $cadena = $request->file('urlFoto')->getClientOriginalName();
            $cadenaConvert = str_replace(" ", "_", $cadena);
            $nombre = Str::random(10) . '_' . $cadenaConvert;
            $rutaAlmacenamiento = 'profile/user/' . $nombre;
            $request->file('urlFoto')->storeAs('public', $rutaAlmacenamiento);

            $user->urlFoto = $rutaAlmacenamiento;
        }


        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('usuario', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('usuario', $request['usuario'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message'  => 'Hi' . $user->nombre,
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'user'         => $user,
            ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
