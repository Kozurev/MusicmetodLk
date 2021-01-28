<?php

namespace App\Http\Controllers\Client;


use App\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

/**
 * Class FaqController
 * @package App\Http\Controllers\Client
 */
class FaqController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.faq.index');
    }
}
