<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function dataTable(Request $request)
    {
        $reports = User::getReports($request->all());
        return response()->json([
            'meta' => $reports->pagination,
            'data' => $reports->data
        ]);
    }
}
