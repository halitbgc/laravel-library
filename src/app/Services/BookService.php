<?
namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Models\Author;
use App\Models\Genre;
class BookService
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Book::all();
    }
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }
    public function delete(Book $book): bool
    {
        return $book->delete();
    }
    public function getBooksByAuthor(Author $author): \Illuminate\Database\Eloquent\Collection
    {
        return Book::where('author_id', $author->id)->get();
    }
    public function getBooksByGenre(Genre $genre): \Illuminate\Database\Eloquent\Collection
    {
        return Book::where('genre_id', $genre->id)->get();
    }
}
