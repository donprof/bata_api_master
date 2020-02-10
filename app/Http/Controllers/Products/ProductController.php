<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductImportForm;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;
use Illuminate\Http\Request;
use App\Http\Requests\Products\ProductUpdate;
use Illuminate\Support\Str;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\ProductHomeResource;
use App\Models\Brands\Brands;
use App\Models\Category;
use App\Models\category_product\category_product;
use App\Models\Logs\Logs;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
use File;
use DB;
use Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['variations.stock'])->whereNull('shoe_status')
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
                $product = ProductHomeResource::collection(
                    $products
                );
                return response()->json(['meta'=>$products, 'banner'=>$lastid], 200);
            }else {
                return response()->json(['data'=>null, 'meta'=>null, 'banner'=>null], 200);
            }
        }else {
            return response()->json(['data'=>null, 'meta'=>null, 'banner'=>null], 200);
        }
    }

    public function checkproductcategory()
    {
        $products = DB::select("SELECT t1.id FROM products t1 LEFT JOIN category_product t2 ON t2.product_id = t1.id WHERE t2.product_id IS NULL");

        if ($products != null) {
            foreach ($products as $value) {
                DB::insert("INSERT INTO `category_product` (`category_id`, `product_id`) values (1, $value->id)");
            }
        }
    }

    public function getbrans($brand_id)
    {
        $products = Product::with(['variations.stock'])->whereNull('shoe_status')->where('brand_id', $brand_id)->withScopes($this->scopes())->paginate(60);

        if ($products) {
            $data = collect(json_decode(collect(collect(collect($products))))->data);
            $id = json_decode(collect(json_encode(collect($data)->first()))->first());
            if (isset($id->id) && !empty($id->id)) {
                // $categoryparent = DB::select("select `category_id` FROM `category_product` where `product_id` = '$id->id' LIMIT 1");
                // if ($categoryparent){
                //     $data = json_encode($categoryparent[0]);
                //     $data1 = collect(collect($data)->first())->first();
                //     $categoryId = json_decode($data1)->category_id;
                //     $category = Category::where('id',$categoryId)->first();
                //     $fine = Category::where('id',$category->subcategory_id)->first();
                //     $lastid = Category::where('id',$fine->parent_id)->first();
                // }else{
                //     $lastid = null;
                // }
                $product = ProductIndexResource::collection(
                    $products
                );
                return response()->json(['data'=>$product, 'meta'=>$products, 'banner'=>null], 200);
            }else {
                return response()->json(['data'=>null, 'meta'=>null, 'banner'=>null], 200);
            }
        }else {
            return response()->json(['data'=>null, 'meta'=>null, 'banner'=>null], 200);
        }
    }

    public function update(ProductUpdate $request, $id)
    {
        $root = public_path('storage/');
        File::delete($root.$request->iconOldFile1);
        File::delete($root.$request->iconOldFile2);
        

        $product = Product::findOrFail(intval($id));

        Logs::create([
            'user_id'   => $request->user()->id,
            'cardlog'   =>'User updated product id: '. $id.' of product code: '.$product->productcode,
        ]);
        
        $product->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name, '-'),
            'price'         => $request->price,
            // 'icon'          => $request->icon,
            // 'icon2'          => $request->icon2,
            'latest'        => $request->latest,
            'description'   => $request->description,
        ]);
        return response()->json(['data'=>$product], 200);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name, '-'),
            'price'         => $request->price,
            // 'icon'          => $request->icon1,
            // 'icon2'          => $request->icon2,
            'latest'        => $request->latest,
            'description'   => $request->description,
        ]);
        return response()->json(['data'=>$product], 200);
    }

    public function latest()
    {
        $products = Product::with(['variations.stock'])->whereNull('shoe_status')->whereNotNull('latest')->withScopes($this->scopes())->paginate(30);
        
        return ProductHomeResource::collection(
            $products
        );
    }

    public function show(Product $product)
    {
        $product->load(['variations.type', 'variations.stock', 'variations.product']);

        $categoryparent = DB::select("select `category_id` FROM `category_product` where `product_id` = '$product->id' LIMIT 1");

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

        $ralated = Product::where('brand_id',$product->brand_id)->whereNull('shoe_status')->withScopes($this->scopes())->paginate(4);

        $ralatedresult = ProductIndexResource::collection(
            $ralated
        );

        $selected = new ProductResource(
            $product
        );

        return response()->json([
            'data'=>$selected,
            'ralated'=>$ralatedresult,
            'banner'=>$lastid
        ], 200);

    }

    protected function scopes()
    {
        return [
            'category' => new CategoryScope()
        ];
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if ($request->search != null) {
            $car = Product::with(['variations.stock'])->withScopes($this->scopes())
                            ->where('description', 'LIKE', '%' . $search . '%')
                            ->orWhere('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('productcode', 'LIKE', '%'.$search.'%')
                            ->orWhere('code', 'LIKE', '%'.$search.'%')
                            ->orWhereHas('drandname', function($query) use ($search){
                                $query->where('brands.name','LIKE','%'.$search.'%');
                            })
                            ->paginate(15);

            $product = ProductIndexResource::collection(
                $car
            );

            return response()->json(['data'=>$product, 'meta'=>$car], 200);
        }
    }

    public function categoryId($parent, $child, $subchild)
    {
        $ct1 = Category::where('name', $parent)->first();
        if ($ct1) {
            $ct2 = Category::where('name', $child)->where('parent_id', $ct1->id)->first();
            if ($ct2) {
                $ct3 = Category::where('name', $subchild)->where('subcategory_id', $ct2->id)->first();
                if ($ct3) {
                    return $ct3->id;
                }
            }
        }
    }

    public function productupload(ProductImportForm $request)
    {
        ini_set('max_execution_time', 240); //4 minutes
        if($request->hasFile('products')){
            Excel::load($request->file('products')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $value) {
                    $vals = Brands::getBrandId($value['brand']);
                    if ($vals != null) {
                        $bradId = $vals['id'];
                    }
                    else{
                        $brand = Brands::create([
                            'name' => $value['brand'],
                        ]);
                        $bradId = $brand->id;
                    }

                    $category = $value['category'];
                    $strings = preg_split("/[\s,]+/", $category);
                    
                    $parent = strtolower($strings[0]);
                    $child = strtolower($strings[1]);
                    
                    if (count($strings) > 3) {
                        $subchild = null;
                        for ($i=2; $i < count($strings); $i++) {
                            $subchild .= strtolower($strings[$i]).' ';
                        }
                    }else {
                        $subchild = strtolower($strings[2]);
                    }

                    // $categoryId = $this->categoryId($parent, $child, $subchild);

                    $first = substr($value['productcode'], 0, 3);
                    $colorcode = substr($value['productcode'],3,2);
                    $colorcodeshort = substr($value['productcode'],3,1);
                    $second = substr($value['productcode'],-2);
                    $importprice = $value['price'];
                    $final = $first.$second;
                    $productgroup = $first.$colorcode.$second;

                    // $color = ProductVariationType::where('code', $colorcode)->orWhere('name', $value['color'])->first();
                    
                    $color = ProductVariationType::where('code', $colorcode)->first();
                    
                    if ($color != null) {
                        $foundcode = Product::where('code', intval($final))->first();
                        if ($foundcode != null) {
                            $variation = ProductVariation::where('product_id', $foundcode->id)->where('product_variation_type_id', $color->id)->where('price', $importprice)->first();
                            if ($variation == null) {
                                $sizes = explode('-',$value['sizes']);
                                $lowsize = $sizes[0];
                                $highsize = $sizes[1];
                                for ($i=$lowsize; $i <= $highsize; $i++) {
                                    $variationtype = ProductVariation::create([
                                        'product_id'                => $foundcode->id,
                                        'product_variation_type_id' => $color->id,
                                        'name'                      => $i,
                                        'price'                     => $importprice,
                                    ]);
                                    Stock::create([
                                        'quantity'                  => 2,
                                        'product_variation_id'      => $variationtype->id,
                                    ]);
                                }
                            }
                            $ct1 = Category::where('name', $parent)->first();
                            if ($ct1) {
                                $ct2 = Category::where('name', $child)->where('parent_id', $ct1->id)->first();
                                if ($ct2) {
                                    $ct3 = Category::where('name', $subchild)->where('subcategory_id', $ct2->id)->first();
                                    if ($ct3) {
                                        DB::insert("insert into `category_product` (`category_id`, `product_id`) values ($ct3->id, $foundcode->id)");
                                    }
                                }
                            }
                        }else{
                            $product = Product::create([
                                'name'          => $value['productname'],
                                'slug'          => Str::slug($value['productname'].'-'.$productgroup,'-'),
                                'code'          => $final,
                                'productcode'   => $productgroup,
                                'brand_id'      => $bradId,
                                'material'      => $value['material'],
                                'sizerange'     => $value['sizes'],
                                'price'         => $importprice,
                                'description'   => $value['productdescription'],
                            ]);
    
                            if ($product) {
                                $ct1 = Category::where('name', $parent)->first();
                                if ($ct1) {
                                    $ct2 = Category::where('name', $child)->where('parent_id', $ct1->id)->first();
                                    if ($ct2) {
                                        $ct3 = Category::where('name', $subchild)->where('subcategory_id', $ct2->id)->first();
                                        if ($ct3) {
                                            DB::insert("insert into `category_product` (`category_id`, `product_id`) values ($ct3->id, $product->id)");
                                        }
                                    }
                                }

                                $sizes = explode('-',$value['sizes']);
                                $lowsize = $sizes[0];
                                $highsize = $sizes[1];
                                for ($i=$lowsize; $i <= $highsize; $i++) { 
                                    $variationtype = ProductVariation::create([
                                        'product_id'                => $product->id,
                                        'product_variation_type_id' => $color->id,
                                        'name'                      => $i,
                                        'price'                     => $importprice,
                                    ]);

                                    Stock::create([
                                        'quantity'                  => 2,
                                        'product_variation_id'      => $variationtype->id,
                                    ]);
                                }
                            }
                        }
                    }else{
                        $closercolor = ProductVariationType::where('code', 'LIKE', $colorcodeshort . '%')->first();
                        if ($closercolor != null) {
                            $foundcode = Product::where('code', intval($final))->first();
                            if ($foundcode != null) {
                                $variation = ProductVariation::where('product_id', $foundcode->id)->where('product_variation_type_id', $closercolor->id)->where('price', $importprice)->first();
                                if ($variation == null) {
                                    $sizes = explode('-',$value['sizes']);
                                    $lowsize = $sizes[0];
                                    $highsize = $sizes[1];
                                    for ($i=$lowsize; $i <= $highsize; $i++) {
                                        $variationtype = ProductVariation::create([
                                            'product_id'                => $foundcode->id,
                                            'product_variation_type_id' => $closercolor->id,
                                            'name'                      => $i,
                                            'price'                     => $importprice,
                                        ]);
                                        Stock::create([
                                            'quantity'                  => 2,
                                            'product_variation_id'      => $variationtype->id,
                                        ]);
                                    }
                                }
                            }else{
                                $product = Product::create([
                                    'name'          => $value['productname'],
                                    'slug'          => Str::slug($value['productname'].'-'.$productgroup,'-'),
                                    'code'          => $final,
                                    'productcode'   => $productgroup,
                                    'brand_id'      => $bradId,
                                    'material'      => $value['material'],
                                    'sizerange'     => $value['sizes'],
                                    'price'         => $importprice,
                                    'description'   => $value['productdescription'],
                                ]);
        
                                if ($product) {
                                    $ct1 = Category::where('name', $parent)->first();
                                    if ($ct1) {
                                        $ct2 = Category::where('name', $child)->where('parent_id', $ct1->id)->first();
                                        if ($ct2) {
                                            $ct3 = Category::where('name', $subchild)->where('subcategory_id', $ct2->id)->first();
                                            if ($ct3) {
                                                DB::insert("insert into `category_product` (`category_id`, `product_id`) values ($ct3->id, $product->id)");
                                            }
                                        }
                                    }

                                    $sizes = explode('-',$value['sizes']);
                                    $lowsize = $sizes[0];
                                    $highsize = $sizes[1];
                                    for ($i=$lowsize; $i <= $highsize; $i++) { 
                                        $variationtype = ProductVariation::create([
                                            'product_id'                => $product->id,
                                            'product_variation_type_id' => $closercolor->id,
                                            'name'                      => $i,
                                            'price'                     => $importprice,
                                        ]);

                                        Stock::create([
                                            'quantity'                  => 2,
                                            'product_variation_id'      => $variationtype->id,
                                        ]);
                                    }
                                }
        
                            }
                        }else {
                            $newcolor = ProductVariationType::create([
                                'name'          => strtolower($value['color']),
                                'colorcode'     => strtolower($value['color']),
                                'code'          => $colorcode,
                            ]);
    
                            $foundcode = Product::where('code', intval($final))->first();
                            if ($foundcode != null) {
                                $variation = ProductVariation::where('product_id', $foundcode->id)->where('product_variation_type_id', $newcolor->id)->where('price', $importprice)->first();
                                if ($variation == null) {
                                    $sizes = explode('-',$value['sizes']);
                                    $lowsize = $sizes[0];
                                    $highsize = $sizes[1];
                                    for ($i=$lowsize; $i <= $highsize; $i++) { 
                                        $variationtype = ProductVariation::create([
                                            'product_id'                => $foundcode->id,
                                            'product_variation_type_id' => $newcolor->id,
                                            'name'                      => $i,
                                            'price'                     => $importprice,
                                        ]);
    
                                        Stock::create([
                                            'quantity'                  => 2,
                                            'product_variation_id'      => $variationtype->id,
                                        ]);
                                    }
                                }
                                // $ct1 = Category::where('name', $parent)->first();
                                // \Log::info('Got to this point');
                                // if ($ct1) {
                                //     $ct2 = Category::where('name', $child)->where('parent_id', $ct1->id)->first();
                                //     if ($ct2) {
                                //         $ct3 = Category::where('name', $subchild)->where('subcategory_id', $ct2->id)->first();
                                //         if ($ct3) {
                                //             DB::insert("insert into `category_product` (`category_id`, `product_id`) values ($ct3->id, $product->id)");
                                //         }
                                //     }
                                // }
                            }else{
                                $product = Product::create([
                                    'name'          => $value['productname'],
                                    'slug'          => Str::slug($value['productname'].'-'.$productgroup,'-'),
                                    'code'          => $final,
                                    'productcode'   => $productgroup,
                                    'brand_id'      => $bradId,
                                    'material'      => $value['material'],
                                    'sizerange'     => $value['sizes'],
                                    'price'         => $importprice,
                                    'description'   => $value['productdescription'],
                                ]);
        
                                if ($product) {
                                    $sizes = explode('-',$value['sizes']);
                                    $lowsize = $sizes[0];
                                    $highsize = $sizes[1];
                                    for ($i=$lowsize; $i <= $highsize; $i++) { 
                                        $variationtype = ProductVariation::create([
                                            'product_id'                => $product->id,
                                            'product_variation_type_id' => $newcolor->id,
                                            'name'                      => $i,
                                            'price'                     => $importprice,
                                        ]);
    
                                        Stock::create([
                                            'quantity'                  => 2,
                                            'product_variation_id'      => $variationtype->id,
                                        ]);
                                    }

                                    $ct1 = Category::where('name', $parent)->first();
                                    if ($ct1) {
                                        $ct2 = Category::where('name', $child)->where('parent_id', $ct1->id)->first();
                                        if ($ct2) {
                                            $ct3 = Category::where('name', $subchild)->where('subcategory_id', $ct2->id)->first();
                                            if ($ct3) {
                                                DB::insert("insert into `category_product` (`category_id`, `product_id`) values ($ct3->id, $product->id)");
                                            }
                                        }
                                    }
                                }
        
                            }
                        }
                    }
                }
            });
        }else{
            \Log::info('Not a file'.$request->all());
        }
        return response()->json(['data' => "Products data uploaded successfully !" ], 201);
    }

    public function activateproduct(Request $request)
    {
        $product = Product::findOrFail(intval($request->id));
        $product->update([
            'shoe_status' => null,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail(intval($id));
        $product->update([
            'shoe_status' => 1,
        ]);
        return response()->json([
            'data' => 'Deactivated successfully'
        ], 200);
    }
}
