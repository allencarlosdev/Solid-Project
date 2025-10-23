<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 

class BookCollection extends Model
{
    /** @use HasFactory<\Database\Factories\BookCollectionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Relación muchos a muchos con Book
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withTimestamps();
    }
}
