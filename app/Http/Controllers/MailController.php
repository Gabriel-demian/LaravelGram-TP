<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(Request $request){
        $nombre = $request->input('nombre');
        $asunto = $request->input('asunto');
        $email = $request->input('email');
        $mensaje = $request->input('mensaje');
        $para = 'Nosotros@gmail.com';

        Mail::send('email.correo', $request->all(), function($msg) use($asunto,$nombre,$email,$para){
            $msg->from($email,$nombre);
            $msg->subject($asunto);
            $msg->to($para);
        });
        return view('home');
    }
}
