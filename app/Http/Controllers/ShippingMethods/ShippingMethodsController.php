<?php

namespace App\Http\Controllers\ShippingMethods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingMethods\ShippingMethodsRequest;
use App\Http\Requests\ShippingMethods\ShippingMethodsUpdate;
use App\Http\Resources\ShippingMethodsResource;
use App\Models\ShippingMethods\ShippingMethods;

class ShippingMethodsController extends Controller
{
    public function index(Request $request)
    {
        // $types = ShippingMethods::shippingmethods();
        // return response($types);
        return ShippingMethodsResource::collection(ShippingMethods::get());
    }

    public function variationlist(Request $request)
    {
        $types = ShippingMethods::variationlist();
        return ShippingMethodsResource::collection(
            $types
        );
    }

    public function store(ShippingMethodsRequest $request)
    {
        $dept = ShippingMethods::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $request->price.'00',
        ]);
        
        return response()->json(['data' => $dept ], 201);
    }

    public function update(ShippingMethodsUpdate $request, $id)
    {
        $type = ShippingMethods::findOrFail(intval($id));

        $type->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $request->price.'00',
        ]);
        
        return response()->json(['data'=>$type], 200);
    }

    public function destroy($id)
    {
        //
    }
}
