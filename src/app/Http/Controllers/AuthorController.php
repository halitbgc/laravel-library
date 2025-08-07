<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthorService;
use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;

class AuthorController extends Controller
{
    protected AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // This method should return a list of authors.
        // For now, we will return an empty array as a placeholder.
        $authors = $this->authorService->index();
        return response()->json($authors, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = $this->authorService->create($request->validated());
        return response()->json(['message' => 'Author created successfully', 'author' => $author], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return response()->json($author, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAuthorRequest $request, Author $author)
    {
        $this->authorService->update($author, $request->validated());
        return response()->json(['message' => 'Author updated successfully', 'author' => $author], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if ($this->authorService->delete($author)) {
            return response()->json(['message' => 'Author deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete author'], 500);
        }
    }
}
