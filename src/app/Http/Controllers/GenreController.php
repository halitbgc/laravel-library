<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Services\GenreService;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    protected GenreService $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = $this->genreService->index();
        return response()->json($genres, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {
        $genre = $this->genreService->create($request->validated());
        return response()->json(['message' => 'Genre created successfully', 'genre' => $genre], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return response()->json($genre, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());
        return response()->json(['message' => 'Genre updated successfully', 'genre' => $genre], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        if ($this->genreService->delete($genre)) 
        {
            return response()->json(['message' => 'Genre deleted successfully'], 200);
        } 
        else 
        {
            return response()->json(['message' => 'Genre could not be deleted'], 400);
        }
    }
}
