<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $perPage = 15;
        $currentPage = $request->get('page', 1);

        // La API de Google Books usa 'startIndex' (índice inicial)
        // El índice es 0-basado, así que (página - 1) * por página
        $startIndex = ($currentPage - 1) * $perPage;

        // Definir la URL base de la API y los parámetros de búsqueda
        $apiUrl = 'https://www.googleapis.com/books/v1/volumes';
        $apiKey = config('services.google_books.key');
        
        // Define tu consulta de búsqueda (q).
        $query = 'coding'; 

        // Realizar la petición HTTP a la API
        $response = Http::get($apiUrl, [
            'q' => $query,
            'maxResults' => $perPage,
            'startIndex' => $startIndex,
            'key' => $apiKey,
        ]);

        //Procesar la respuesta
        if ($response->successful()) {
            $data = $response->json();
            
            // Extraer la lista de volúmenes (libros) y el total de resultados
            $items = $data['items'] ?? [];
            $totalItems = $data['totalItems'] ?? 0;

            // Mapear los datos para adaptarlos si es necesario
            $booksData = collect($items)->map(function ($item) {
                $volumeInfo = $item['volumeInfo'];
                return [
                    'title' => $volumeInfo['title'] ?? 'N/A',
                    'authors' => $volumeInfo['authors'] ?? ['N/A'],
                    'publisher' => $volumeInfo['publisher'] ?? 'N/A',
                    'publishedDate' => $volumeInfo['publishedDate'] ?? 'N/A',
                    'cover_url' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                    'external_id' => $item['id'] ?? null,
                    'description' => $volumeInfo['description'] ?? 'No descripción disponible.',
                ];
            });

            // Crear la paginación manual
            $books = new LengthAwarePaginator(
                $booksData,
                $totalItems,
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
            
        } else {
            // Manejo de error si la API falla
            $books = new LengthAwarePaginator([], 0, $perPage, $currentPage);
            // \Log::error('Error fetching books from Google API: ' . $response->body());
        }

        // Retornar la vista con el objeto Paginator
        return view('books.index', ['books' => $books]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $apiUrl = "https://www.googleapis.com/books/v1/volumes/{$id}";
        $apiKey = config('services.google_books.key');

        $response = Http::get($apiUrl, ['key' => $apiKey]);

        if ($response->successful()) {
            $item = $response->json();
            $volumeInfo = $item['volumeInfo'] ?? [];

            $book = [
                'title' => $volumeInfo['title'] ?? 'N/A',
                'authors' => $volumeInfo['authors'] ?? ['N/A'],
                'publisher' => $volumeInfo['publisher'] ?? 'N/A',
                'publishedDate' => $volumeInfo['publishedDate'] ?? 'N/A',
                'cover_url' => $volumeInfo['imageLinks']['large'] ?? $volumeInfo['imageLinks']['thumbnail'] ?? null,
                'description' => $volumeInfo['description'] ?? 'No descripción disponible.',
                'external_id' => $item['id'] ?? $id,
            ];

            return view('books.show', ['book' => $book]);
        }
        
        // Manejar el caso de no encontrado o error
        abort(404, 'Libro no encontrado en Google Books API.');
    }
}
