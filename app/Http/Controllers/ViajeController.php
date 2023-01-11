<?php

namespace App\Http\Controllers;

use App\Models\SesionTransporte;
use App\Models\Solicitud;
use App\Events\NuevaSolicitud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ViajeController extends Controller{

    public function solicitarUnidad(Request $request){

        $validator = Validator::make($request->all(), [
            'latitud'  => 'required',
            'longitud' => 'required',
            'id_usuario' => 'required'
        
        ]);

        if($validator->fails()){
            
            return response()->json($validator->errors(), 400);
        
        }

        $existeSolicitud = Solicitud::where('id_usuario', '=', $request->id_usuario)
            ->where('is_activo', '!=', 0)
            ->first();

        if($existeSolicitud){

            return response()->json(["msg" => "Ya tienes una solicitud de viaje activa, espera 10 minutos para volver a usarla"], 400);
        }


        $solicitud = Solicitud::create([
            "id_usuario" => $request->id_usuario,
            "latitud" => $request->latitud,
            "longitud" => $request->longitud,
            "is_activo" => 1,
            "hora_solicitud" => now()
        ]);

        //event(new NuevaSolicitud($solicitud));

        return response()->json(['message' => 'Solicitando unidad'], 201);

    }

    public function aceptarViaje(Request $request){

        $validator = Validator::make($request->all(), [
            
            'id_unidad' => 'required',
            'id_solicitud' => 'required'
        
        ]);

        if($validator->fails()){
            
            return response()->json($validator->errors(), 400);
        
        }

        $sesion_transporte = SesionTransporte::where('id_unidad','=', $request->id_unidad)->first();

        if($sesion_transporte->is_servicio == 0){
        
            return response()->json(['msg' => 'No es posible aceptar el viaje'],400);
        
        }

        if($sesion_transporte->is_viaje  == 1 ||  $sesion_transporte->is_solicitud  == 1){
            
            return response()->json(['msg' => 'No es posible aceptar el viaje, ya te encuentras atendiendo una solicitud o un viaje'], 400);
        
        }

        try {

            DB::beginTransaction();
            
            $solicitud = Solicitud::where('id', '=', $request->id_solicitud)->update(['is_activo' => 2, 'id_unidad' => $request->id_unidad]);

            SesionTransporte::where('id_sesion_transporte', '=', $sesion_transporte->id_sesion_transporte)->update(['is_solicitud' => 1]);

            DB::commit();     
        
        } catch (\Throwable $th) {

            //throw $th;
        
            return response()->json(["msg" => "Ocurrio un error, intente más tarde"], 500);

            DB::rollBack();
        
        }

    }
    
}
