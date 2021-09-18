<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //validar datos
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        // Ahora hay que crear la contraseña y antes hay que encriptarla.
        $credentials['password'] = Hash::make($credentials['password']);
        // Crear un nuevo usuario
        
        $usuario = User::create($credentials);

        // Generar el Token

        $token = $usuario->createToken('TokenUsuario')->plainTextToken;

        // Devolver respuesta

        $respuesta = [

            'data' => [   

            'usuario' => $usuario,

            'token' => $token
            ],
            
        ];
            return response()->json($respuesta);
    }
}
