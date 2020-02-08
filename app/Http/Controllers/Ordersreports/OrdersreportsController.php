<?php

namespace App\Http\Controllers\Ordersreports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ordersreports\Ordersreports;

class OrdersreportsController extends Controller
{
    public function index(Request $request)
    {
        $fuel = Ordersreports::ordersreports();
        return response($fuel);
    }
}
