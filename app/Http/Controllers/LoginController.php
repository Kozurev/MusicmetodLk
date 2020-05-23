<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.login');
    }

    public function auth(LoginRequest $request)
    {
        $login = $request->input('login', '');
        $password = $request->input('password', '');

        $status = User::auth($login, $password);
        $message = User::getError();

        return response()->json(['status' => $status, 'message' => $message, 'redirect_url' => route('index')]);
    }

    public function logout()
    {
        User::logout();
        return redirect(route('login.index'));
    }

}
