<nav x-data="navigationData()" class="bg-[#3A271B] border-b border-[#3A271B]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('books') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links with Collections -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    <!-- Books / All Books -->
                    <a href="{{ route('books') }}" 
                       class="{{ request()->routeIs('books') 
                                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FAD1A7] text-sm font-medium leading-5 text-white focus:outline-none focus:border-[#FAD1A7] transition duration-150 ease-in-out'
                                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-[#FAD1A7] hover:border-gray-300 focus:outline-none focus:text-[#FAD1A7] focus:border-gray-300 transition duration-150 ease-in-out' }}">
                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ __('Books') }}
                    </a>

                    <!-- Favorites -->
                    <a 
                        href="{{ route('favorites') }}"
                        class="{{ request()->routeIs('favorites') 
                                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FAD1A7] text-sm font-medium leading-5 text-white focus:outline-none focus:border-[#FAD1A7] transition duration-150 ease-in-out'
                                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-[#FAD1A7] hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out' }}"
                    >
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Favoritos
                    </a>

                    <!-- Dynamic User Collections -->
                    @if(isset($userCollections))
                        @foreach($userCollections as $collection)
                            <a 
                                href="{{ route('book-collections.show', $collection->id) }}"
                                class="{{ request()->routeIs('book-collections.show') && request()->route('bookCollection')?->id == $collection->id
                                        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FAD1A7] text-sm font-medium leading-5 text-white focus:outline-none focus:border-[#FAD1A7] transition duration-150 ease-in-out'
                                        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-[#FAD1A7] hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out' }}"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                {{ $collection->name }}
                            </a>
                        @endforeach
                    @endif

                    <!-- Create New Collection Button -->
                    <button 
                        @click="showCreateModal = true"
                        class="inline-flex items-center px-3 py-1.5 bg-[#FAD1A7] text-[#3A271B] text-sm font-semibold rounded-md hover:bg-[#e6c196] transition-all"
                    >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nueva
                    </button>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[#3A271B] focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#FAD1A7] hover:bg-[#4e3424] focus:outline-none focus:bg-[#4e3424] focus:text-[#FAD1A7] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Books / All Books -->
            <a href="{{ route('books') }}" 
               class="{{ request()->routeIs('books')
                        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#FAD1A7] text-start text-base font-medium text-[#FAD1A7] bg-[#4e3424] focus:outline-none focus:text-[#FAD1A7] focus:bg-[#4e3424] focus:border-[#FAD1A7] transition duration-150 ease-in-out'
                        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-[#FAD1A7] hover:bg-[#4e3424] hover:border-gray-300 focus:outline-none focus:text-[#FAD1A7] focus:bg-[#4e3424] focus:border-gray-300 transition duration-150 ease-in-out' }}">
                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                {{ __('Books') }}
            </a>

            <!-- Favorites -->
            <a 
                href="{{ route('favorites') }}"
                class="{{ request()->routeIs('favorites')
                        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#FAD1A7] text-start text-base font-medium text-[#FAD1A7] bg-[#4e3424] focus:outline-none focus:text-[#FAD1A7] focus:bg-[#4e3424] focus:border-[#FAD1A7] transition duration-150 ease-in-out'
                        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-[#FAD1A7] hover:bg-[#4e3424] focus:outline-none transition duration-150 ease-in-out' }}"
            >
                <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                Favoritos
            </a>

            <!-- Dynamic User Collections -->
            @if(isset($userCollections))
                @foreach($userCollections as $collection)
                    <a 
                        href="{{ route('book-collections.show', $collection->id) }}"
                        class="{{ request()->routeIs('book-collections.show') && request()->route('bookCollection')?->id == $collection->id
                                ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#FAD1A7] text-start text-base font-medium text-[#FAD1A7] bg-[#4e3424] focus:outline-none focus:text-[#FAD1A7] focus:bg-[#4e3424] focus:border-[#FAD1A7] transition duration-150 ease-in-out'
                                : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-[#FAD1A7] hover:bg-[#4e3424] focus:outline-none transition duration-150 ease-in-out' }}"
                    >
                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        {{ $collection->name }}
                    </a>
                @endforeach
            @endif

            <!-- Create New Collection Button -->
            <button 
                @click="showCreateModal = true"
                class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium bg-[#FAD1A7] text-[#3A271B] hover:bg-[#e6c196] focus:outline-none transition duration-150 ease-in-out"
            >
                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Colección
            </button>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#4e3424]">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-[#FAD1A7] hover:bg-[#4e3424] hover:border-gray-300 focus:outline-none focus:text-[#FAD1A7] focus:bg-[#4e3424] focus:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Profile') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-[#FAD1A7] hover:bg-[#4e3424] hover:border-gray-300 focus:outline-none focus:text-[#FAD1A7] focus:bg-[#4e3424] focus:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </a>
                </form>
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
                <label class="block text-sm font-semibold text-[#3A271B] mb-2">
                    Nombre de la Colección
                </label>
                <input 
                    type="text" 
                    x-model="newCollectionName"
                    placeholder="Ej: Mis libros favoritos, Para leer..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FAD1A7] focus:border-[#FAD1A7] transition-all"
                    @keydown.enter="createCollection()"
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
                    @click="createCollection()"
                    class="px-6 py-2 bg-[#3A271B] text-white rounded-lg hover:bg-[#2a1f15] transition-all font-semibold"
                >
                    Crear Colección
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine.js Script for Navigation -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navigationData', () => ({
                open: false,
                showCreateModal: false,
                newCollectionName: '',

                async createCollection() {
                    if (!this.newCollectionName.trim()) {
                        alert('Por favor ingresa un nombre para la colección');
                        return;
                    }

                    try {
                        const response = await fetch('/book-collections', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: this.newCollectionName
                            })
                        });

                        const data = await response.json();
                        
                        if (data.success) {
                            this.newCollectionName = '';
                            this.showCreateModal = false;
                            location.reload(); // Refresh to update navigation
                        } else {
                            alert('Error al crear la colección');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error al crear la colección');
                    }
                }
            }));
        });
    </script>
</nav>
