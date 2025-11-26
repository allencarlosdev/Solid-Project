<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Book Allen APP') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /*Animation Floting */
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }

            /*background pattern */
            .dotted-background {
                background-image: radial-gradient(#3A271B40 1px, transparent 1px);
                background-size: 15px 15px;
            }
        </style>

    </head>
    <body class="bg-[#FAD1A7] text-[#1b1b18] flex items-center lg:justify-center min-h-screen flex-col font-[instrument-sans] dotted-background">

        <header class="w-full bg-[#3A271B] shadow-lg sticky z-10">
            <div class="lg:max-w-4xl max-w-[335px] mx-auto py-3 px-4 flex justify-between items-center">
                <span class="text-white text-lg font-bold">Book Allen</span>

                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4 text-sm">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white hover: transition duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-gray-300 transition duration-300">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-block px-4 py-2 bg-[#FAD1A7] text-[#1b1b18] font-bold rounded-md shadow-md hover:bg-[#e6c196] transition duration-300">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <div class="flex items-center justify-center w-full lg:grow py-12 px-4">
            <main class="bg-white p-10 rounded-xl shadow-2xl max-w-lg w-full text-center transform">
                <div class="flex flex-col items-center justify-center">
                    
                    <img 
                        src="{{ asset('img/background_book.png') }}" 
                        alt="Books Illustration" 
                        class="w-48 h-36 lg:w-64 lg:h-52 mb-8 animate-float drop-shadow-lg"
                    >
                    
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-[#1b1b18] mb-4 tracking-tighter">
                        Tu Biblioteca Personal
                    </h1>
                    
                    <p class="text-lg lg:text-xl text-gray-700 max-w-md mx-auto mb-8">
                        Explora millones de libros con la **API de Google Books**. Crea tus colecciones y marca tus favoritos.
                    </p>

                    <a 
                        href="#" 
                        class="inline-block px-10 py-3.5 bg-[#3A271B] text-white font-extrabold text-lg rounded-full shadow-lg hover:text-[#1b1b18] hover:bg-[#FAD1A7] transition duration-300 transform hover:scale-[1.05]"
                    >
                        Empezar a Explorar
                    </a>
                    
                </div>
            </main>
        </div>

        <footer class="w-full flex justify-center items-center text-center mt-auto bg-[#3A271B] py-4">
            <p class="flex justify-center items-center text-sm w-72 text-gray-400">
            Programmed by:
            <a
                class="text-[#FAD1A7] ml-1 hover:text-white font-medium transition duration-300"
                href="https://github.com/allencarlosdev"
                target="_blank"
                rel="noopener noreferrer"
                >Carlos Allen 😎👍</a
            >
            </p>
        </footer>
    </body>
</html>