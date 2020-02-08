<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Images\ImageRequest;
use App\Models\Product;
use App\Models\Productimages\Productimages;

class SaveimagesController extends Controller
{
    public function store(ImageRequest $request)
    {
        foreach($request->images as $value){
            Productimages::create([
                'product_id'                    => $request->product,
                'product_variation_type_id'     => $request->color,
                'status'                        => 1,
                'image'                         => $value,
                'user_id'                       => 1,
            ]);

            Productimages::create([
                'product_id'                    => $request->product,
                'product_variation_type_id'     => $request->color,
                'status'                        => 2,
                'image'                         => $value,
                'user_id'                       => 1,
            ]);

            Productimages::create([
                'product_id'                    => $request->product,
                'product_variation_type_id'     => $request->color,
                'status'                        => 3,
                'image'                         => $value,
                'user_id'                       => 1,
            ]);
            $foundcode = Product::where('id', intval($request->product))->first();
            if ($foundcode != null) {
                if (empty($foundcode->icon)) {
                    $foundcode->icon = $value;
                    $foundcode->save();
                }
                if (empty($foundcode->icon2) || $foundcode->icon2 == $foundcode->icon) {
                    $foundcode->icon2 = $value;
                    $foundcode->save();
                }
            }
        }


        return response()->json(['data' => 'Saves successfuly'], 201);
    }
}
