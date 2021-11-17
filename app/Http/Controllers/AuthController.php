<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        /**
         * alur register:
         * 1. menerima data dari user
         * 2. memasukkan data ke database
         */
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($input);

        if ($user) {
            $data = [
                'message' => 'Register is successfully!',
                'data' => $user
            ];

            return response()->json($data, 201);
        } else {
            $data = [
                'message' => 'Register failed!'
            ];

            return response()->json($data);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token');

        $isLogin = $request->email == $user->email && Hash::check($request->password, $user->password);

        if ($isLogin) {
            $data = [
                'message' => 'Login is successfully',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Login failed'
            ];

            return response()->json($data, 401);
        }
    }
}
