<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.login');
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function auth(LoginRequest $request) : JsonResponse
    {
        $login = $request->input('login', '');
        $password = $request->input('password', '');

        $status = User::auth($login, $password);
        $message = User::getError();

        return response()->json(['status' => $status, 'message' => $message, 'redirect_url' => route('index')]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        User::logout();
        return redirect(route('login.index'));
    }

}
