@extends('layouts.app')

@section('titulo')
    Página principal de Reportes
@endsection


@section('contenido')
    

    @if($reportes->count())
        <div class="grid  grid-cols-1">
            <table class="md:table-fixed table-fixed border-separate border border-slate-400">
                <thead>
                    <tr class="text-center font-bold">
                        <td class="border px-6 py-4 text-center">Denunciante</td>
                        <td class="border px-6 py-4 text-center">Denunciado</td>
                        <td class="border px-6 py-4 text-center">Username</td>
                        <td class="border px-6 py-4 text-center">Post_id</td>
                        <td class="border px-6 py-4 text-center">Motivo</td>
                        <td class="border px-6 py-4 text-center">Estado</td>
                        <td class="border px-6 py-4 text-center">Link al Post</td>
                    </tr>
                </thead>
                @foreach ($reportes as $reporte)
                    <tr class="bg-white">
                        <td class="border px-6 py-4 text-center ">{{$reporte->denunciante}}</td>
                        <td class="border px-6 py-4 text-center">{{$reporte->denunciado}}</td>
                        <td class="border px-6 py-4 text-center">{{$reporte->username}}</td>
                        <td class="border px-6 py-4 text-center">{{$reporte->post_id}}</td>
                        <td class="border px-6 py-4 text-center">{{$reporte->motivo}}</td>
                        <td class="border px-6 py-4 text-center">{{$reporte->estado}}</td>
                        <td class="border px-6 py-4 text-center">
                            <form action="{{ route('posts.show', ['post' => $reporte->post_id, 'user' => $reporte->username]) }}" >
                                <input type="submit" value="Ir Post" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="my-10">
                {{ $reportes->links('pagination::tailwind') }}   <!-- Para el páginado, genera la lista -->
            </div>
        </div>
        
    @else
        <p class="text-center">No hay denuncias</p>
    @endif

@endsection