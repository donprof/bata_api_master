<?php

namespace App\Http\Controllers\ProductVariationType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductVariationType;
use App\Http\Resources\ProductVariationTypesResource;
use App\Http\Requests\ProductVariationType\ProductVariationTypeRequest;
use App\Http\Requests\ProductVariationType\ProductVariationTypeUpdate;
use Illuminate\Support\Str;

class ProductVariationTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = ProductVariationType::productvariationtype();
        return response($types);
    }

    public function variationlist(Request $request)
    {
        $types = ProductVariationType::variationlist();
        return ProductVariationTypesResource::collection(
            $types
        );
    }

    public function store(ProductVariationTypeRequest $request)
    {
        $dept = ProductVariationType::create([
            'name'          => Str::camel($request->description),
            'colorcode'     => $request->colorcode,
        ]);
        
        // Newlog::addnewlog("User Event", "Created new driver tracker: $request->description", 1);
        return response()->json(['data' => $dept ], 201);
    }

    public function update(ProductVariationTypeUpdate $request, $id)
    {
        $type = ProductVariationType::findOrFail(intval($id));

        $type->update([
            'name'          => $request->description,
            'colorcode'     => $request->colorcode,
        ]);
        
        // Newlog::addnewlog("User Event", "Updated driver tracking: $request->description", 2);
        return response()->json(['data'=>$type], 200);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if($search != null)
        {
            $department = ProductVariationType::where('description', 'LIKE', '%'.$search.'%')->orderBy("id", "ASC")->paginate(20);
            return response($department);
        }
    }
}
