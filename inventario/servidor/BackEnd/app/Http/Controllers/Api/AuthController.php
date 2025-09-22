<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:30',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|string|min:6',
        ]);

        $usuario = usuarios::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hasheo de contraseña
        ]);

        $token = JWTAuth::fromUser($usuario);

        return response()->json([
            'JWT' => $token,
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentamos generar el token con las credenciales
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales no válidas'], 401);
        }

        return response()->json([
            'JWT' => $token,
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $usuario = auth()->user(); // Obtiene el usuario autenticado

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $usuario->password = Hash::make($request->new_password);
        $usuario->save();

        return response()->json(['message' => 'Contraseña cambiada exitosamente'], 200);
    }
}
