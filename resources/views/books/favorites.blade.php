<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Collection Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-[#3A271B]">Favoritos</h1>
                        <p class="text-gray-600 mt-2">Tus libros favoritos</p>
                    </div>

                    <!-- Books Grid -->
                    @if($books->count() > 0)
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
                            @foreach($books as $book)
                                <div class="group relative cursor-pointer items-center justify-center overflow-hidden transition-shadow hover:shadow-xl hover:shadow-black/30 rounded-lg">
                                    <div class="h-64 w-full">
                                        @if(isset($book['cover_url']) && $book['cover_url'])
                                            <img 
                                                class="h-full w-full object-cover transition-transform duration-500 group-hover:rotate-3 group-hover:scale-125" 
                                                src="{{ $book['cover_url'] }}" 
                                                alt="{{ $book['title'] }}"
                                                loading="lazy"
                                                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            />
                                            <div class="hidden h-full w-full bg-gradient-to-br from-[#FAD1A7] to-[#e6c196] flex-col items-center justify-center p-4 text-center">
                                                <svg class="w-12 h-12 text-[#3A271B] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                <span class="text-[#3A271B] font-semibold text-sm">Sin portada</span>
                                            </div>
                                        @else
                                            <div class="h-full w-full bg-gradient-to-br from-[#FAD1A7] to-[#e6c196] flex flex-col items-center justify-center p-4 text-center">
                                                <svg class="w-12 h-12 text-[#3A271B] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                <span class="text-[#3A271B] font-semibold text-sm">Sin portada</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/80 group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70"></div>
                                    <!-- Título Principal -->
                                    <div 
                                        x-data="{ hovered: false }" 
                                        x-init="(() => { const g = $el.closest('.group'); if (g) { g.addEventListener('mouseenter', () => hovered = true); g.addEventListener('mouseleave', () => hovered = false); } })()" 
                                        x-show="!hovered" 
                                        x-cloak
                                        class="absolute bottom-0 left-0 right-0 px-4 py-3 text-center"
                                    >
                                        <h1 class="font-dmserif text-lg font-bold text-white line-clamp-2 drop-shadow-lg">{{ $book['title'] }}</h1>
                                    </div>
                                    <!-- Contenido adicional en hover -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center opacity-0 transition-all duration-500 group-hover:opacity-100">
                                        <h1 class="font-dmserif text-xl font-bold text-white mb-2 line-clamp-2">{{ $book['title'] }}</h1>
                                        <p class="mb-3 text-xs italic text-white line-clamp-2">
                                            {{ implode(', ', $book['authors']) }}
                                        </p>
                                        <div class="flex gap-2 flex-wrap justify-center">
                                            <a 
                                                href="{{ route('books.show', ['id' => $book['external_id']]) }}" 
                                                class="rounded-full bg-neutral-900 py-1.5 px-3 font-com text-xs capitalize text-white shadow shadow-black/60 hover:bg-neutral-700 transition"
                                            >
                                                Ver Detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="text-gray-500 text-xl">No tienes libros favoritos aún</p>
                            <a href="{{ route('books') }}" class="mt-4 inline-block px-6 py-2 bg-[#3A271B] text-white rounded-lg hover:bg-[#2a1f15] transition">
                                Explorar Libros
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
