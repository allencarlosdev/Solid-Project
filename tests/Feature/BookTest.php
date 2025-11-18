<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Book;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    #[test]
    public function index_book(): void
    {
        // Crear algunos libros en la base de datos
        Book::factory()->count(3)->create();

        // Solicitar la ruta de índice de libros
        $response = $this->get('/books');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        $response->assertSeeText(Book::first()->title);
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
