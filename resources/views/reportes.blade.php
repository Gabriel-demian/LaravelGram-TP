@extends('layouts.app')

@section('titulo')
    Página principal de Reportes
@endsection


@section('contenido')
    

    @if($reportes->count())
        <div class="grid  grid-cols-1">
            <table class="md:table-fixed table-fixed">
                <thead>
                    <tr class="text-center font-bold">
                        <td class="border px-6 py-4">Denunciante</td>
                        <td class="border px-6 py-4">Denunciado</td>
                        <td class="border px-6 py-4">Username</td>
                        <td class="border px-6 py-4">Post_id</td>
                        <td class="border px-6 py-4">Motivo</td>
                        <td class="border px-6 py-4">Estado</td>
                        <td class="border px-6 py-4">Link al Post</td>
                    </tr>
                </thead>
                @foreach ($reportes as $reporte)
                    <tr>
                        <td class="border px-6 py-4">{{$reporte->denunciante}}</td>
                        <td class="border px-6 py-4">{{$reporte->denunciado}}</td>
                        <td class="border px-6 py-4">{{$reporte->username}}</td>
                        <td class="border px-6 py-4">{{$reporte->post_id}}</td>
                        <td class="border px-6 py-4">{{$reporte->motivo}}</td>
                        <td class="border px-6 py-4">{{$reporte->estado}}</td>
                        <td class="border px-6 py-4">
                            <a href="{{ route('posts.show', ['post' => $reporte->post_id, 'user' => $reporte->username]) }}">
                                link
                            </a>
                        </td>

                        @endforeach
                    </tr>
            </table>
        </div>
        
    @else
        <p class="text-center">No hay denuncias</p>
    @endif

@endsection