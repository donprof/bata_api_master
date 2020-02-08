<?php

namespace App\Http\Controllers\Shippingdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingMethodResource;
use App\Models\Address;
use App\Models\ShippingMethod;

class ShippingdataController extends Controller
{
    public function index(Request $request)
    {
        $address = Address::where('user_id', $request->user()->id)->where('default', 1)->pluck('id')->first();
        // $fine = collect($address);
        // $data = $fine->first();
        // $address = ShippingMethod::where('user_id', $request->user()->id)->where('default', 1)->pluck('id')->first();
        // $result = $this->action($data);
        // $orders = $request->user()->orders()
        //     ->with([
        //         'products',
        //         'products.stock',
        //         'products.type',
        //         'products.product',
        //         'products.product.variations',
        //         'products.product.variations.stock',
        //         'address',
        //         'shippingMethod'
        //     ])
        //     ->latest()
        //     ->paginate(10);

        // return OrderResource::collection($orders);
        return response()->json(['address' => $address], 201);
    }

    protected function action(Address $address)
    {
        $this->authorize('show', $address);
        
        return ShippingMethodResource::collection(
            $address->country->shippingMethods
        );
    }
}
