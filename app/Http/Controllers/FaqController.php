<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        User::fresh();
        $user = User::current();
        return view('faq.index', compact('user'));
    }

    public function feedback()
    {
        User::fresh();
        $user = User::current();
        return view('faq.feedback', compact('user'));
    }
}
