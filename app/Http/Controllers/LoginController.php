<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function store(Request $request){

        //$request->remember   crea una cookie para mantener la sesión abierta hasta que la cerremos.
        //y guarda el token generado en la base de datos del usuario (campo remember_token) para comparar la cookie a ver si es correcta. 

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //si no está autentidicado entonces regresar el mensaje
        if(!auth()->attempt($request->only('email','password'), $request->remember)){
            //back() -> retorna una respuesta a la vista anterior, se usa en metodos 'post'. }
            //Indica que regrese a la página del request con este mensaje. .
            //with() llena la sesión que se retorna. 
            return back()->with('mensaje','Credenciales Incorrectas.');
        }

        //TODO -> redireccionar a vistas diferentes dependiendo de los permisos de usuario normal o administrador
        return redirect()->route('post.index', auth()->user()->username);
    }
}
