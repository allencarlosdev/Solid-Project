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
    public function show_book(): void
    {
        $bookId = 'aC9EAAAAMAAJ';
        $bookTitle = 'Test Driven Development: By Example';
        
        // ARRANGE: Definir la respuesta simulada para un solo libro
        $mockedShowResponse = [
            'kind' => 'books#volume',
            'id' => $bookId,
            'volumeInfo' => [
                'title' => $bookTitle,
                'authors' => ['Kent Beck'],
                'description' => 'A famous book about TDD.',
                'imageLinks' => ['large' => 'http://example.com/tdd.jpg'],
            ],
        ];

        // ARRANGE: Falsificar (Mock) la llamada HTTP específica para la URL de detalle
        Http::fake([
            "https://www.googleapis.com/books/v1/volumes/{$bookId}*" => Http::response($mockedShowResponse, 200),
        ]);

        // ACT: Solicitar la ruta de detalle del libro
        $response = $this->get("/books/{$bookId}");

        // ASSERT: Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos clave del libro simulado estén presentes en la vista
        $response->assertSeeText($bookTitle);
        $response->assertSeeText('Kent Beck');
        $response->assertSeeText('A famous book about TDD.');
    }
}
