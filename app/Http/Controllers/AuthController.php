<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //registra los usuarios
    public function register(Request $request){
        //validación de los datos
        $validator = Validator::make($request->all(),[
            //texto obligatorio de 255 caracteres
            'name'=>'required|string|max:255',
            //texto requerido, que cumpla escritura correo, de 255 caracteres y único en tabla usuarios
            'email'=>'required|string|email|max:255|unique:users',
            //password requerido con mínimo 8 caracteres
            'password'=>'required|string|min:8'
        ]);
        if($validator->fails()){
            //se devueven los errores que se presenten
            return response()->json($validator->errors());
        }
        //llamamos al método User create
        $user = User::create([
            //los campos 'name''email''password' les asignamos los valores name, email, password que vienen del 
            //formulario llenado por el usuario
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        //creamos el token de la autenticación 'auth_token' que devolvemos por la petición plainTexttoken
        $token = $user->createToken('auth_token')->plainTextToken;
        //retornamos función response, devolvemos la respuesta en formato json, en la data enviamos toda la información 
        //de $usuarios, creamos un acceso token y el tipo de token es del tipo Bearer
        return response()->json(['data'=>$user,'access_token'=> $token,'token_type'=>'Bearer']);
    }   
    //autenticación con email y password 
    public function login(Request $request){
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=>'credenciales invalidas'],401);
        }
        //buscamos en la DB el User con ese email, creamos token de autenticación
        $user = User::Where('email',$request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        //y devolvemos la respuesta con ese token de autenticación
        return response()->json([
            'message'=>'Bienvenido a la página principal'.$user->name,
            'accessToken'=>$token,
            'token_type'=>'Bearer',
            'user'=>$user
        ]);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return ['message'=>'ha cerrado sesión con éxito y el token se ha eliminado correctamente'];
    }
}
