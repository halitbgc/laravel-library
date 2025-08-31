<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
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
        $books = $this->bookService->index();
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->create($request->validated());
        return response()->json(['message' => 'Book created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $bookId)
    {
        $book = $this->bookService->show($bookId);
        return BookResource::make($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookRequest $request, int $bookId)
    {
        $book = $this->bookService->update($bookId, $request->validated());
        return response()->json(['message' => 'Book updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $bookId)
    {
        if ($this->bookService->delete($bookId)) {
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete book'], 500);
        }
    }

    public function getBooksByAuthor(Author $author)
    {
        $books = $this->bookService->getBooksByAuthor($author);
        return BookResource::collection($books);
    }
    public function getBooksByGenre(Genre $genre)
    {
        $books = $this->bookService->getBooksByGenre($genre);
        return BooksResource::collection($books);
    }
}
