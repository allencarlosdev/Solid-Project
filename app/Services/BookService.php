<?php

namespace App\Services;

use App\Contracts\BookApiInterface;
use App\DTOs\BookData;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Servicio de alto nivel para lógica de negocio de libros
 * 
 */
class BookService
{
    public function __construct(
        private BookApiInterface $bookApi
    ) {}

    /**
     * Obtener libros paginados con búsqueda
     * 
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedBooks(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        $currentPage = $request->get('page', 1);
        
        $result = $this->bookApi->searchBooks([
            'title' => $request->get('search_title', ''),
            'author' => $request->get('search_author', ''),
            'page' => $currentPage,
            'perPage' => $perPage,
        ]);

        $booksData = collect($result['items'])->map(fn(BookData $book) => $book->toArray());

        return new LengthAwarePaginator(
            $booksData,
            $result['totalItems'],
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }

    /**
     * Obtener un libro por su ID
     * 
     * @param string $id
     * @return BookData|null
     */
    public function getBookById(string $id): ?BookData
    {
        return $this->bookApi->getBook($id);
    }

    /**
     * Obtener los libros favoritos de un usuario
     * 
     * @param User $user
     * @return Collection
     */
    public function getUserFavoriteBooks(User $user): Collection
    {
        $favoriteBooks = $user->favorites;
        
        return $favoriteBooks->map(function ($book) {
            // Intentar obtener datos actualizados de la API
            if ($book->external_id) {
                try {
                    $bookData = $this->bookApi->getBook($book->external_id);
                    
                    if ($bookData) {
                        return $bookData->toArray();
                    }
                } catch (\Exception $e) {
                    // Fallback a datos de base de datos
                }
            }
            
            // Fallback: usar datos de la base de datos
            return [
                'title' => $book->title,
                'authors' => $book->authors ?? ['N/A'],
                'publisher' => 'N/A',
                'publishedDate' => 'N/A',
                'cover_url' => null,
                'external_id' => $book->external_id,
                'description' => 'No descripción disponible.',
            ];
        });
    }

    /**
     * Alternar el estado de favorito de un libro
     * 
     * @param User $user
     * @param string $externalId
     * @return array ['favorited' => bool, 'message' => string]
     */
    public function toggleFavorite(User $user, string $externalId): array
    {
        // Encontrar o crear el libro
        $book = Book::firstOrCreate(
            ['external_id' => $externalId],
            ['title' => 'Pending', 'authors' => []]
        );

        // Alternar favorito
        $isFavorited = $user->favorites()->where('book_id', $book->id)->exists();
        
        if ($isFavorited) {
            $user->favorites()->detach($book->id);
            return [
                'favorited' => false,
                'message' => 'Libro removido de favoritos',
            ];
        }
        
        $user->favorites()->attach($book->id);
        return [
            'favorited' => true,
            'message' => 'Libro agregado a favoritos',
        ];
    }

    /**
     * Obtener las colecciones de un usuario con conteo de libros
     * 
     * @param User $user
     * @return Collection
     */
    public function getUserCollections(User $user): Collection
    {
        return $user->bookCollections()->withCount('books')->get();
    }

    /**
     * Obtener los IDs externos de libros favoritos de un usuario
     * 
     * @param User $user
     * @return array
     */
    public function getFavoritedBookIds(User $user): array
    {
        return $user->favorites()->pluck('external_id')->toArray();
    }
}
