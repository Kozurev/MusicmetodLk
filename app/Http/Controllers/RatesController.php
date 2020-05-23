<?php

namespace App\Http\Controllers;

use App\User;
use App\Api\Facade as Api;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        User::fresh();
        $user = User::current();

        return view('rates.index', compact('user'));
    }


    public function buyPrepare(int $id)
    {
        User::fresh();
        $user = User::current();
        $rate = Api::instance()->getRateById(User::getToken(), $id);

        $error = '';
        if (isset($rate->error)) {
            $error = $rate->message ?? '';
        }
        if ($user->balance->amount < $rate->price) {
            $error = __('pages.not-enough-money-for-buy');
        }

        return view('rates.buy_prepare', compact('user', 'error', 'rate'));
    }

    public function buyExecute(Request $request, int $id)
    {
        $result = User::buyRate($id);
        User::fresh();
        $user = User::current();
        return view('rates.buy_result', compact('user', 'result'));
    }

}
