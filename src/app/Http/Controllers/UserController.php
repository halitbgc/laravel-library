<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return json_encode($users);
    }

    public function getAllEmployees()
    {
        $employees = $this->userService->getAllEmployees();
        return response()->json($employees, 200);
    }

    public function getAllVisitors()
    {
        $visitors = $this->userService->getAllVisitors();
        return response()->json($visitors, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        $user->assignRole(roles: 'employee'); // Default role for new users
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return json_encode($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user->update($validatedData);
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
