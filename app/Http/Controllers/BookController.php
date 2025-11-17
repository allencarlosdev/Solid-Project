<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(15);

        return view('books.index', ['books' => $books]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'authors' => 'required|array',
            'isbn' => 'nullable|string',
            'external_id' => 'required|string|unique:books,external_id',
            'published_year' => 'nullable|integer',
            'publisher' => 'nullable|string',
            'cover_url' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Guardar libro
        Book::create($validated);

        // Redirigir
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
