<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => false, 'msg' => 'Invalid credentials']);
            }
        } catch (JWTException $exception) {
            return response()->json(['status' => false, 'msg' => $exception]);
        }

        return response()->json(['status' => true, 'token' => $token], 200);
    }

    public function register(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:tb_auth',
            'password' => 'required|string|min:6'
        ]);

        try {
            $user->create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json(['status' => true, 'msg' => 'User successfully created'], 201);
        } catch (JWTException $exception) {
            return response()->json(['status' => false, 'msg' => $exception]);
        }
    }

    public function validateToken()
    {
        return response()->json(['status' => true, 'msg' => 'Token is valid']);
    }
}
