<?
namespace App\Services;

use App\Models\Loan;

class LoanService
{
    public function getAllLoans(): \Illuminate\Database\Eloquent\Collection
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
        return $loans;
    }
    public function create(array $data): Loan
    {
        $loan = Loan::create([
            'book_id' => $data['book_id'],
            'user_id' => auth()->id(),
            'due_date' => $data['due_date'],
        ]);
        return $loan;
    }

    public function show(Loan $loan): array
    {
        $loan->load([
            'user:id,name,email',
            'book:id,name,published_year,author_id,genre_id',
            'book.author:id,name',
            'book.genre:id,name'
        ]);

        return [
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
        ];
    }

    public function approve(Loan $loan): bool
    {
        $loan->status = 'approved';
        $loan->approved_at = now();
        $loan->approved_by = auth()->id();

        return $loan->save();
    }
    public function reject(Loan $loan): bool
    {
        $loan->status = 'rejected';
        $loan->approved_at = now();
        $loan->approved_by = auth()->id();

        return $loan->save();
    }
}
