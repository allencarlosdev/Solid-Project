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
    public function book_collection(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
