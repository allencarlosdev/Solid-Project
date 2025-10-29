<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCollection;

class BookCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create 5 book collections
        $collections = BookCollection::factory(5)->create();

        // Associate random books with each collection
        $collections->each(function ($collection) {
            $books = Book::inRandomOrder()->take(rand(3, 8))->pluck('id');
            $collection->books()->attach($books);
        });
    }
}
