<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\BookCollection;
use App\Models\User;
use App\Models\Book;
use Tests\TestCase;

class BookCollectionTest extends TestCase
{
    use RefreshDatabase;

    protected const COLLECTION_NAME = 'Programación';
    protected const COLLECTION_DESCRIPTION = 'Libros de programación';
    protected const BOOK_TITLE = 'Clean Code';

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[test]
    public function store_book_collection(): void
    {
        // ARRANGE
        $collectionData = [
            'name' => self::COLLECTION_NAME,
            'description' => self::COLLECTION_DESCRIPTION,
        ];

        // ACT
        $response = $this->actingAs($this->user)->post('/book-collections', $collectionData);

        // ASSERT
        $response->assertRedirect();
        $this->assertDatabaseHas('book_collections', [
            'name' => self::COLLECTION_NAME,
            'description' => self::COLLECTION_DESCRIPTION,
            'user_id' => $this->user->id,
        ]);
    }

    #[test]
    public function index_book_collection(): void
    {
        // ARRANGE
        BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'user_id' => $this->user->id,
        ]);

        // ACT
        $response = $this->actingAs($this->user)->get('/book-collections');

        // ASSERT
        $response->assertStatus(200);
        $response->assertSeeText(self::COLLECTION_NAME);
    }

    #[test]
    public function show_book_collection(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'description' => self::COLLECTION_DESCRIPTION,
            'user_id' => $this->user->id,
        ]);

        // ACT
        $response = $this->actingAs($this->user)->get("/book-collections/{$collection->id}");

        // ASSERT
        $response->assertStatus(200);
        $response->assertSeeText(self::COLLECTION_NAME);
        $response->assertSeeText(self::COLLECTION_DESCRIPTION);
    }

    #[test]
    public function update_book_collection(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'user_id' => $this->user->id,
        ]);

        $updateData = [
            'name' => 'Desarrollo de Software',
            'description' => 'Descripción actualizada',
        ];

        // ACT
        $response = $this->actingAs($this->user)->put("/book-collections/{$collection->id}", $updateData);

        // ASSERT
        $response->assertRedirect();
        $this->assertDatabaseHas('book_collections', [
            'id' => $collection->id,
            'name' => 'Desarrollo de Software',
            'description' => 'Descripción actualizada',
        ]);
    }

    #[test]
    public function update_collection_name(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'description' => self::COLLECTION_DESCRIPTION,
            'user_id' => $this->user->id,
        ]);

        $updateData = [
            'name' => 'Nuevo Nombre',
            'description' => self::COLLECTION_DESCRIPTION,
        ];

        // ACT
        $response = $this->actingAs($this->user)->put("/book-collections/{$collection->id}", $updateData);

        // ASSERT
        $response->assertRedirect();
        $this->assertDatabaseHas('book_collections', [
            'id' => $collection->id,
            'name' => 'Nuevo Nombre',
            'description' => self::COLLECTION_DESCRIPTION,
        ]);
    }

    #[test]
    public function delete_book_collection(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'user_id' => $this->user->id,
        ]);

        // ACT
        $response = $this->actingAs($this->user)->delete("/book-collections/{$collection->id}");

        // ASSERT
        $response->assertRedirect();
        $this->assertDatabaseMissing('book_collections', [
            'id' => $collection->id,
        ]);
    }

    #[test]
    public function add_book_to_collection(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'user_id' => $this->user->id,
        ]);

        $book = Book::factory()->create([
            'external_id' => 'test-book-id-123',
        ]);

        // ACT
        $response = $this->actingAs($this->user)->post("/book-collections/{$collection->id}/books", [
            'book_external_id' => $book->external_id,
        ]);

        // ASSERT
        $response->assertRedirect();
        $this->assertDatabaseHas('book_book_collection', [
            'book_collection_id' => $collection->id,
            'book_id' => $book->id,
        ]);
    }

    #[test]
    public function delete_book_from_collection(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'user_id' => $this->user->id,
        ]);

        $book = Book::factory()->create([
            'title' => self::BOOK_TITLE,
        ]);
        
        $collection->books()->attach($book->id);

        // ACT
        $response = $this->actingAs($this->user)->delete("/book-collections/{$collection->id}/books/{$book->id}");

        // ASSERT
        $response->assertRedirect();
        $this->assertDatabaseMissing('book_book_collection', [
            'book_collection_id' => $collection->id,
            'book_id' => $book->id,
        ]);
    }

    #[test]
    public function show_books_in_collection(): void
    {
        // ARRANGE
        $collection = BookCollection::factory()->create([
            'name' => self::COLLECTION_NAME,
            'user_id' => $this->user->id,
        ]);

        $book = Book::factory()->create(['title' => self::BOOK_TITLE]);
        $collection->books()->attach($book->id);

        // ACT
        $response = $this->actingAs($this->user)->get("/book-collections/{$collection->id}");

        // ASSERT
        $response->assertStatus(200);
        $response->assertSeeText('Clean code');
    }
}
