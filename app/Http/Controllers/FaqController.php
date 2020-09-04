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
        return view('faq.index');
    }
}
