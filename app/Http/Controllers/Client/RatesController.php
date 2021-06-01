<?php

namespace App\Http\Controllers\Client;


use Illuminate\Http\RedirectResponse;
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
    public function index(): View
    {
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.rates.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function buyPrepare(int $id): View
    {
        User::fresh();
        $user = User::current();
        $rate = Api::instance()->getRateById(User::getToken(), $id);

        $error = '';
        if (isset($rate->error)) {
            $error = $rate->message ?? '';
        }
        if (empty($error) && $user->balance->amount < $rate->price) {
            $error = __('pages.not-enough-money-for-buy');
        }

        return view(User::getRoleTag(User::ROLE_CLIENT) . '.rates.buy_prepare', compact('error', 'rate'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function byCredit(int $id): RedirectResponse
    {
        $user = User::current();
        $response = Api::instance()->buyRateCredit(User::getToken(), $id);
        if (isset($response->error)) {
            return redirect()->back()->withErrors([$response->message]);
        } elseif (isset($response->link)) {
            return redirect($response->link);
        } else {
            return redirect()->back()->withErrors(['неизвестная ошибка']);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function buyExecute(Request $request, int $id): View
    {
        $result = User::buyRate($id);
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.rates.buy_result', compact('result'));
    }

}
