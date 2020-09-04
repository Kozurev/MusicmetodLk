<?php

namespace App\Http\Controllers;

use App\Api\Payment;
use App\User;
use App\Http\Requests\DepositRequest;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('balance.index');
    }

    /**
     * @param DepositRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function makeDeposit(DepositRequest $request)
    {
        $amount = intval($request->input('amount', 0)) * 100;
        $response = User::makeDeposit($amount);

        if (is_null($response) || !is_null($response->errorCode ?? null)) {
            return redirect()->back()->withErrors([__('pages.error-deposit')]);
        } else {
            return redirect($response->formUrl);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function depositSuccess(Request $request)
    {
        $amount = Payment::format(floatval($request->input('amount')));
        return view('balance.deposit_success', compact('amount'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function depositError()
    {
        return view('balance.deposit_error');
    }

}
