<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;


class MessageController extends Controller
{
    public function sendMessage(Request $request){
        // Recoger el contenido del mensaje y el usuario que lo envia
        $message = $request->input('message');

        // Crear una instancia del evento de nuevo mensaje
        $event = new NewMessage($message);

        // Publicar el evento en el canal 'chat'
        event($event->on('chat'));

    }
}
