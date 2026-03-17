<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|min:6|confirmed',
        'role' => 'in:admin,organizer,customer'
    ]);

    $user = User::create([
        'name'=>$validated['name'],
        'email'=>$validated['email'],
        'phone'=>$validated['phone'] ?? null,
        'role'=>$validated['role'] ?? 'customer',
        'password'=>Hash::make($validated['password'])
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'user'=>$user,
        'token'=>$token
    ],201);
}

public function login(Request $request)
{
    $validated = $request->validate([
        'email'=>'required|email',
        'password'=>'required'
    ]);

    if(!Auth::attempt($validated)){
        return response()->json(['message'=>'Invalid credentials'],401);
    }

    $user = Auth::user();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token'=>$token,
        'user'=>$user
    ]);
}

public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json([
        'message'=>'Logged out successfully'
    ]);
}

public function me(Request $request)
{
    return response()->json($request->user());
}

}