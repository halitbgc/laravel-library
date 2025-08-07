<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validatedData = $request->validated();
        $book = Book::create($validatedData);
        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        $validatedData = $request->validated();
        $book->update($validatedData);
        return response()->json(['message' => 'Book updated successfully', 'book' => $book], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }

    public function getBooksByAuthor(Author $author)
    {
        $books = Book::where('author_id', $author->id)->get();
        return response()->json($books, 200);
    }
    public function getBooksByGenre(Genre $genre)
    {
        $books = Book::where('genre_id', $genre->id)->get();
        return response()->json($books, 200);
    }
}
