<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_stores_and_retrieves_authors_as_array()
    {
        $book = Book::factory()->create([
            'authors' => ['Robert C. Martin', 'Kent Beck'],
        ]);

        $freshBook = Book::first();

        $this->assertIsArray($freshBook->authors);
        $this->assertEquals(['Robert C. Martin', 'Kent Beck'], $freshBook->authors);
    }

    #[Test]
    public function it_applies_title_mutator_correctly()
    {
        $book = Book::factory()->create(['title' => 'CLEAN CODE']);
        $freshBook = Book::first();

        $this->assertEquals('Clean code', $freshBook->title);
    }
}
