<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        User::fresh();
        $user = User::current();
        return view('balance.index', compact('user'));
    }
}
