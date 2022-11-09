@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')

    <div class="container mx-auto md:flex">
        <div class="md:w-1/2 md:h-1/2">
            
            <img src="{{ asset('uploads' . '/' . $post->imagen) }}" alt="Imagen del post {{ $post->titulo }}" />

            <div class="p-3 flex items-center gap-4">
                @auth

                    @if ($post->checkLike(auth()->user()))
                        <form method="POST" action="{{ route('posts.likes.destroy', $post) }}">
                            @method('DELETE')
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>  
                            </div>                 
                        </form>
                    @else
                    <form method="POST" action="{{ route('posts.likes.store', $post) }}">
                        @csrf
                        <div class="my-4">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </button>  
                        </div>                 
                    </form>
                    @endif
                @endauth
                <p class="font-bold">{{ $post->likes->count() }}
                    <span class="font-normal"> Likes</span>
                </p>
                
                <!-- MODAL -->
                @if ($post->user_id !== auth()->user()->id)
                    @auth
                        @if ($post->user_id !== auth()->user()->id || auth()->user()->categoria === 'administrador')
                            <button class="flex space-x-2 items-center px-3 py-2 bg-rose-500 hover:bg-rose-800 rounded-md drop-shadow-md" onclick="openModal('modal')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                </svg>
                                <span class="text-white">Denunciar Post</span>
                                
                            </button>

                            <div id="modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 modal">
                                <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">
                                    
                                        <!-- Modal header -->
                                        
                                    <div class="flex justify-between items-center bg-red-500 text-white text-xl rounded-t-md px-4 py-2">
                                        <h3>DENUNCIA EL POST</h3>
                                        <button onclick="closeModal('modal')">x</button>
                                    </div>

                                    <!-- Modal body -->
                                    <form action="{{ route('posts.reporte.store', $post) }}" method="POST">
                                        @csrf
                                        <div class="max-h-48 p-4">
                                            <label for="motivo" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Motivo:</label>
                                            <input name="motivo" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Ingrese el motivo" />
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="px-4 py-2 border-t border-t-gray-500 flex justify-end items-center space-x-4">
                                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition" type="submit">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script type="text/javascript">
                            window.openModal = function(modalId) {
                            document.getElementById(modalId).style.display = 'block'
                            document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
                            }

                            window.closeModal = function(modalId) {
                            document.getElementById(modalId).style.display = 'none'
                            document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
                            }

                            // Close all modals when press ESC
                            document.onkeydown = function(event) {
                            event = event || window.event;
                            if (event.keyCode === 27) {
                                document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
                                let modals = document.getElementsByClassName('modal');
                                Array.prototype.slice.call(modals).forEach(i => {
                                i.style.display = 'none'
                                })
                            }
                            };
                            </script>
                        @endif
                    @endauth
                @endif
                <!-- FIN DEL MODAL -->


            </div>

            <div>
                <p class="font-bold">{{ $post->user->username }}</p>
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>

            <div class="mt-5">
                <p> {{ $post->descripcion }} </p>
            </div>

            @auth
                <!-- TODO agregar un campo de privilegios y consultarlo, si soy un Administrador puedo borrar publicaciones que no sean mías
                agregandole un ||  auth()->user()->categoria === 'administrador'-->
                @if ($post->user_id === auth()->user()->id || auth()->user()->categoria === 'administrador')
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input
                            type="submit",
                            value="Eliminar Publicacion"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer"
                        />
                    </form>
                @endif
                
            @endauth
            

        </div>

        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">

                @auth
                    
                <p class="text-2xl font-bold text-center mb-4">Agrega un nuevo comentario</p> 

                @if (session('mensaje'))
                    <div class="bg-green-500 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{ session('mensaje') }}
                    </div>
                @endif

                <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                            Añade un Comentario
                        </label>
                        <textarea
                            id="comentario" 
                            name="comentario" 
                            placeholder="Agrega un comentario" 
                            class="border p-3 w-full rounded-lg @error('comentario')
                                border-red-500
                            @enderror"
                        ></textarea>
                        @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <input
                        type="submit"
                        value="Comentar"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                        uppercase font-bold w-full p-3 text-white rounded-lg"
                    />

                </form>

                @endauth

                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <a href="{{ route('post.index', $comentario->user) }}" class="font-bold">
                                    {{$comentario->user->username}}
                                </a>
                                <p>{{ $comentario->comentario }}</p>
                                <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay comentarios aún</p>

                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection