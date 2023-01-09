<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller{

    public function storage (Request $request){

        $validator = Validator::make($request->all(), [
            'nombre'  => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'correo_electronico' => 'required|email',
            'contrasenia' => 'required',
            'fecha_nacimiento' => 'required',
            'sexo' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $existeUsuario = Usuario::where('correo_electronico','=', $request->correo_electronico)
            ->where('is_deleted', '=', '0')
            ->first();

        if($existeUsuario){

            return response()->json(["msg" => "El correo electrónico ya está en uso"], 200);

        }

        try {
                
            $newUser = Usuario::create([
                'nombre'  => $request->nombre,
                'ap_paterno' => $request->ap_paterno,
                'ap_materno' => $request->ap_materno,
                'correo_electronico' => $request->correo_electronico,
                'contrasenia' => Hash::make($request->contrasenia, ['rounds' => 12]),
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'sexo' => $request->sexo

            ]);

            return response()->json(["msg" => "Usuario registrado con éxito"], 201);

        } catch (\Throwable $th) {
            
            return response()->json(["msg" => "Ocurrio un error, intente más tarde"], 500);
        
        }

    }

    public function destroy(Request $request){

        $validator = Validator::make($request->all(), [
            'correo_electronico' => 'required|email',
        ]);

        try {
            
            Usuario::where('correo_electronico', '=', $request->correo_electronico)
                ->where('is_deleted', '=', '0')
                ->update(['is_deleted' => 1, 'deleted_at' => now()]);

            return response()->json(["msg" => "Usuario eliminado con éxito"], 200);
        
        } catch (\Throwable $th) {
        
            return response()->json(["msg" => "Ocurrio un error, intente más tarde"], 500);
        
        }

    }

}
