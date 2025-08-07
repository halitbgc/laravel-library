<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Models\Loan;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with(['book', 'user']) // sadece gerekli alanları al
        ->select('id', 'borrowed_at', 'due_date', 'returned_at', 'status', 'user_id', 'book_id')
        ->get()
        ->map(function ($loan) {
            return [
                'id' => $loan->id,
                'borrowed_at' => $loan->borrowed_at,
                'due_date' => $loan->due_date,
                'returned_at' => $loan->returned_at,
                'status' => $loan->status,
                'user_name' => $loan->user->name ?? null,
                'book_name' => $loan->book->name ?? null,
            ];
        });
        return response()->json($loans);
    }

    public function requestLoan(LoanRequest $request)
    {
        $validatedData = $request->validated();

        $loan = Loan::create([
            'book_id' => $validatedData['book_id'],
            'user_id' => auth()->id(),
            'due_date' => $validatedData['due_date'],
        ]);
        return response()->json([
            'message' => 'Loan request created successfully.',
            'loan' => $loan,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        $loan->load([
            'user:id,name,email',
            'book:id,name,published_year,author_id,genre_id',
            'book.author:id,name',
            'book.genre:id,name'
        ]);
        return response()->json([
            'id' => $loan->id,
            'borrowed_at' => $loan->borrowed_at,
            'due_date' => $loan->due_date,
            'returned_at' => $loan->returned_at,
            'status' => $loan->status,
            'user' => [
                'id'=> $loan->user->id,
                'name' => $loan->user->name,
                'email' => $loan->user->email,
            ],
            'book' => [
                'id' => $loan->book->id,
                'name' => $loan->book->name,
                'published_year' => $loan->book->published_year,
                'author' => $loan->book->author->name ?? null,
                'genre' => $loan->book->genre->name ?? null,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Approve a loan request.
     */
    public function approveLoan(Loan $loan)
    {
        $loan->status = 'approved';
        $loan->approved_at = now();
        $loan->approved_by = auth()->id();
        $loan->save();
        return response()->json([
        'message' => 'Loan request approved successfully.',
        'loan' => $loan,
        ]);
    }
}
