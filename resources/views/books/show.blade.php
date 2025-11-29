<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a 
                    href="{{ route('books') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-[#3A271B]/20 text-[#3A271B] rounded-lg hover:bg-gray-50 transition-all font-semibold shadow-sm hover:shadow-md"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Catálogo
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Book Cover Section -->
                        <div class="lg:col-span-1">
                            <div class="sticky top-8">
                                <div class="rounded-lg overflow-hidden shadow-xl border-4 border-[#FAD1A7]/30 bg-gradient-to-br from-[#FAD1A7]/20 to-[#e6c196]/20">
                                    @if(isset($book['cover_url']) && $book['cover_url'])
                                        <img 
                                            class="w-full h-auto object-cover" 
                                            src="{{ $book['cover_url'] }}" 
                                            alt="Portada de {{ $book['title'] }}"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        />
                                        <div class="hidden h-96 w-full bg-gradient-to-br from-[#FAD1A7] to-[#e6c196] flex-col items-center justify-center p-8 text-center">
                                            <svg class="w-24 h-24 text-[#3A271B] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            <span class="text-[#3A271B] font-bold text-lg">Sin portada disponible</span>
                                        </div>
                                    @else
                                        <div class="h-96 w-full bg-gradient-to-br from-[#FAD1A7] to-[#e6c196] flex flex-col items-center justify-center p-8 text-center">
                                            <svg class="w-24 h-24 text-[#3A271B] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            <span class="text-[#3A271B] font-bold text-lg">Sin portada disponible</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-6 space-y-3">
                                    <a 
                                        href="#" 
                                        class="w-full flex items-center justify-center gap-3 px-6 py-3.5 bg-[#3A271B] text-white rounded-lg hover:bg-[#2a1f15] transition-all font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Agregar a Colección
                                    </a>
                                    
                                    <a 
                                        href="#" 
                                        class="w-full flex items-center justify-center gap-3 px-6 py-3.5 bg-gradient-to-r from-[#FAD1A7] to-[#e6c196] text-[#3A271B] rounded-lg hover:from-[#e6c196] hover:to-[#d4b185] transition-all font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        Marcar como Favorito
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Book Information Section -->
                        <div class="lg:col-span-2">
                            <!-- Title -->
                            <h1 class="text-4xl lg:text-5xl font-bold text-[#3A271B] mb-4 leading-tight">
                                {{ $book['title'] }}
                            </h1>

                            <!-- Authors -->
                            <div class="flex items-center gap-2 mb-6">
                                <svg class="w-5 h-5 text-[#3A271B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="text-xl text-gray-700 italic">
                                    {{ implode(', ', $book['authors']) }}
                                </p>
                            </div>

                            <!-- Metadata Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                <!-- Publisher Card -->
                                @if(isset($book['publisher']) && $book['publisher'])
                                <div class="bg-gradient-to-br from-[#FAD1A7]/20 to-[#e6c196]/20 rounded-lg p-4 border-2 border-[#FAD1A7]/30">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-[#3A271B] rounded-lg p-2">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-[#3A271B]/60 uppercase tracking-wide">Editorial</p>
                                            <p class="text-base font-bold text-[#3A271B] mt-1">{{ $book['publisher'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Published Date Card -->
                                @if(isset($book['publishedDate']) && $book['publishedDate'])
                                <div class="bg-gradient-to-br from-[#FAD1A7]/20 to-[#e6c196]/20 rounded-lg p-4 border-2 border-[#FAD1A7]/30">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-[#3A271B] rounded-lg p-2">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-[#3A271B]/60 uppercase tracking-wide">Fecha de Publicación</p>
                                            <p class="text-base font-bold text-[#3A271B] mt-1">{{ $book['publishedDate'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Description Section -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg p-6 border-2 border-gray-100">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-6 h-6 text-[#3A271B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h2 class="text-2xl font-bold text-[#3A271B]">Descripción</h2>
                                </div>
                                
                                @if(isset($book['description']) && $book['description'])
                                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                        <p>{{ $book['description'] }}</p>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">No hay descripción disponible para este libro.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span style="display: none;">External ID: {{ $book['external_id'] }}</span>
</x-app-layout>