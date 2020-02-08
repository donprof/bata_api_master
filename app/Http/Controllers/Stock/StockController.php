<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ProductVariation::with(['product','stock'])->paginate(30);
        return response($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show($request)
    {
        if ($request != null) {
            $car = ProductVariation::with(['product','stock'])
                            ->where('name', 'LIKE', '%' . $request . '%')
                            ->orWhere('price', 'LIKE', '%' . $request . '%')
                            ->orWhereHas('product', function($query) use ($request){
                                $query->where('products.material','LIKE','%'.$request.'%')->orWhere('products.productcode','LIKE','%'.$request.'%')->orWhere('products.price','LIKE','%'.$request.'%')->orWhere('products.name','LIKE','%'.$request.'%')->orWhere('products.description','LIKE','%'.$request.'%')->orWhere('products.code','LIKE','%'.$request.'%');
                            })
                            ->paginate(30);
            return response($car);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $foundcode = Stock::where('product_variation_id', intval($id))->first();
        if ($foundcode != null) {
            $foundcode->quantity = $request->quantity;
            $foundcode->save();
        }
        return response()->json(['data' => 'Updated successfuly'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
