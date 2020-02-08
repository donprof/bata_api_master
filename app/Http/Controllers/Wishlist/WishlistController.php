<?php

namespace App\Http\Controllers\Wishlist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\WishlistFormRequest;
use App\Http\Resources\ProductIndexResource;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;
use App\Models\Wishlist\Wishlist;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    
    public function index(Request $request)
    {
        $list = Wishlist::wishlist();
        return response($list);
    }

    public function allwishlist(Request $request)
    {
        // $list = Wishlist::allwishlist();
        // return response($list);
        $user = request()->user()->id;
        $list = Wishlist::where('user_id', $user)->get();
        foreach ($list as $key => $value) {
            $products = Product::with(['variations.stock'])->where('id', $value['product_id'])->first();
            // \Log::info($products);
        }
        return response()->json(['data' => $list ], 201);
    }

    public function store(WishlistFormRequest $request)
    {
        $list = Wishlist::create([
            'product_id'    => $request->product,
            'user_id'       => request()->user()->id,
        ]);

        return response()->json(['data' => $list], 201);
    }
}
