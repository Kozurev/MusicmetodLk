<?php

namespace App\Http\Controllers\Client;


use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Api\Payment;
use App\User;
use App\Http\Requests\DepositRequest;
use Illuminate\Http\Request;

/**
 * Class BalanceController
 * @package App\Http\Controllers\Client
 */
class BalanceController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.balance.index');
    }

    /**
     * @param DepositRequest $request
     * @return RedirectResponse
     */
    public function makeDeposit(DepositRequest $request) : RedirectResponse
    {
        $amount = intval($request->input('amount', 0)) * 100;
        $response = User::makeDeposit($amount);

        if (is_null($response) || !is_null($response->errorCode ?? null)) {
            return redirect()->back()->withErrors([$response->errorMessage ?? __('pages.error-deposit')]);
        } else {
            return redirect($response->formUrl);
        }
    }

    /**
     * @param Request $request
     * @return View
     */
    public function depositSuccess(Request $request) : View
    {
        $amount = Payment::format(floatval($request->input('amount')));
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.balance.deposit_success', compact('amount'));
    }

    /**
     * @return View
     */
    public function depositError() : View
    {
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.balance.deposit_error');
    }

}
