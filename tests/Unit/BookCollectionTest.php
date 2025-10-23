<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Book;
use App\Models\BookCollection;

class BookCollectionTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;

    #[Test]
    public function it_can_attach_books_to_a_collection(): void
    {
        // Arrange
        $collection = BookCollection::factory()->create();
        $books = Book::factory()->count(2)->create();

        // Act
        $collection->books()->attach($books->pluck('id'));

        // Assert
        $this->assertCount(2, $collection->books);
        $this->assertEquals($books->pluck('id')->toArray(), $collection->books->pluck('id')->toArray());
    }
}
