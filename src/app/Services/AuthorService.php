<?php
namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Author::all();
    }
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function update(Author $author, array $data): Author
    {
        $author->update($data);
        return $author;
    }
    public function delete(Author $author): bool
    {
        return $author->delete();
    }
}
