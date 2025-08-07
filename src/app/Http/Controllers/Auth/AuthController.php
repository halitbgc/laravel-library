<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();
        try{
            $user = User::create([
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'birthday' => $request->input('birthday'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
    
            $user->assignRole('ziyaretci');

            return response()->json(['message' => 'User registered successfully'], 201);
        }
        catch (Throwable $th) {
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        if (!$token = Auth::guard('api')->attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }
}