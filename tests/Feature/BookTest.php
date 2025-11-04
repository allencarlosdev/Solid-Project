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
}
