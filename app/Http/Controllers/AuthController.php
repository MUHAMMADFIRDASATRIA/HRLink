<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'access_token' => $token,
            'remember_token' => $user->remember_token,
            'token_type' => 'Bearer',
            'message' => 'Login successful',
        ], 200);
    }

    public function logout(Request $request){
    Auth::guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['message'=>'Logged out']);
    }
}
