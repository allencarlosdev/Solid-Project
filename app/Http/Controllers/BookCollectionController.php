<?php

namespace App\Http\Controllers;

use App\Models\BookCollection;
use App\Models\Book;
use App\Services\BookCollectionService;
use App\Http\Requests\StoreBookCollectionRequest;
use App\Http\Requests\UpdateBookCollectionRequest;
use App\Http\Requests\AddBookToCollectionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookCollectionController extends Controller
{
    use AuthorizesRequests;
    
    public function __construct(
        private BookCollectionService $collectionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $collections = $this->collectionService->getUserCollections(auth()->user());
        return view('book-collections.index', compact('collections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookCollectionRequest $request): JsonResponse|RedirectResponse
    {
        $collection = $this->collectionService->createCollection(
            auth()->user(),
            $request->validated()
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Colección creada exitosamente',
                'collection' => $collection
            ]);
        }

        return redirect()->back()->with('success', 'Colección creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookCollection $bookCollection): View
    {
        $this->authorize('view', $bookCollection);

        $data = $this->collectionService->getCollectionWithEnrichedBooks($bookCollection);
        
        return view('book-collections.show', [
            'bookCollection' => $data['collection'],
            'booksData' => $data['books']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookCollectionRequest $request, BookCollection $bookCollection): RedirectResponse
    {
        $this->authorize('update', $bookCollection);

        $this->collectionService->updateCollection($bookCollection, $request->validated());

        return redirect()->back()->with('success', 'Colección actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCollection $bookCollection): RedirectResponse
    {
        $this->authorize('delete', $bookCollection);

        $this->collectionService->deleteCollection($bookCollection);

        return redirect()->route('books')->with('success', 'Colección eliminada exitosamente.');
    }

    /**
     * Add a book to the collection.
     */
    public function addBook(AddBookToCollectionRequest $request, BookCollection $bookCollection): JsonResponse|RedirectResponse
    {
        $this->authorize('addBook', $bookCollection);

        $result = $this->collectionService->addBookToCollection(
            $bookCollection,
            $request->validated()['book_external_id']
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'already_exists' => $result['already_exists']
            ]);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    /**
     * Remove a book from the collection.
     */
    public function removeBook(BookCollection $bookCollection, Book $book): RedirectResponse
    {
        $this->authorize('removeBook', $bookCollection);

        $this->collectionService->removeBookFromCollection($bookCollection, $book);

        return redirect()->back()->with('success', 'Libro removido de la colección.');
    }
}

