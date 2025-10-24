<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;

class CorreoController extends Controller
{
    public function enviarPrueba()
    {
        $mensaje = "Hola, este es un correo de prueba enviado desde un controlador en Laravel 12";
        $destinatario = 'destinatario@ejemplo.com';

        Mail::to($destinatario)->send(new EnviarCorreo($mensaje));

        return response()->json([
            'status' => 'success',
            'message' => 'Correo enviado correctamente.'
        ]);
    }
}
