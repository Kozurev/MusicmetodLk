<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function dataTable(Request $request)
    {
        $payments = User::getPayments($request->all());
        return response()->json([
            'meta' => $payments->pagination,
            'data' => $payments->data
        ]);
    }
}
