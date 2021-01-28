<?php

namespace App\Http\Controllers\Client;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\User;
use App\Api\Facade as Api;
use Illuminate\Http\Request;

/**
 * Class RatesController
 * @package App\Http\Controllers\Client
 */
class RatesController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.rates.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function buyPrepare(int $id) : View
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

        return view(User::getRoleTag(User::ROLE_CLIENT) . '.rates.buy_prepare', compact('error', 'rate'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function buyExecute(Request $request, int $id) : View
    {
        $result = User::buyRate($id);
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.rates.buy_result', compact('result'));
    }

}
