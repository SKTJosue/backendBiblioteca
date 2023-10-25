<?php

namespace App\Http\Controllers\UsuarioApi;
use Cookie;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
USE Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|confirmed',
        ]);
        $user = new User();
        $user->name=$request->name;
        $user->apellidoP=$request->apellidoP;
        $user->apellidoM=$request->apellidoM;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->save();
        $user->assignRole($request->rol);
        return $request;
        // return $user;
        // return 'se introdujo bien los datos';
        // return $request;
    }
    public function eliminar($id){
        $busqueda=User::find($id);
        if($busqueda){
            $busqueda->delete();
            return true;
        }
        else{
            return response(FALSE);
        }
    }
    public function BuscarId($id){

    }
    public function login( Request $request){
        if(!Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password]))
            { 
            return response(["MENSAJE"=> "Credenciales invalidas"],Response::HTTP_UNAUTHORIZED);
        }
        else{
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token',$token,60*24);
            return response(["token"=>$token],Response::HTTP_OK)->withoutCookie($cookie);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
    }
    public function userProfile(Request $request){
        return response()->json([
            "mensaje" => "userProfile ok",
            "userData"=> auth()->user()
        ],Response::HTTP_OK);
    }
    public function logout( Request $request){
        $cookie = Cookie::forget('cookie_token');
        return response(["mensaje"=>"cerrado de session"])->withCookie($cookie);
    }
    public function allUser( Request $request){
        $sql='SELECT users.id, users.name, users.email, roles.name as "rol" from users ,roles ,model_has_roles WHERE users.id = model_has_roles.model_id AND roles.id = model_has_roles.role_id';
        $usuario=DB::select($sql); 
        return $usuario;        
    }
}
