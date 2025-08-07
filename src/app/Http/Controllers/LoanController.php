<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Services\LoanService;
class LoanController extends Controller
{
    protected $loanService;
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
    public function show(Loan $loan)
    {
        $loanData = $this->loanService->show($loan);

        return response()->json($loanData);
    }

    /**
     * Approve a loan request.
     */
    public function approveLoan(Loan $loan)
    {
        if ($this->loanService->approve($loan)) {
            return response()->json([
                'message' => 'Loan request approved successfully.',
                'loan' => $loan,
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
}
