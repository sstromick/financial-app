<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Check the credentials
        if (Auth::attempt($credentials, true)) {
            return response()->json(['message' => 'Login successful', 'verified' => true], 200);
        } else {
            return response()->json(['message' => 'Login failed', 'verified' => false]);
        }
    }

    /**
     * Login user if authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Check the credentials
        if (Auth::attempt($credentials, true)) {
            $user = User::where('email', $credentials['email'])->firstOrFail();

            $tokenResult = $user->createToken('authToken');

            // Login and "remember" the given user...
            Auth::login($user, true);

            return response()->json(['message' => 'Login successful', 'verified' => true, 'user' => $user, 'access_token' => $tokenResult->accessToken], 200);
        } else {

            return response()->json(['message' => 'Login failed', 'verified' => false]);
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
