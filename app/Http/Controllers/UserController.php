<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    // Melakukan login dan mendapatkan token JWT
    public function login(Request $request)
    {
        // Periksa inputan
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $validated = $validator->validated();

        // Cek email dan password ke tabel user
        if (Auth::attempt($validated)) {
            $user = Auth::user();
            // Isi dari token
            $payload = [
                "email" => $validated["email"],
                "role" => $user->role,
                "iat" => Carbon::now()->timestamp,
                "exp" => Carbon::now()->timestamp + 60 * 60 * 2,
            ];

            // Generate token JWT
            $token = JWT::encode($payload, env('JWT_SECRET_KEY'), 'HS256');

            // Response token dikirim
            return response()->json([
                'msg' => 'Token berhasil dibuat',
                'data' => 'Bearer ' . $token
            ], 200);
        } else {
            // Response salah
            return response()->json([
                'msg' => 'Email atau password salah'
            ], 422);
        }
    }
}
