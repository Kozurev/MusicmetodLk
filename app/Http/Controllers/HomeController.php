<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        User::fresh();
        $user = User::current();
        $nextLessons = User::getNextLessons();
        return view('index', compact('user', 'nextLessons'));
    }
}
