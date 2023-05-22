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

    public function register(Request $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($request->password);

        if ($request->hasFile('urlFoto')) {

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

    public function delete(Request $request)
    {
        auth()->user()->tokens()->delete();
        $request->user()->deleteProfilePhoto();
        auth()->user()->tokens->each->delete();
        $request->user()->delete();
        return [
            'message' => 'delete exitoso!!!'
        ];
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
    public function show($id)
    {

        // $userData = User::findOrFail($id);

        $user = User::with('casas')->find($id);

        return response()->json($user);
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
    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre' => 'nullable',
            'usuario' => 'nullable',
            'fechaNacimiento' => 'nullable',
            'identificacion' => 'nullable',
            'urlFoto' => 'nullable',
        ]);

        if ($request->hasFile('urlFoto')) {
            $cadena = $request->file('urlFoto')->getClientOriginalName();
            $cadenaConvert = str_replace(" ", "_", $cadena);
            $nombre = Str::random(10) . '_' . $cadenaConvert;
            $rutaAlmacenamiento = 'profile/user/' . $nombre;
            $request->file('urlFoto')->storeAs('public', $rutaAlmacenamiento);

            $data['urlFoto'] = $rutaAlmacenamiento;
        }

        $user->update($data);

        return response()->json($user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}
