<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 6. Importar paquetes a usar
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \stdClass;

class AuthController extends Controller
{
    // 7. Crear lógica para registrar usuarios
    public function register(Request $request)
    {
        // Validar todos los campos en la petición
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Verificar que los campos recibidos estén bien
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Crear nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Crear el token de autenticación
        /**
         * Error: No se encontraba el método createToken en el modelo User
         * Solución: Usar el paquete HasApiTokens de Sanctum
         */
        $token = $user->createToken('auth_token')->plainTextToken;


        // Responder a la petición en formato JSON, donde
        /**
         * data => usuario
         * access_token => token de autenticación
         * token_type => 'Bearer'
         */
        return response()
            ->json([
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
    }

    // 9. Crear lógica para autenticar usuarios
    public function login(Request $request)
    {
        // Intentar autenticar al usuario
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        // Buscar el usuario donde el email coincida con lo que el usuario digitó
        $user = User::where('email', $request['email'])->firstOrFail();

        // Crear el token de autenticación
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver la respuesta con
        /**
         * message => Hi {usuario}
         * accessToken => $token
         * token_type => 'Bearer'
         * user => usuario
         */
        return response()->json([
            'message' => 'Hola ' . $user->name,
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // 11. Crear lógica para cerrar sesión
    public function logout(){
        auth()->user()->tokens()->delete();

        return [
            'message'=>'Se ha cerrado sesión con éxito y todos los tokens han sido eliminados'
        ];
    }
}
