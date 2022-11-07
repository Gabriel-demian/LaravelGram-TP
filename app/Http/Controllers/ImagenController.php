<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request){
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $ImagenServidor = Image::make($imagen);

        $ImagenServidor->fit(1000, 1000);   //Para hacer que las imagenes sean cuadradas. 

        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        $ImagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
