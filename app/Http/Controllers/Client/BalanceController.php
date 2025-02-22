<?php

namespace App\Http\Controllers\Client;


use App\Api\Payment;
use App\Collections\P2P\ReceiversCollection;
use App\Exceptions\P2P\P2PResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\P2PRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        try {
            $remotePaymentDTO = User::createP2PTransaction(
                amount: $request->amount,
                receiverId: $request->receiver_id,
            );
            return view(User::getRoleTag(User::ROLE_CLIENT) . '.balance.p2p_deposit_success', compact('remotePaymentDTO'));
        } catch (\Throwable|P2PResponseException $e) {
            $error = $e instanceof P2PResponseException ? $e->getErrorHash() : $e->getMessage();
            return view(User::getRoleTag(User::ROLE_CLIENT) . '.balance.p2p_deposit_error', compact('error'));
        }
    }
}
