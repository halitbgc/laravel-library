<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // This method should return a list of authors.
        // For now, we will return an empty array as a placeholder.
        $authors = Author::all();
        return response()->json($authors, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $validatedData = $request->validated();
        $author = Author::create($validatedData);
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
        $validatedData = $request->validated();
        $author->update($validatedData);
        return response()->json(['message' => 'Author updated successfully', 'author' => $author], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
