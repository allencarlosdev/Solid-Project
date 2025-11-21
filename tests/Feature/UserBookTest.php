<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserBookTest extends TestCase
{
    use RefreshDatabase;

    #[test]
    public function user_book_add(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

}
