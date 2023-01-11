<?php

namespace App\Listeners;
use App\Events\SolicitudAsignada;
use App\Models\SesionTransporte;
use App\Models\Solicitud;
use App\Events\NuevaSolicitud;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AsignarConductor
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NuevaSolicitud  $event
     * @return void
     */
    public function handle(NuevaSolicitud $event){

        $transporte = SesionTransporte::where('is_servicio', '=', '1')
            ->where('is_viaje','=','0')
            ->where('is_solicitud','=','0')
            ->first();

        SesionTransporte::where('id_unidad', '=', $transporte->id_unidad)->update(['is_solicitud' => 1]);

        
        $solicitud = Solicitud::where('id', '=', $event->solicitud->id)->update(['id_unidad' => $transporte->id_unidad]);

        broadcast(new SolicitudAsignada($event->solicitud))->toOthers();
    
    }
}
