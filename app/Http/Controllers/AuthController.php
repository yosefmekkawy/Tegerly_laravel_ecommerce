<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(UserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json(['success' => true]);
        } else {

            return response()->json(['success' => false, 'error' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
