<?php

namespace App\Http\Controllers;

use App\Models\persona;
use App\Models\rolPersona;
use App\Models\rolPersonas;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthControler extends Controller
{
    //

    public function register(Request $request)
    {
        //agregar persona y asiganr el rol

        $validator = Validator::make($request->all(),[
            'documento' => 'required|string|unique:personas,documento',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email|unique:personas,email',
            'telefono' => 'nullable|string',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated = $validator->validated();

        $user = persona::create($validated);
        $token = $user->createToken('default', ['*'])->plainTextToken;

        return response()->json(['message' => 'Usuario registrado exitosamente', 'user' => $user, 'token'=>$token], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada exitosamente'], 200);
    }


    public function registerRolPersona(Request $request)
    {
        //asignar rol a la persona
        $validator = Validator::make($request->all(),[
            'idPersona' => 'required|exists:personas,idPersona',
            'idRol' => 'required|exists:rols,idRol'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated = $validator->validated();

        $rolPersona = rolPersonas::create($validated);
        return response()->json(['message' => 'Rol asignado exitosamente', 'rolPersona' => $rolPersona], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated = $validator->validated();

        $user = persona::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $token = $user->createToken('default', ['*'])->plainTextToken;
        return response()->json(['message' => 'Inicio de sesión exitoso', 'user' => $user, 'token'=>$token], 200);
    }
}
