<?php

namespace App\Services;

use App\Contracts\BookApiInterface;
use App\DTOs\BookData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Servicio para interactuar con Google Books API
 * 
 */
class GoogleBooksApiService implements BookApiInterface
{
    private const API_URL = 'https://www.googleapis.com/books/v1/volumes';
    
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_books.key');
    }

    /**
     * Buscar libros con parámetros específicos
     * 
     * @param array $params Parámetros: title, author, page, perPage
     * @return array ['items' => BookData[], 'totalItems' => int]
     */
    public function searchBooks(array $params): array
    {
        $perPage = $params['perPage'] ?? 15;
        $currentPage = $params['page'] ?? 1;
        $startIndex = ($currentPage - 1) * $perPage;
        
        $query = $this->buildSearchQuery(
            $params['title'] ?? '',
            $params['author'] ?? ''
        );

        $response = Http::get(self::API_URL, [
            'q' => $query,
            'maxResults' => $perPage,
            'startIndex' => $startIndex,
            'key' => $this->apiKey,
        ]);

        if (!$response->successful()) {
            Log::error('Error fetching books from Google API: ' . $response->body());
            return ['items' => [], 'totalItems' => 0];
        }

        $data = $response->json();
        $items = $data['items'] ?? [];
        $totalItems = $data['totalItems'] ?? 0;

        $books = array_map(
            fn($item) => BookData::fromGoogleBooksApi($item),
            $items
        );

        return [
            'items' => $books,
            'totalItems' => $totalItems,
        ];
    }

    /**
     * Obtener un libro por su ID externo
     * 
     * @param string $id ID externo del libro
     * @return BookData|null
     */
    public function getBook(string $id): ?BookData
    {
        $apiUrl = self::API_URL . "/{$id}";
        
        $response = Http::get($apiUrl, ['key' => $this->apiKey]);

        if (!$response->successful()) {
            return null;
        }

        $item = $response->json();
        return BookData::fromGoogleBooksApi($item);
    }

    /**
     * Obtener múltiples libros por sus IDs externos
     * 
     * @param array $ids Array de IDs externos
     * @return array Array de BookData
     */
    public function getBooksByIds(array $ids): array
    {
        $books = [];
        
        foreach ($ids as $id) {
            try {
                $book = $this->getBook($id);
                if ($book) {
                    $books[] = $book;
                }
            } catch (\Exception $e) {
                Log::warning("Failed to fetch book {$id}: " . $e->getMessage());
                continue;
            }
        }
        
        return $books;
    }

    /**
     * Construir query de búsqueda para Google Books API
     * 
     * @param string $title Título a buscar
     * @param string $author Autor a buscar
     * @return string Query construido
     */
    private function buildSearchQuery(string $title, string $author): string
    {
        $queryParts = [];
        
        if (!empty($title)) {
            $queryParts[] = 'intitle:' . $title;
        }
        
        if (!empty($author)) {
            $queryParts[] = 'inauthor:' . $author;
        }
        
        // Si no hay búsqueda específica, usar una consulta por defecto
        return !empty($queryParts) ? implode('+', $queryParts) : 'coding';
    }
}
