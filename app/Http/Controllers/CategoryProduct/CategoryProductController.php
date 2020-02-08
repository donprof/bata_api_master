<?php

namespace App\Http\Controllers\CategoryProduct;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategory\ProductCategoryUpdate;
use App\Models\category_product\category_product;
use DB;

class CategoryProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api,admin']);
    }

    public function index(Request $request)
    {
        $types = category_product::category_product();
        return response($types);
    }

    public function update(ProductCategoryUpdate $request, $id){

        DB::insert("update `category_product` SET `category_id` = $request->category_id where `category_id` = $request->Oldcategory AND `product_id` = $id");
        return response()->json(['data'=>'Updated successfully.'], 200);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if ($search != null) {
            $car = category_product::with(['product','category'])
                            ->where('category_id', 'LIKE', '%' . $search . '%')
                            ->orWhereHas('product', function($query) use ($search){
                                $query->where('products.name','LIKE','%'.$search.'%')->orWhere('products.code', 'LIKE', '%'.$search.'%')->orWhere('products.productcode', 'LIKE', '%'.$search.'%');
                            })
                            ->paginate(15);

            return response()->json(['data'=>$car], 200);
        }
    }
}
