<?
namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;
class BookService
{
    public function index(): Collection
    {
        return Book::with([
            'author:id,name',
            'genre:id,name'
        ])->get();
    }
    public function show(Book $book): Book
    {
        return $book->load([
            'author:id,name',
            'genre:id,name'
        ]);
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
    public function countBooks(): int
    {
        return Book::count();
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
