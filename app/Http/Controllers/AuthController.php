<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // ======================
    // REGISTER
    // ======================
   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'message' => 'Register berhasil'
    ], 201);
}

    // ======================
    // LOGIN (JWT)
    // ======================
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // ✅ JWT attempt (BENAR)
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'error' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    // ======================
    // PROFILE (JWT)
    // ======================
    public function profile()
    {
        return response()->json(JWTAuth::user());
    }

    // ======================
    // LOGOUT (JWT)
    // ======================
    public function logout(Request $request)
    {
        // ambil token dari header
        $token = JWTAuth::getToken();

        // invalidate token (logout)
        JWTAuth::invalidate($token);

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
