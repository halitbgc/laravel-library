<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'surname', 'created_at')->get();
        return json_encode($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        $user->assignRole(roles: 'calisan'); // Default role for new users
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
