<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dataTable(Request $request) : JsonResponse
    {
        $payments = User::getPayments($request->all());
        return response()->json([
            'meta' => $payments->pagination,
            'data' => array_map(function(\stdClass $payment) : \stdClass {
                $payment->refactored_date = date('d.m.y', strtotime($payment->datetime));
                return $payment;
            }, $payments->data)
        ]);
    }
}
