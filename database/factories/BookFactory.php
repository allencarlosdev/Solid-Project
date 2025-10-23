<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        $authors = [$this->faker->name(), $this->faker->name()];
        $isbn = $this->faker->unique()->isbn13();

        return [
            'title' => $title,
            'authors' => $authors,
            'isbn' => $isbn,
            'external_id' => Str::uuid(), 
            'published_year' => $this->faker->year(),
            'publisher' => $this->faker->company(),
            'cover_url' => $this->faker->imageUrl(300, 450, 'books', true),
            'description' => $this->faker->paragraph(3),
        ];
    }
}
