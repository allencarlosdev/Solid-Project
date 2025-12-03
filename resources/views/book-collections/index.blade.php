<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Colecciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($collections->isEmpty())
                        <p>No tienes colecciones aún.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($collections as $collection)
                                <div class="border rounded-lg p-4">
                                    <h3 class="font-bold text-lg">{{ $collection->name }}</h3>
                                    @if($collection->description)
                                        <p class="text-gray-600 text-sm mt-2">{{ $collection->description }}</p>
                                    @endif
                                    <a href="{{ route('book-collections.show', $collection) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                                        Ver colección
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
