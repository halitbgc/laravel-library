<?
namespace App\Services;

use App\Models\Loan;

class LoanService
{
    public function getAllLoans()
    {
        $loans = Loan::with(['book', 'user']) // sadece gerekli alanları al
        ->select('id', 'borrowed_at', 'due_date', 'returned_at', 'status', 'user_id', 'book_id', 'created_at')
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
                'created_at' => $loan->created_at,
            ];
        });
        return $loans;
    }

    public function getApprovedLoans()
    {
        $loans = Loan::where('status', 'approved')
            ->with(['book', 'user'])
            ->select('id', 'borrowed_at', 'due_date', 'returned_at', 'status', 'user_id', 'book_id', 'approved_at')
            ->get()
            ->map(function ($loan) {
                return [
                    'id' => $loan->id,
                    'borrowed_at' => $loan->borrowed_at,
                    'due_date' => $loan->due_date,
                    'returned_at' => $loan->returned_at,
                    'status' => $loan->status,
                    'approved_at' => $loan->approved_at,
                    'user_name' => $loan->user->name ?? null,
                    'sur_name' => $loan->user->surname ?? null,
                    'book_name' => $loan->book->name ?? null,
                ];
            });
        return $loans;
    }

    public function getBorrowedLoans()
    {
        $loans = Loan::where('status', 'borrowed')
            ->with(['book', 'user'])
            ->select('id', 'borrowed_at', 'due_date', 'returned_at', 'user_id', 'book_id')
            ->get()
            ->map(function ($loan) {
                return [
                    'id' => $loan->id,
                    'borrowed_at' => $loan->borrowed_at,
                    'due_date' => $loan->due_date,
                    'user_name' => $loan->user->name ?? null,
                    'book_name' => $loan->book->name ?? null,
                ];
            });
        return $loans;
    }

    public function borrowedLoan(int $loanId)
    {
        $loan = Loan::where('id', $loanId)
            ->first();
        $loan->status = 'borrowed';
        $loan->borrowed_at = now();
        return $loan->save();
    }

    public function returnLoan(int $loanId): bool
    {
        $loan = Loan::where('id', $loanId)
            ->first();
        $loan->status = 'returned';
        $loan->returned_at = now();
        return $loan->save();
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
            'user:id,name,surname,email',
            'book:id,name,published_year,author_id,genre_id',
            'book.author:id,name',
            'book.genre:id,name',
            'approvedByUser:id,name,surname',
        ]);
        
        return [
            'id' => $loan->id,
            'borrowed_at' => $loan->borrowed_at,
            'due_date' => $loan->due_date,
            'returned_at' => $loan->returned_at,
            'status' => $loan->status,
            'approved_at' => $loan->approved_at ?? null,
            'approved_by' => [
                'id' => $loan->approvedByUser->id ?? null,
                'name' => $loan->approvedByUser->name ?? null,
                'surname' => $loan->approvedByUser->surname ?? null,
            ],
            'user' => [
                'id'=> $loan->user->id,
                'name' => $loan->user->name,
                'surname' => $loan->user->surname,
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

    public function countLoans(): int
    {
        return Loan::whereNotNull('borrowed_at') // borrowed_at dolu olacak
                   ->whereNull('returned_at')    // returned_at boş (null) olacak
                   ->count();
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

    public function getLoansByUserId(int $userId): array
    {
        $loans = Loan::where('user_id', $userId)
            ->with(['book', 'user'])
            ->get()
            ->map(function ($loan) {
                return [
                    'id' => $loan->id,
                    'borrowed_at' => $loan->borrowed_at,
                    'due_date' => $loan->due_date,
                    'returned_at' => $loan->returned_at,
                    'status' => $loan->status,
                    'book_name' => $loan->book->name ?? null,
                    'approved_at' => $loan->approved_at,
                    'created_at' => $loan->created_at,
                ];
            });

        return $loans->toArray();
    }
}
