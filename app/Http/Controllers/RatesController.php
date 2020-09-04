<?php

namespace App\Http\Controllers;

use App\User;
use App\Api\Facade as Api;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    /**
     * RatesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('rates.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        return view('rates.buy_prepare', compact('error', 'rate'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buyExecute(Request $request, int $id)
    {
        $result = User::buyRate($id);
        return view('rates.buy_result', compact('result'));
    }

}
