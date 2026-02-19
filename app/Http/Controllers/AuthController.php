<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
        ]);
    }
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->password = Hash::make($validated['password']);

        try{
            $user->save();
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to register user.',
                'message' => $e->getMessage()
            ], 500);
        }
}

    public function login(Register $request){
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:4',
        ]);
    }

    $user = User::where('email', $validated['email'])->first();

    if(!$user || !Hash::check($validated['password'], $user->password))
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],401
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'message' => 'Login successful!'
            'user' => $user
        ]201);
    
