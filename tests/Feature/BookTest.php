<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Book;
use App\Models\User;
use App\Models\BookCollection;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;


class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    // Constante para el ID del libro en las respuestas simuladas
    protected const BOOK_ID = '1'; 
    protected const BOOK_TITLE = 'The Great Gatsby';
    protected const BOOK_AUTHOR = 'F. Scott Fitzgerald';

    /**
     * Returns the simulated response
     * @param string|null $bookIdToMock Si se proporciona, mockea solo el detalle de ese libro (show).
     */
    protected function mockGoogleResponse(string $bookIdToMock = null): array
    {
        // --- CASO 1: MOCKING DE DETALLE (SHOW) ---
        if ($bookIdToMock) {
            $mockedShowResponse = [
                'kind' => 'books#volume',
                'id' => $bookIdToMock,
                'volumeInfo' => [
                    'title' => self::BOOK_TITLE,
                    'authors' => [self::BOOK_AUTHOR],
                    'description' => 'A famous book about TDD.',
                    'imageLinks' => ['large' => 'http://example.com/cover.jpg'],
                ],
            ];

            // MOCK ESPECÍFICO para la URL de SHOW
            Http::fake([
                "https://www.googleapis.com/books/v1/volumes/{$bookIdToMock}*" => Http::response($mockedShowResponse, 200),
                'https://www.googleapis.com/books/v1/volumes*' => Http::response([], 404),
            ]);
            
            return $mockedShowResponse;
        } 
        
        // --- CASO 2: MOCKING DE INDEX ---
        $mockedIndexResponse = [
            'kind' => 'books#volumes',
            'totalItems' => 100,
            'items' => [
                [
                    'id' => self::BOOK_ID,
                    'volumeInfo' => [
                        'title' => self::BOOK_TITLE,
                        'authors' => [self::BOOK_AUTHOR],
                        'publisher' => 'Scribner',
                        'publishedDate' => '1925',
                        'imageLinks' => ['thumbnail' => 'http://example.com/gatsby.jpg'],
                    ],
                ],
            ],
        ];

        // MOCK GENERAL para la URL de index
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response($mockedIndexResponse, 200),
        ]);

        return $mockedIndexResponse;
    }

    #[test]
    public function index_book(): void
    {
        // ARRANGE: Llamar al método auxiliar para configurar el mocking (sin parámetros, usa index)
        $this->mockGoogleResponse();

        // ACT: Solicitar la ruta de índice de libros
        $response = $this->get('/books');

        // ASSERT: Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el título simulado esté presente en la respuesta
        $response->assertSeeText(self::BOOK_TITLE);
    }

    #[test]
    public function add_book(): void
    {
        // ARRANGE: Llamar al método auxiliar para configurar el mocking (sin parámetros, usa index)
        $this->mockGoogleResponse();

        // ACT: Solicitar la ruta de índice de libros
        $response = $this->get('/books');

        // ASSERT: Verificar que el botón "Agregar" exista con el ID correcto.
        $response->assertStatus(200);
        $response->assertSeeText('Agregar');
        // Usamos la constante para el ID
        $response->assertSee('data-book-id="' . self::BOOK_ID . '"', false);
    }

    #[test]
    public function show_book(): void
    {
        // ARRANGE: Usamos constantes y el método auxiliar
        $bookId = self::BOOK_ID;
        // Llamada con el ID para activar el MOCK de detalle (show)
        $this->mockGoogleResponse($bookId); 

        // ACT: Solicitar la ruta de detalle del libro
        $response = $this->get("/books/{$bookId}");

        // ASSERT: Verificar que la respuesta sea exitosa y contenga los datos clave
        $response->assertStatus(200);
        $response->assertSeeText(self::BOOK_TITLE);
        $response->assertSeeText(self::BOOK_AUTHOR);
        $response->assertSeeText('A famous book about TDD.');
    }
}