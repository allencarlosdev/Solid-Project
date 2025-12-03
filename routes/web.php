<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCollectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/favorites', [BookController::class, 'favorites'])->name('favorites');
    Route::post('/favorites/toggle', [BookController::class, 'toggleFavorite'])->name('favorites.toggle');
    
    // Book Collections
    Route::resource('book-collections', BookCollectionController::class);
    Route::post('/book-collections/{bookCollection}/books', [BookCollectionController::class, 'addBook'])
        ->name('book-collections.books.add');
    Route::delete('/book-collections/{bookCollection}/books/{book}', [BookCollectionController::class, 'removeBook'])
        ->name('book-collections.books.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
