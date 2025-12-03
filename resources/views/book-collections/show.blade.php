<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Collection Header -->
                    <div class="mb-8" x-data="{ editing: false, collectionName: '{{ $bookCollection->name }}' }">
                        <!-- Display Mode -->
                        <div x-show="!editing" class="flex items-center gap-3">
                            <h1 class="text-3xl font-bold text-[#3A271B]">{{ $bookCollection->name }}</h1>
                            <button 
                                @click="editing = true" 
                                class="text-gray-500 hover:text-[#3A271B] transition"
                                title="Editar nombre"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Edit Mode -->
                        <form 
                            x-show="editing" 
                            x-cloak
                            method="POST" 
                            action="{{ route('book-collections.update', $bookCollection) }}"
                            class="flex items-center gap-2"
                        >
                            @csrf
                            @method('PUT')
                            <input 
                                type="text" 
                                name="name" 
                                x-model="collectionName"
                                class="text-3xl font-bold text-[#3A271B] border-2 border-[#3A271B] rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-[#3A271B]"
                                required
                            >
                            <input type="hidden" name="description" value="{{ $bookCollection->description }}">
                            <button 
                                type="submit" 
                                class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 transition"
                                title="Guardar"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            <button 
                                type="button" 
                                @click="editing = false; collectionName = '{{ $bookCollection->name }}'"
                                class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 transition"
                                title="Cancelar"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                        
                        @if($bookCollection->description)
                            <p class="text-gray-600 mt-2">{{ $bookCollection->description }}</p>
                        @endif
                    </div>

                    <!-- Books Grid -->
                    @if($booksData->count() > 0)
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
                            @foreach($booksData as $book)
                                <div class="group relative cursor-pointer items-center justify-center overflow-hidden transition-shadow hover:shadow-xl hover:shadow-black/30 rounded-lg" x-data="{ showDelete: false }">
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
                                    
                                    <!-- Delete Button -->
                                    <div class="absolute top-2 right-2 z-10">
                                        <form 
                                            method="POST" 
                                            action="{{ route('book-collections.books.remove', [$bookCollection, $book['id']]) }}"
                                            @submit.prevent="if(confirm('¿Estás seguro de que quieres eliminar este libro de la colección?')) $el.submit()"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit"
                                                class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition shadow-lg opacity-0 group-hover:opacity-100"
                                                title="Eliminar de la colección"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
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
                            <p class="text-gray-500 text-xl">No hay libros en esta colección aún</p>
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
