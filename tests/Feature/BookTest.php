<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Book;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    #[test]
    public function index_book(): void
    {
        // ARRANGE: Definir la respuesta simulada de Google Books API
        // Usamos una estructura que imita el JSON real de Google Books
        $mockedApiResponse = [
            'kind' => 'books#volumes',
            'totalItems' => 100,
            'items' => [
                [
                    'id' => '1',
                    'volumeInfo' => [
                        'title' => 'The Great Gatsby',
                        'authors' => ['F. Scott Fitzgerald'],
                        'publisher' => 'Scribner',
                        'publishedDate' => '1925',
                        'imageLinks' => ['thumbnail' => 'http://example.com/gatsby.jpg'],
                    ],
                ],
            ],
        ];

        // ARRANGE: Falsificar (Mock) la llamada HTTP
        // Esto intercepta cualquier llamada saliente de Http::get(...)
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response($mockedApiResponse, 200),
        ]);

        // ACT: Solicitar la ruta de índice de libros
        $response = $this->get('/books');

        // ASSERT: Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el título simulado (y no un título de DB) esté presente en la respuesta
        $response->assertSeeText('The Great Gatsby');
    }

    #[test]
    public function store_book(): void
    {
        // Arrange: datos que vendrían desde Google API
        $payload = [
            'title' => 'Clean Architecture',
            'authors' => ['Robert C. Martin'],
            'isbn' => '9780134494166',
            'external_id' => 'google-abc123',
            'published_year' => 2017,
            'publisher' => 'Pearson',
            'cover_url' => 'http://example.com/cover.jpg',
            'description' => 'A book about clean architecture principles.'
        ];

        // Act: enviamos el POST a la ruta de almacenamiento
        $response = $this->post('/books', $payload);

        // Assert: respuesta correcta
        $response->assertStatus(302); // redirige después de guardar

        // Assert: el libro se almacenó
        $this->assertDatabaseHas('books', [
            'external_id' => 'google-abc123',
            'title' => strtolower('Clean Architecture'),
        ]);
    }


}
