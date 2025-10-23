<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

     protected $fillable = [
        'title',
        'authors',
        'isbn',
        'external_id',
        'published_year',
        'publisher',
        'cover_url',
        'description',
    ];

    protected $casts = [
        'authors' => 'array',
    ];

    // Mutator: guardar título en minúsculas
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower($value),
            get: fn($value) => $value ? ucfirst($value) : $value,
        );
    }

    // Accessor helper para obtener autores como string
    public function getAuthorsStringAttribute(): ?string
    {
        if (empty($this->authors)) return null;
        return implode(', ', $this->authors);
    }

}
