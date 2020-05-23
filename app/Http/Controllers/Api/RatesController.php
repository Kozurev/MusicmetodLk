<?php

namespace App\Http\Controllers\Api;

use App\Api\Facade as Api;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function dataTable(Request $request)
    {
        $rates = Api::instance()->getRates(User::getToken());
        return response()->json([
            'meta' => $rates->pagination ?? [],
            'data' => $rates->data ?? $rates
        ]);
    }
}
