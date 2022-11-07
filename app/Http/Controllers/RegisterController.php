<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request) {

        //para poder validar de forma correcta el username y evitar un error al querer escribir un username ya existente.
        $request->request->add( ['username' => Str::slug($request->get('username'))] );

        //Validacion
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6',
        ]);

        // -> create es el equivalente a INSERT INTO users
        // Str::slug -> estoy usando slug en vez de lower ya que si el username tiene un espacio será reemplazado por un '-' 
       User::create([
            'name' => $request->name,
            'username' => $request->get('username'),    
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'categoria' => 'usuario' 
       ]);


       //autenticar un usuario
       /**auth()->attempt([
        'email' => $request->email,
        'password' => $request->password
       ]);**/

       //Otra forma de autenticar el usuario
       auth()->attempt($request->only('email','password'));


       //redireccionamos al usuario
       return redirect()->route('post.index', auth()->user()->username);


    }
}
