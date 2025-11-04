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
      <li>{{ $book->title }}</li>
    @empty
      <li>No hay libros</li>
    @endforelse
  </ul>

  {{ $books->links() }}
</body>
</html>
