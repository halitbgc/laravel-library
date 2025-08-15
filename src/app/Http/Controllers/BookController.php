<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Services\BookService;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->bookService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->create($request->validated());
        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $serviceBook = $this->bookService->show($book);
        return response()->json($serviceBook, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        $updated = $this->bookService->update($book, $request->validated());
        return response()->json(['message' => 'Book updated successfully', 'book' => $book], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($this->bookService->delete($book)) {
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete book'], 500);
        }
    }

    public function getBooksByAuthor(Author $author)
    {
        $books = $this->bookService->getBooksByAuthor($author);
        return response()->json($books, 200);
    }
    public function getBooksByGenre(Genre $genre)
    {
        $books = $this->bookService->getBooksByGenre($genre);
        return response()->json($books, 200);
    }
}
