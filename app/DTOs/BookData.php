<?php

namespace App\DTOs;

/**
 * Data Transfer Object para datos de libros
 * 
 */
class BookData
{
    public function __construct(
        public readonly string $title,
        public readonly array $authors,
        public readonly string $publisher,
        public readonly string $publishedDate,
        public readonly ?string $coverUrl,
        public readonly string $externalId,
        public readonly string $description,
    ) {}

    /**
     * Crear una instancia de BookData desde la respuesta de Google Books API
     * 
     * @param array $item Item de la respuesta de la API
     * @return self
     */
    public static function fromGoogleBooksApi(array $item): self
    {
        $volumeInfo = $item['volumeInfo'] ?? [];
        
        // Obtener la mejor imagen disponible
        $coverUrl = $volumeInfo['imageLinks']['large'] ?? 
                    $volumeInfo['imageLinks']['medium'] ?? 
                    $volumeInfo['imageLinks']['small'] ?? 
                    $volumeInfo['imageLinks']['thumbnail'] ?? null;
        
        // Convertir http:// a https://
        if ($coverUrl) {
            $coverUrl = str_replace('http://', 'https://', $coverUrl);
        }
        
        return new self(
            title: $volumeInfo['title'] ?? 'N/A',
            authors: $volumeInfo['authors'] ?? ['N/A'],
            publisher: $volumeInfo['publisher'] ?? 'N/A',
            publishedDate: $volumeInfo['publishedDate'] ?? 'N/A',
            coverUrl: $coverUrl,
            externalId: $item['id'] ?? '',
            description: $volumeInfo['description'] ?? 'No descripción disponible.',
        );
    }

    /**
     * Convertir a array para uso en vistas
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'authors' => $this->authors,
            'publisher' => $this->publisher,
            'publishedDate' => $this->publishedDate,
            'cover_url' => $this->coverUrl,
            'external_id' => $this->externalId,
            'description' => $this->description,
        ];
    }
}
