<?
namespace App\Services;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Author;
use App\Models\Genre;
class BookService
{
    public function index(): LengthAwarePaginator
    {
        return Book::with([
            'author:id,name',
            'genre:id,name'
        ])->paginate(20);
    }
    
    public function show(int $bookID): Book
    {
        $book = Book::findOrFail($bookID);
        return $book->load([
            'author:id,name',
            'genre:id,name'
        ]);
    }
    
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(int $bookId, array $data): Book
    {
        $book = Book::findOrFail($bookId);
        $book->update($data);
        return $book;
    }

    public function delete(int $bookId): bool
    {
        $book = Book::findOrFail($bookId);
        return $book->delete();
    }
    public function countBooks(): int
    {
        return Book::count();
    }
    public function getBooksByAuthor(Author $author)
    {
        return Book::where('author_id', $author->id)->get();
    }
    public function getBooksByGenre(Genre $genre)
    {
        return Book::where('genre_id', $genre->id)->get();
    }
}
