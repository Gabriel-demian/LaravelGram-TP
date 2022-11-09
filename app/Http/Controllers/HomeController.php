<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {

        if (auth()->user()->categoria === 'administrador') {

            //$reports = Reporte::orderBy('estado', 'ASC')->get();
            $reports = DB::table('reportes')->orderBy('estado', 'ASC')->paginate(4);


            return view('reportes', [
                'reportes' => $reports
            ]);
        }

        //Obtener a quienes seguimos
        // pluck solo nos retorna el campo especificado, en este caso el id
        $ids = auth()->user()->followings->pluck('id')->toArray();
        //verifica que un valor contenga en una columna los valores pasados en el arreglo
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        //le pasamos la informacion a la vista
        return view('home', [
            'posts' => $posts
        ]);
    }
}
