<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Services\LoanService;
class LoanController extends Controller
{
    protected LoanService $loanService;
    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = $this->loanService->getAllLoans();
        return response()->json($loans);
    }

    public function getApprovedLoans()
    {
        $loans = $this->loanService->getApprovedLoans();
        return response()->json($loans);
    }

    public function getBorrowedLoans()
    {
        $loans = $this->loanService->getBorrowedLoans();
        return response()->json($loans);
    }

    public function requestLoan(LoanRequest $request)
    {
        $loan = $this->loanService->create($request->validated());

        return response()->json([
            'message' => 'Loan request created successfully.',
            'loan' => $loan,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $loanId)
    {
        $loanData = $this->loanService->show($loanId);

        return response()->json($loanData);
    }

    public function borrowedLoan(Loan $loan)
    {
        $loan = $this->loanService->borrowedLoan($loan->id);

        if ($loan) {
            return response()->json([
                'message' => 'Loan borrowed successfully.',
                'loan' => $loan,
            ]);
        }
        return response()->json([
            'message' => 'Loan could not be borrowed.',
        ], 400);
    }

    /**
     * Approve a loan request.
     */
    public function approveLoan(int $loanId)
    {
        if ($this->loanService->approve($loanId)) {
            return response()->json([
                'message' => 'Loan request approved successfully.',
            ]);
        }
        return response()->json([
            'message' => 'Loan request could not be approved.',
        ], 400);
    }

    /**
     * Reject a loan request.
     */
    public function rejectLoan(Loan $loan)
    {
        if ($this->loanService->reject($loan)) {
            return response()->json([
                'message' => 'Loan request rejected successfully.',
                'loan' => $loan,
            ]);
        }
        return response()->json([
            'message' => 'Loan request could not be rejected.',
        ], 400);
    }

    /**
     * Return a loan.
     */
    public function returnLoan(Loan $loan) {
        if ($this->loanService->returnLoan($loan->id)) {
            return response()->json([
                'message' => 'Loan returned successfully.',
                'loan' => $loan,
            ]);
        }
        return response()->json([
            'message' => 'Loan could not be returned.',
        ], 400);
    }

    public function getLoansByUserId() {
        $loans = $this->loanService->getLoansByUserId(auth()->id());
        return response()->json($loans);
    }
}
