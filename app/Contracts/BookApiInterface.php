<?php

namespace App\Contracts;

use App\DTOs\BookData;

/**
 * Interface para servicios de API de libros
 * 
 */
interface BookApiInterface
{
    /**
     * Buscar libros con parámetros específicos
     * 
     * @param array $params Parámetros de búsqueda (title, author, page, perPage, etc.)
     * @return array ['items' => BookData[], 'totalItems' => int]
     */
    public function searchBooks(array $params): array;

    /**
     * Obtener un libro por su ID externo
     * 
     * @param string $id ID externo del libro
     * @return BookData|null
     */
    public function getBook(string $id): ?BookData;

    /**
     * Obtener múltiples libros por sus IDs externos
     * 
     * @param array $ids Array de IDs externos
     * @return array Array de BookData
     */
    public function getBooksByIds(array $ids): array;
}
