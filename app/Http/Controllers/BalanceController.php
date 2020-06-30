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

    public function index()
    {
        User::fresh();
        $user = User::current();
        return view('balance.index', compact('user'));
    }

    public function makeDeposit(DepositRequest $request)
    {
        $amount = intval($request->input('amount', 0)) * 100;
        $response = User::makeDeposit($amount);
        //dd($response);
        if (is_null($response) || !is_null($response->errorCode ?? null)) {
            return redirect()->back()->withErrors([__('pages.error-deposit')]);
        } else {
            return redirect($response->formUrl);
        }
    }


    public function depositSuccess(Request $request)
    {
        User::fresh();
        $user = User::current();
        $amount = Payment::format(floatval($request->input('amount')));
        return view('balance.deposit_success', compact('user', 'amount'));
    }

    public function depositError()
    {
        User::fresh();
        $user = User::current();
        return view('balance.deposit_error', compact('user'));
    }

}
