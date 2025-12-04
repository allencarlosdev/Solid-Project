<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Http\Requests\ToggleFavoriteRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador de libros
 * 
 */
class BookController extends Controller
{
    public function __construct(
        private BookService $bookService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $books = $this->bookService->getPaginatedBooks($request);
        $userCollections = $this->bookService->getUserCollections(auth()->user());
        $favoritedBookIds = $this->bookService->getFavoritedBookIds(auth()->user());

        return view('books.index', [
            'books' => $books,
            'userCollections' => $userCollections,
            'favoritedBookIds' => $favoritedBookIds
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $bookData = $this->bookService->getBookById($id);
        
        if (!$bookData) {
            abort(404, 'Libro no encontrado en Google Books API.');
        }

        return view('books.show', ['book' => $bookData->toArray()]);
    }

    /**
     * Display user's favorite books
     */
    public function favorites(Request $request): View
    {
        $books = $this->bookService->getUserFavoriteBooks(auth()->user());
        
        return view('books.favorites', ['books' => $books]);
    }

    /**
     * Toggle favorite status for a book
     */
    public function toggleFavorite(ToggleFavoriteRequest $request): JsonResponse|RedirectResponse
    {
        $result = $this->bookService->toggleFavorite(
            auth()->user(),
            $request->validated()['book_external_id']
        );

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'favorited' => $result['favorited']
            ]);
        }

        return redirect()->back()->with('success', $result['message']);
    }
}

