<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('perfil.index');
    }
 
    public function store(Request $request){

        //para poder validar de forma correcta el username y evitar un error al querer escribir un username ya existente.
        $request->request->add( ['username' => Str::slug($request->get('username'))] );

        $this->validate($request,[
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:editar_perfil,posts'],
        ]);

        if($request->imagen){
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $ImagenServidor = Image::make($imagen);
            $ImagenServidor->fit(1000, 1000);   //Para hacer que las imagenes sean cuadradas. 

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $ImagenServidor->save($imagenPath);
        }

        //guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        return redirect()->route('post.index', $usuario->username);
    }
}
