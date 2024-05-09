<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Wrong Email or Password'
                ], 400);
            }

            $user = $request->user();
            $token = $user->createToken('user')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login Successfully',
                'token' => $token,
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }


    public function logout()
    {
        $logout = Auth::user()->tokens()->delete();
        if(!$logout){
            return response()->json([
                'status' => 400,
                'message' => 'Logout Failed'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Logout Successfully'
        ], 200);
    }
}
