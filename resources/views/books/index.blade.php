<x-app-layout>
    <div class="py-12" x-data="bookCollections()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-[#3A271B] mb-8">Catálogo de Libros</h1>
                    
                    <!-- Search Form -->
                    <div class="mb-8 bg-gradient-to-r from-[#FAD1A7]/20 to-[#e6c196]/20 rounded-lg p-6 border border-[#FAD1A7]/30">
                        <form method="GET" action="{{ route('books') }}" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Search by Title -->
                                <div>
                                    <label for="search_title" class="block text-sm font-semibold text-[#3A271B] mb-2">
                                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Buscar por Título
                                    </label>
                                    <input 
                                        type="text" 
                                        id="search_title" 
                                        name="search_title" 
                                        value="{{ request('search_title') }}"
                                        placeholder="Ej: Clean Code, The Pragmatic Programmer..."
                                        class="w-full px-4 py-2.5 border border-[#3A271B]/20 rounded-lg focus:ring-2 focus:ring-[#FAD1A7] focus:border-[#FAD1A7] transition-all"
                                    />
                                </div>
                                
                                <!-- Search by Author -->
                                <div>
                                    <label for="search_author" class="block text-sm font-semibold text-[#3A271B] mb-2">
                                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Buscar por Autor
                                    </label>
                                    <input 
                                        type="text" 
                                        id="search_author" 
                                        name="search_author" 
                                        value="{{ request('search_author') }}"
                                        placeholder="Ej: Robert Martin, Martin Fowler..."
                                        class="w-full px-4 py-2.5 border border-[#3A271B]/20 rounded-lg focus:ring-2 focus:ring-[#FAD1A7] focus:border-[#FAD1A7] transition-all"
                                    />
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 justify-end">
                                <a 
                                    href="{{ route('books') }}" 
                                    class="px-6 py-2.5 bg-white border-2 border-[#3A271B]/20 text-[#3A271B] rounded-lg hover:bg-gray-50 transition-all font-semibold flex items-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Limpiar Filtros
                                </a>
                                <button 
                                    type="submit" 
                                    class="px-6 py-2.5 bg-[#3A271B] text-white rounded-lg hover:bg-[#2a1f15] transition-all font-semibold flex items-center gap-2 shadow-md hover:shadow-lg"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Buscar Libros
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    @if($books->count() > 0)
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
                            @foreach($books as $book)
                                <div class="group relative cursor-pointer items-center justify-center overflow-hidden transition-shadow hover:shadow-xl hover:shadow-black/30 rounded-lg" x-data="{ isFavorited: false }">
                                    <!-- Favorite Button (Heart Icon) -->
                                    <button 
                                        @click.stop="isFavorited = !isFavorited; toggleFavorite('{{ $book['external_id'] }}')"
                                        class="absolute top-3 right-3 z-10 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all transform hover:scale-110"
                                    >
                                        <svg 
                                            class="w-5 h-5 transition-colors" 
                                            :class="isFavorited ? 'text-red-500' : 'text-gray-400'"
                                            :fill="isFavorited ? 'currentColor' : 'none'" 
                                            stroke="currentColor" 
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>

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
                                            <button 
                                                type="button" 
                                                @click.stop="openCollectionModal('{{ $book['external_id'] }}')"
                                                class="rounded-full bg-[#FAD1A7] py-1.5 px-3 font-com text-xs capitalize text-[#3A271B] shadow shadow-black/60 hover:bg-[#e6c196] transition" 
                                            >
                                                Agregar
                                            </button>
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
                            <p class="text-gray-500 text-xl">No hay libros disponibles</p>
                        </div>
                    @endif
                    
                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Add to Collection Modal -->
        <div 
            x-show="showCollectionModal" 
            x-cloak
            @click.self="showCollectionModal = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        >
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-[#3A271B] to-[#2a1f15] px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Agregar a Colección
                        </h3>
                        <button @click="showCollectionModal = false" class="text-white hover:text-[#FAD1A7] transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[60vh] overflow-y-auto">
                    <!-- Create New Collection Section -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h4 class="text-sm font-semibold text-[#3A271B] mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nueva Colección
                        </h4>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                x-model="newCollectionName"
                                placeholder="Nombre de la colección..."
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FAD1A7] focus:border-[#FAD1A7] transition-all"
                                @keydown.enter="createAndAddToCollection()"
                            />
                            <button 
                                @click="createAndAddToCollection()"
                                class="px-4 py-2 bg-[#FAD1A7] text-[#3A271B] font-semibold rounded-lg hover:bg-[#e6c196] transition-all flex items-center gap-1"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Crear
                            </button>
                        </div>
                    </div>

                    <!-- Existing Collections List -->
                    <div>
                        <h4 class="text-sm font-semibold text-[#3A271B] mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            Mis Colecciones
                        </h4>
                        <div class="space-y-2">
                            <!-- Favorites Collection (Always present, cannot be deleted) -->
                            <button 
                                @click="addToCollection('favorites')"
                                class="w-full flex items-center justify-between p-3 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-lg hover:border-red-300 transition-all group"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Favoritos</span>
                                </div>
                                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded">Predeterminada</span>
                            </button>

                            {{-- Dynamic User Collections - TODO: Replace with actual data from backend --}}
                            {{-- Example structure for when implementing CRUD:
                            @foreach($userCollections as $collection)
                                <button 
                                    @click="addToCollection('{{ $collection->id }}')"
                                    class="w-full flex items-center justify-between p-3 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-[#FAD1A7] hover:bg-[#FAD1A7]/10 transition-all group"
                                >
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-[#3A271B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                        <span class="font-semibold text-gray-700">{{ $collection->name }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $collection->books_count }} libros</span>
                                </button>
                            @endforeach
                            --}}

                            <!-- Example User Collections (Will be dynamic from backend) -->
                            <button 
                                @click="addToCollection('1')"
                                class="w-full flex items-center justify-between p-3 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-[#FAD1A7] hover:bg-[#FAD1A7]/10 transition-all group"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-[#3A271B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Programación</span>
                                </div>
                                <span class="text-xs text-gray-500">5 libros</span>
                            </button>

                            <button 
                                @click="addToCollection('2')"
                                class="w-full flex items-center justify-between p-3 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-[#FAD1A7] hover:bg-[#FAD1A7]/10 transition-all group"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-[#3A271B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Ciencia Ficción</span>
                                </div>
                                <span class="text-xs text-gray-500">3 libros</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-end">
                    <button 
                        @click="showCollectionModal = false"
                        class="px-6 py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all font-semibold"
                    >
                        Cancelar
                    </button>
                </div>
            </div>
        </div>

        <!-- Create Collection Modal -->
        <div 
            x-show="showCreateModal" 
            x-cloak
            @click.self="showCreateModal = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        >
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-[#3A271B] to-[#2a1f15] px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            Crear Nueva Colección
                        </h3>
                        <button @click="showCreateModal = false" class="text-white hover:text-[#FAD1A7] transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <label for="standalone-collection-name" class="block text-sm font-semibold text-[#3A271B] mb-2">
                        Nombre de la Colección
                    </label>
                    <input 
                        type="text" 
                        x-model="standaloneCollectionName"
                        placeholder="Ej: Mis libros favoritos, Para leer..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FAD1A7] focus:border-[#FAD1A7] transition-all"
                        @keydown.enter="createStandaloneCollection()"
                    />
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-end gap-3">
                    <button 
                        @click="showCreateModal = false"
                        class="px-6 py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all font-semibold"
                    >
                        Cancelar
                    </button>
                    <button 
                        @click="createStandaloneCollection()"
                        class="px-6 py-2 bg-[#3A271B] text-white rounded-lg hover:bg-[#2a1f15] transition-all font-semibold"
                    >
                        Crear Colección
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Component Script -->
    <script>
        function bookCollections() {
            return {
                // State
                activeCollection: 'all',
                showCollectionModal: false,
                showCreateModal: false,
                currentBookId: null,
                newCollectionName: '',
                standaloneCollectionName: '',

                // Methods
                switchCollection(collectionId) {
                    this.activeCollection = collectionId;
                    console.log('Switching to collection:', collectionId);
                    // TODO: Load books from this collection
                },

                openCollectionModal(bookId) {
                    this.currentBookId = bookId;
                    this.showCollectionModal = true;
                    this.newCollectionName = '';
                    console.log('Opening modal for book:', bookId);
                },

                addToCollection(collectionId) {
                    console.log('Adding book', this.currentBookId, 'to collection', collectionId);
                    // TODO: Send AJAX request to add book to collection
                    
                    this.showCollectionModal = false;
                    alert('Libro agregado a la colección exitosamente');
                },

                createAndAddToCollection() {
                    if (this.newCollectionName.trim()) {
                        console.log('Creating new collection:', this.newCollectionName, 'and adding book:', this.currentBookId);
                        // TODO: Send AJAX request to create collection and add book
                        
                        this.newCollectionName = '';
                        this.showCollectionModal = false;
                        alert('Colección creada y libro agregado exitosamente');
                    } else {
                        alert('Por favor ingresa un nombre para la colección');
                    }
                },

                createStandaloneCollection() {
                    if (this.standaloneCollectionName.trim()) {
                        console.log('Creating standalone collection:', this.standaloneCollectionName);
                        // TODO: Send AJAX request to create collection
                        
                        this.standaloneCollectionName = '';
                        this.showCreateModal = false;
                        alert('Colección creada exitosamente');
                    } else {
                        alert('Por favor ingresa un nombre para la colección');
                    }
                },

                toggleFavorite(bookId) {
                    // Note: isFavorited is managed in each book card's x-data
                    console.log('Toggling favorite for book:', bookId);
                    // TODO: Send AJAX request to toggle favorite status
                }
            }
        }
    </script>
</x-app-layout>