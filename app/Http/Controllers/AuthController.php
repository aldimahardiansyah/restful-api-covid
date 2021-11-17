<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # membuat function register
    public function register(Request $request)
    {
        /**
         * alur register:
         * 1. menerima data dari user
         * 2. memasukkan data ke database
         */

        # memvalidasi request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        # mengambil request
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        # menambah data pada tabel user
        $user = User::create($input);

        if ($user) {
            $data = [
                'message' => 'Register is successfully!',
                'data' => $user
            ];

            # mengembalikan data user dan code 201
            return response()->json($data, 201);
        } else {
            $data = [
                'message' => 'Register failed!'
            ];

            return response()->json($data);
        }
    }

    # membuat function login
    public function login(Request $request)
    {
        # memvalidasi request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        # mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        # membuat token
        $token = $user->createToken('auth_token');

        # membuat logika login dengan membandingkan data inputan dengan data dari database
        $isLogin = $request->email == $user->email && Hash::check($request->password, $user->password);

        if ($isLogin) {
            $data = [
                'message' => 'Login is successfully',
                'token' => $token->plainTextToken
            ];

            # mengembalikan token dan code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Login failed'
            ];

            # mengembalikan kode 401 denga pesan login failed
            return response()->json($data, 401);
        }
    }
}
