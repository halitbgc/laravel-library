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

    public function update(Genre $genre, array $data): Genre
    {
        $genre->update($data);
        return $genre;
    }
    public function delete(Genre $genre): bool
    {
        return $genre->delete();
    }
}
