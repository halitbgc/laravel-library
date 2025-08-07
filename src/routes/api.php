<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Ortak
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    // admin
    Route::middleware('role:admin')->group(function () {
       Route::apiResource('users', UserController::class);
    });

    // calisan + admin
    Route::middleware('role:calisan|admin')->group(function () {
        Route::post('authors', [AuthorController::class, 'store']);
        Route::delete('authors/{author}/delete', [AuthorController::class, 'destroy']);
        Route::put('authors/{author}', [AuthorController::class, 'update']);

        Route::post('genres', [GenreController::class, 'store']);
        Route::delete('genres/{genre}/delete', [GenreController::class, 'destroy']);
        Route::put('genres/{genre}', [GenreController::class, 'update']);

        Route::post('books', [BookController::class, 'store']);
        Route::delete('books/{book}/delete', [BookController::class, 'destroy']);
        Route::put('books/{book}', [BookController::class, 'update']);

        // Loan management
        Route::get('loans', [LoanController::class, 'index']);
        Route::get('loans/{loan}', [LoanController::class, 'show']);
        Route::put('loans/{loan}/approve', [LoanController::class, 'approveLoan']);
        Route::put('loans/{loan}/reject', [LoanController::class, 'rejectLoan']);

    });

    // calisan + admin + ziyaretci
    Route::middleware('role:ziyaretci|calisan|admin')->group(function () {
        Route::get('authors', [AuthorController::class, 'index']);
        Route::get('authors/{author}', [AuthorController::class, 'show']);
    
        Route::get('genres', [GenreController::class, 'index']);
        Route::get('genres/{genre}', [GenreController::class, 'show']);
    
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{book}', [BookController::class, 'show']);
        Route::get('books/author/{author}', [BookController::class, 'getBooksByAuthor']);
        Route::get('books/genre/{genre}', [BookController::class, 'getBooksByGenre']);
        
        // Loan request
        Route::post('/loans', [LoanController::class, 'requestLoan']);
    });
});