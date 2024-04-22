<?php

namespace App\Http\Controllers;

use App\Http\Requests\Validator\LoginRequest;
use App\Http\Requests\Validator\SignUpRequest;
use App\Jobs\LoginEmailJob;
use App\Jobs\SignupEmailJob;
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
                    'status' => 'success'
                ]);
                LoginEmailJob::dispatch(auth::user())->onQueue('email')->delay(now()->addMinutes(1));
                return redirect()->route('chat');
            } else {
                $response = json_encode([
                    'status' => 'failed'
                ]);
                return redirect()->back()->withErrors('شماره موبایل و رمز عبور سازگار نیستند!');
            }
        } catch (\Exception $error) {
            Log::error('Login user got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return redirect()->back()->withErrors($response);
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
            SignupEmailJob::dispatch(auth::user())->onQueue('email')->delay(now()->addMinutes(1));
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
