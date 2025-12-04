<?php

namespace App\Http\Controllers;

use App\Models\BookCollection;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = auth()->user()->bookCollections()->get();
        return view('book-collections.index', compact('collections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:book_collections,name,NULL,id,user_id,' . auth()->id()
            ],
            'description' => 'nullable|string',
            'book_external_id' => 'nullable|string', // Google Books API ID
        ]);

        $collection = auth()->user()->bookCollections()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // If a book external ID is provided, find or create the book and add it to the collection
        if (isset($validated['book_external_id'])) {
            $book = Book::firstOrCreate(
                ['external_id' => $validated['book_external_id']],
                ['title' => 'Pending', 'authors' => []] // Will be updated later if needed
            );
            $collection->books()->attach($book->id);
        }

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Colección creada exitosamente',
                'collection' => $collection->load('books')
            ]);
        }

        return redirect()->back()->with('success', 'Colección creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookCollection $bookCollection)
    {
        // Authorization check
        if ($bookCollection->user_id !== auth()->id()) {
            abort(403);
        }

        $bookCollection->load('books');
        
        // Fetch complete book data from Google Books API
        $booksData = $bookCollection->books->map(function ($book) {
            if ($book->external_id) {
                $apiUrl = "https://www.googleapis.com/books/v1/volumes/{$book->external_id}";
                $apiKey = config('services.google_books.key');
                
                try {
                    $response = \Illuminate\Support\Facades\Http::get($apiUrl, ['key' => $apiKey]);
                    
                    if ($response->successful()) {
                        $item = $response->json();
                        $volumeInfo = $item['volumeInfo'] ?? [];
                        
                        $coverUrl = $volumeInfo['imageLinks']['medium'] ?? 
                                    $volumeInfo['imageLinks']['small'] ?? 
                                    $volumeInfo['imageLinks']['thumbnail'] ?? null;
                        
                        if ($coverUrl) {
                            $coverUrl = str_replace('http://', 'https://', $coverUrl);
                        }
                        
                        return [
                            'id' => $book->id,
                            'title' => $volumeInfo['title'] ?? $book->title,
                            'authors' => $volumeInfo['authors'] ?? $book->authors ?? ['N/A'],
                            'publisher' => $volumeInfo['publisher'] ?? 'N/A',
                            'publishedDate' => $volumeInfo['publishedDate'] ?? 'N/A',
                            'cover_url' => $coverUrl,
                            'external_id' => $item['id'] ?? $book->external_id,
                            'description' => $volumeInfo['description'] ?? 'No descripción disponible.',
                        ];
                    }
                } catch (\Exception $e) {
                    // Fallback to database data
                }
            }
            
            // Fallback to database data
            return [
                'id' => $book->id,
                'title' => $book->title,
                'authors' => $book->authors ?? ['N/A'],
                'publisher' => 'N/A',
                'publishedDate' => 'N/A',
                'cover_url' => null,
                'external_id' => $book->external_id,
                'description' => 'No descripción disponible.',
            ];
        });
        
        return view('book-collections.show', compact('bookCollection', 'booksData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCollection $bookCollection)
    {
        // Authorization check
        if ($bookCollection->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:book_collections,name,' . $bookCollection->id . ',id,user_id,' . auth()->id()
            ],
            'description' => 'nullable|string',
        ]);

        $bookCollection->update($validated);

        return redirect()->back()->with('success', 'Colección actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCollection $bookCollection)
    {
        // Authorization check
        if ($bookCollection->user_id !== auth()->id()) {
            abort(403);
        }

        $bookCollection->delete();

        return redirect()->route('books')->with('success', 'Colección eliminada exitosamente.');
    }

    /**
     * Add a book to the collection.
     */
    public function addBook(Request $request, BookCollection $bookCollection)
    {
        // Authorization check
        if ($bookCollection->user_id !== auth()->id()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
            }
            abort(403);
        }

        $validated = $request->validate([
            'book_external_id' => 'required|string', // Google Books API ID
        ]);

        // Find or create the book by external_id
        $book = Book::firstOrCreate(
            ['external_id' => $validated['book_external_id']],
            ['title' => 'Pending', 'authors' => []] // Will be updated later if needed
        );

        // Check if book is already in collection
        $alreadyExists = $bookCollection->books()->where('book_id', $book->id)->exists();
        
        if (!$alreadyExists) {
            $bookCollection->books()->attach($book->id);
            $message = 'Libro agregado exitosamente a la colección';
        } else {
            $message = 'El libro ya está en esta colección';
        }

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'already_exists' => $alreadyExists
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove a book from the collection.
     */
    public function removeBook(BookCollection $bookCollection, Book $book)
    {
        // Authorization check
        if ($bookCollection->user_id !== auth()->id()) {
            abort(403);
        }

        $bookCollection->books()->detach($book->id);

        return redirect()->back()->with('success', 'Libro removido de la colección.');
    }
}
