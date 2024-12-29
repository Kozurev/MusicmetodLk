<?php

namespace App\Http\Controllers\Client;


use App\DTO\P2P\ReceiversCollection;
use App\Http\Requests\P2PRequest;
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
     * @return RedirectResponse|View
     */
    public function makeDeposit(DepositRequest $request) : RedirectResponse|View
    {
        $amountFloat = (float)$request->amount;
        $amount = (int)round($amountFloat * 100);

        // Проверяем возможность p2p перевода
        if (!$request->without_p2p) {
            try {
                $p2pReceiversCollection = User::getP2PReceiversData($amountFloat);
            } catch (\Throwable $e) {
                $p2pReceiversCollection = new ReceiversCollection();
            }

            if ($p2pReceiversCollection->isNotEmpty()) {
                return view(User::getRoleTag(User::ROLE_CLIENT) . '.balance.p2p', [
                    'amount' => $request->amount,
                    'receivers' => $p2pReceiversCollection,
                ]);
            }
        }

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

    public function createP2PTransaction(P2PRequest $request): View
    {
        // TODO: добавить создание p2p транзакции
    }
}
