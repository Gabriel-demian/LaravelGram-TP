<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Http\Request;

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

        return back()->with('mensaje', 'Denuncia realizada con éxito');
    }
}
