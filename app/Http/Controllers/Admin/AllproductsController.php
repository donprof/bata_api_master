<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Models\Category;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;
use DB;

class AllproductsController extends Controller
{
    public function index()
    {
        $products = Product::with(['variations.stock'])
        ->withScopes($this->scopes())->paginate(30);

        if ($products) {
            $data = collect(json_decode(collect(collect(collect($products))))->data);
            $id = json_decode(collect(json_encode(collect($data)->first()))->first());
            if (isset($id->id) && !empty($id->id)) {
                $categoryparent = DB::select("select `category_id` FROM `category_product` where `product_id` = '$id->id' LIMIT 1");
                if ($categoryparent){
                    $data = json_encode($categoryparent[0]);
                    $data1 = collect(collect($data)->first())->first();
                    $categoryId = json_decode($data1)->category_id;
                    $category = Category::where('id',$categoryId)->first();
                    $fine = Category::where('id',$category->subcategory_id)->first();
                    $lastid = Category::where('id',$fine->parent_id)->first();
                }else{
                    $lastid = null;
                }
                $product = ProductIndexResource::collection(
                    $products
                );
                return response()->json(['data'=>$product, 'meta'=>$products, 'banner'=>$lastid], 200);
            }else {
                return response()->json(['data'=>null, 'meta'=>null, 'banner'=>null], 200);
            }
        }else {
            return response()->json(['data'=>null, 'meta'=>null, 'banner'=>null], 200);
        }
    }

    protected function scopes()
    {
        return [
            'category' => new CategoryScope()
        ];
    }
}
