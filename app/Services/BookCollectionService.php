<?php

namespace App\Services;

use App\Contracts\BookApiInterface;
use App\Models\Book;
use App\Models\BookCollection;
use App\Models\User;
use Illuminate\Support\Collection;

class BookCollectionService
{
    public function __construct(
        private BookApiInterface $bookApi
    ) {}

    /**
     * Obtener todas las colecciones de un usuario
     */
    public function getUserCollections(User $user): Collection
    {
        return $user->bookCollections()->get();
    }

    /**
     * Crear una nueva colección
     */
    public function createCollection(User $user, array $data): BookCollection
    {
        $collection = $user->bookCollections()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        // Si se proporciona un libro, agregarlo a la colección
        if (isset($data['book_external_id'])) {
            $this->addBookToCollectionByExternalId($collection, $data['book_external_id']);
        }

        return $collection->load('books');
    }

    /**
     * Actualizar una colección
     */
    public function updateCollection(BookCollection $collection, array $data): BookCollection
    {
        $collection->update($data);
        return $collection;
    }

    /**
     * Eliminar una colección
     */
    public function deleteCollection(BookCollection $collection): bool
    {
        return $collection->delete();
    }

    /**
     * Agregar un libro a una colección por external_id
     */
    public function addBookToCollection(BookCollection $collection, string $externalId): array
    {
        $book = $this->addBookToCollectionByExternalId($collection, $externalId);
        
        $alreadyExists = $collection->books()->where('book_id', $book->id)->exists();
        
        if (!$alreadyExists) {
            $collection->books()->attach($book->id);
            return [
                'already_exists' => false,
                'message' => 'Libro agregado exitosamente a la colección',
            ];
        }
        
        return [
            'already_exists' => true,
            'message' => 'El libro ya está en esta colección',
        ];
    }

    /**
     * Remover un libro de una colección
     */
    public function removeBookFromCollection(BookCollection $collection, Book $book): bool
    {
        $collection->books()->detach($book->id);
        return true;
    }

    /**
     * Obtener una colección con datos enriquecidos de libros desde la API
     */
    public function getCollectionWithEnrichedBooks(BookCollection $collection): array
    {
        $collection->load('books');
        
        $booksData = $collection->books->map(function ($book) {
            if ($book->external_id) {
                try {
                    $bookData = $this->bookApi->getBook($book->external_id);
                    
                    if ($bookData) {
                        $data = $bookData->toArray();
                        $data['id'] = $book->id; // Agregar ID de base de datos
                        return $data;
                    }
                } catch (\Exception $e) {
                    // Fallback a datos de base de datos
                }
            }
            
            // Fallback a datos de base de datos
            return [
                'id' => $book->id,
                'title' => $book->title,
                'authors' => $book->authors ?? ['N/A'],
                'publisher' => 'N/A',
                'publishedDate' => 'N/A',
                'cover_url' => null,
                'external_id' => $book->external_id,
                'description' => 'No descripción disponible.',
            ];
        });
        
        return [
            'collection' => $collection,
            'books' => $booksData,
        ];
    }

    /**
     * Helper privado para encontrar o crear un libro y agregarlo a la colección
     */
    private function addBookToCollectionByExternalId(BookCollection $collection, string $externalId): Book
    {
        return Book::firstOrCreate(
            ['external_id' => $externalId],
            ['title' => 'Pending', 'authors' => []]
        );
    }
}
