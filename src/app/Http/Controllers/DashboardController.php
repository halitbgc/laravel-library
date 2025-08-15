<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\UserService;
use App\Services\LoanService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected BookService $bookService;
    protected LoanService $loanService;
    protected UserService $userService;

    public function __construct(BookService $bookService, UserService $userService, LoanService $loanService)
    {
        $this->bookService = $bookService;
        $this->loanService = $loanService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countBooks = $this->bookService->countBooks();
        $countLoans = $this->loanService->countLoans();
        $countUsers = $this->userService->countUsers();

        return response()->json([
            'countBooks' => $countBooks,
            'countLoans' => $countLoans,
            'countUsers' => $countUsers,]
        , 200);
    }
}
