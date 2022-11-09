<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReporteController extends Controller
{

    public function store(Request $request, User $user, Post $post){

        if($request->motivo === null){
            $motivo = 'sin motivo';
        }else{
            $motivo = $request->motivo;
        }

        Reporte::create([
            'denunciante' => auth()->user()->id,
            'denunciado' => $post->user_id,
            'username' => $post->user->username,
            'post_id' => $post->id,
            'motivo' => $motivo,
            'estado' => 'abierto'
        ]); 

        $email = 'reportes@laravelgram.com';
        $asunto = 'Nuevo reporte creado';
        $para = 'administradores@gmail.com';


        Mail::send('email.correo', 
            ['mensajeEmail' => 'Se reportó la publicación : ' . $post->id. ' del usuario:  ' . $post->user_id . '('. $post->user->username .') por el motivo: ' . $motivo],
            function($msg) use($asunto,$para, $email){
                $msg->from($email);
                $msg->subject($asunto);
                $msg->to($para);
        });
        
        return back()->with('mensaje', 'Denuncia realizada con éxito');
    }
}
