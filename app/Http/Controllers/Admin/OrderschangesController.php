<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderschangesController extends Controller
{
    public function update(Request $request, $id)
    {
        $category = Order::findOrFail(intval($id));
        $category->update([
            'status' => $request->status,
        ]);
        return response()->json(['data' => $category], 200);
    }
}
