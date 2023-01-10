<?php

namespace App\Http\Controllers;

use App\Models\Gafete;
use App\Models\SolicitudGafete;
use App\Models\Chofer;
use App\Models\Unidad;
use App\Models\SesionTransporte;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ChoferesController extends Controller{

    public function storage(Request $request){

        $validator = Validator::make($request->all(), [
            'qr_gafete'  => 'required',
            'correo_electronico' => 'required|email',
            'qr_unidad' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $gafete = SolicitudGafete::select('solicitud.CURP', 'foto_solicitante', 'fecha_vencimiento_gafete', 'nombre', 'apellido_paterno', 'apellido_materno', 'tarjeton', 'licencia', 'fecha_vencimiento_licencia')
            ->join('control_gafete', 'control_gafete.id_solicitud', '=' ,'solicitud.id_solicitud')
            ->where('solicitud.QR', '=',$request->qr_gafete)
            ->first();

        
        if(!$gafete){

            return response()->json('El gafete no es válido', 401);

        }

        $existeChofer = Chofer::where('correo_electronico','=', $request->correo_electronico)
            ->orWhere('qr_tarjeton', '=', $request->qr_gafete)
            ->where('is_deleted', '=', '0')
            ->first();

        if($existeChofer){

            return response()->json(["msg" => "El correo electrónico o Gafete ya están en uso"], 400);
        }

        $unidad = Unidad::where('qr_vehiculo', '=', $request->qr_unidad)->first();

        if (!$unidad) {

            return response()->json(["msg" => "Unidad no válida"], 401);
        }
           
        try {

            DB::beginTransaction();
            
            $chofer = Chofer::create([
                'nombre' => $gafete->nombre,
                'ap_paterno' => $gafete->apellido_paterno,
                'ap_materno' => $gafete->apellido_materno,
                'tarjeton'  => $gafete->tarjeton,
                'vencimiento_tarjeton'  => $gafete->fecha_vencimiento_gafete,
                'vencimiento_licencia'  => $gafete->fecha_vencimiento_licencia,
                'qr_tarjeton'  => $request->qr_gafete,
                'correo_electronico' => $request->correo_electronico
            ]);

            SesionTransporte::create([
                "id_unidad" => $unidad->id_unidad,
                "id_chofer" => $chofer->id,
                "is_servicio" => 0
            ]);

            DB::commit();     
        
        } catch (\Throwable $th) {

            //throw $th;
        
            return response()->json(["msg" => "Ocurrio un error, intente más tarde"], 500);

            DB::rollBack();
        
        }

        return response()->json(["msg" => "Chofer registrado con éxito"], 201);

    }

    public function login_chofer(Request $request){

        $validator = Validator::make($request->all(), [
            'qr_gafete'  => 'required',
            'correo_electronico' => 'required|email',
            'qr_unidad' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $chofer = Chofer::where('correo_electronico','=', $request->correo_electronico)
            ->Where('qr_tarjeton', '=', $request->qr_gafete)
            ->where('is_deleted', '=', '0')
            ->first();

        if (!$chofer) {

            return response()->json(["msg" => "Correo electrónico o Gafete no encontrados"], 401);
            
        }

        if(now() > $chofer->vencimiento_tarjeton){

            return response()->json(["msg" => "Tu gafete esta vencido, no puedes iniciar sesión"], 401);

        }

        if(now() > $chofer->vencimiento_licencia){

            return response()->json(["msg" => "Tu licencia esta vencida, no puedes iniciar sesión"], 401);

        }

        $unidad = Unidad::where('qr_vehiculo', '=', $request->qr_unidad)->first();

        if (!$unidad) {

            return response()->json(["msg" => "Unidad no válida, verifique sus datos"], 401);
                
        }

        try {

            $sesionTransporte = SesionTransporte::where('id_chofer', '=', $chofer->id_chofer)
                ->where('id_unidad', '=', $unidad->id_unidad)
                ->update(['login_at' => now(), 'is_servicio' => 1]);

            $token = JWT::encode([
                'sub' => $chofer->id_chofer,
                'exp' => time() + 86400
        
            ], env('JWT_SECRET'), 'HS256');
        
            return response()->json( [
                'msg' => 'Inicio de sesión éxitoso',
                'chofer' => $chofer,
                'unidad' => $unidad,
                'token' => $token
            
            ], 200);
            
        } catch (\Throwable $th) {

            return response()->json(["msg" => "Ocurrio un error, intente más tarde"], 500);
        
        }
       
    }

    public function logout(Request $request){

        $validator = Validator::make($request->all(), [
            'correo_electronico' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $chofer = Chofer::where('correo_electronico','=', $request->correo_electronico)->first();

        try {
           
            $sesionTransporte = SesionTransporte::where('id_chofer', '=', $chofer->id_chofer)->update(['is_servicio' => 0]);

            return response()->json(["msg" => "Sesión cerrada con éxito"], 200);

        } catch (\Throwable $th) {

            //throw $th;

            return response()->json(["msg" => "Ocurrio un error, intente más tarde"], 500);
        
        }

    }
    
}
