<?php

namespace App\Http\Controllers\ProductVariation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariation\ProductVariationRequest;
use App\Http\Requests\ProductVariation\ProductVariationUpdateRequest;
use App\Models\ProductVariation;
use App\Models\Stock;

class ProductVariationController extends Controller
{
    public function store(ProductVariationRequest $request)
    {
        $dept = ProductVariation::create([
            'product_id'                => $request->product,
            'product_variation_type_id' => $request->color,
            'name'                      => $request->size,
            'price'                     => $request->price,
        ]);
        
        return response()->json(['data' => $dept ], 201);
    }

    public function update(ProductVariationUpdateRequest $request, $id)
    {
        $prd = ProductVariation::findOrFail(intval($id));
        $prd->product_variation_type_id = $request->color;
        $prd->name = $request->size;
        $prd->save();
        
        return response()->json(['data' => $prd ], 201);
    }

    public function destroy($id)
    {
        $stock = Stock::where('product_variation_id', $id)->get();
        foreach($stock as $st){
            $st->delete();
        }
        $issue = ProductVariation::findOrFail($id);
        if ($issue) {
            $issue->delete();
            return response()->json([
                'data' => 'Fuel issuance deleted.'
            ], 200);
        }
    }
}
