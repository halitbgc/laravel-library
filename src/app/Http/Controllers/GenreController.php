<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {
        $validatedData = $request->validated();
        $genre = Genre::create($validatedData);
        return response()->json(['message' => 'Genre created successfully', 'genre' => $genre], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGenreRequest $request, Genre $genre)
    {
        $validatedData = $request->validated();
        $genre->update($validatedData);
        return response()->json(['message' => 'Genre updated successfully', 'genre' => $genre], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(['message' => 'Genre deleted successfully'], 200);
    }
}
