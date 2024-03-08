<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use App\Http\Requests\validator\LoginRequest;
use App\Http\Requests\validator\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public static function login(LoginRequest $request)
    {
        $credentials = $request->only('phone', 'password');
        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $response = json_encode([
                    'status' => 'success',
                ]);
                return response($response, 200);
            } else {
                $response = json_encode([
                    'status' => 'failed',
                    'message' => 'phone and password not match!',
                ]);
                return response($response, 403);
            }
        } catch (\Exception $error) {
            Log::error('Login user got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }

    }

    public static function signUp(SignUpRequest $request)
    {
        $phone = $request['phone'];
        $password = $request['password'];
        try {
            \App\Models\User::insertUser($phone, $password);
            $response = json_encode([
                'status' => 'success',
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('inserting user got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }
}
