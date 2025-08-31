<?
namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Genre::all();
    }
    public function create(array $data): Genre
    {
        return Genre::create($data);
    }

    public function update(int $genreId, array $data): Genre
    {
        $genre = Genre::findOrFail($genreId);
        $genre->update($data);
        return $genre;
    }
    public function delete(int $genreId): bool
    {
        $genre = Genre::findOrFail($genreId);
        return $genre->delete();
    }
}
