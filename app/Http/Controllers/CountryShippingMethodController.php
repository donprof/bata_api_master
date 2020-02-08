<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest;
use App\Http\Requests\ShippingUpdateRequest;
use App\Models\CountryShippingMethod\CountryShippingMethod;
use Illuminate\Http\Request;

class CountryShippingMethodController extends Controller
{
    public function index(Request $request)
    {
        $types = CountryShippingMethod::shippingmethod();
        return response($types);
    }

    public function variationlist(Request $request)
    {
        $types = CountryShippingMethod::variationlist();
        return ShippingMethodsResource::collection(
            $types
        );
    }

    public function store(ShippingRequest $request)
    {
        $dept = CountryShippingMethod::create([
            'country_id'          => $request->country_id,
            'shipping_method_id'   => $request->shipping_method_id
        ]);

        $type = CountryShippingMethod::findOrFail(intval($dept->id));
        
        return response()->json(['data' => $type ], 201);
    }

    public function update(ShippingUpdateRequest $request, $id)
    {
        $type = CountryShippingMethod::findOrFail(intval($id));

        $type->update([
            'country_id'            => $request->country_id,
            'shipping_method_id'    => $request->shipping_method_id,
        ]);
        
        return response()->json(['data'=>$type], 200);
    }

    public function destroy($id)
    {
        //
    }
}
