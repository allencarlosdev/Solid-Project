<!doctype html>
<html>
<head>
 <meta charset="utf-8">
 <title>Books</title>
</head>
<body>
 <h1>Books</h1>

 <ul>
  @forelse($books as $book)
    <li>
            <a href="{{ route('books.show', ['id' => $book['external_id']]) }}">
                <strong>{{ $book['title'] }}</strong>
            </a> 

            <button 
                type="button" 
                class="add-to-collection-btn" 
                data-book-id="{{ $book['external_id'] }}"
            >
                Agregar
            </button>
            <br>
            Autor(es): {{ implode(', ', $book['authors']) }}
    </li>
  @empty
   <li>No hay libros</li>
  @endforelse
 </ul>

 {{ $books->links() }}
</body>
</html>