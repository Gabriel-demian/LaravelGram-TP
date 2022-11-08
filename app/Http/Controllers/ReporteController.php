<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Http\Request;

class ReporteController extends Controller
{

    public function store(Request $request, User $user, Post $post){
        //dd($post->user->username);
        //dd('denunciante: ' . auth()->user()->id . '/ ' . 'denunciado: ' . $post->user_id . '/ ' . 'post_id: ' . $post->id);

        //Validar
        //$this->validate($request, [
        //    'motivo' => 'required|max:255'
        //]);

        //almacenar el resultado
        
        Reporte::create([
            'denunciante' => auth()->user()->id,
            'denunciado' => $post->user_id,
            'username' => $post->user->username,
            'post_id' => $post->id,
            'motivo' => 'foto a revisar',
            'estado' => 'abierto'
        ]); 

        return back()->with('mensaje', 'Denuncia realizada con éxito');
    }
}
