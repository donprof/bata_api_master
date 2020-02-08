<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryListingResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:api,admin']);
    // }

    public function categorylist(Request $request)
    {
        $category = Category::whereNotNull('subcategory_id')->with('parent')->get();
        return CategoryListingResource::collection(
            $category
        );
    }

    public function index()
    {
        return CategoryResource::collection(
            Category::with('children')->parents()->ordered()->get()
        );
    }

    public function store(CategoryRequest $request)
    {
        if (!empty($request->parentSlug)) {
            $category = Category::where('slug', $request->parentSlug)->first();
            $makes = Category::create([
                'name' => $request->name,
                'parent_id' => $category->id,
            ]);
            return response()->json(['data' => $makes], 201);
        }

        if (!empty($request->childSlug)) {
            $category = Category::where('slug', $request->childSlug)->first();
            $makes = Category::create([
                'name' => $request->name,
                'subcategory_id' => $category->id,
            ]);
            return response()->json(['data' => $makes], 201);
        }

        if ($request->parent) {
            $order = Category::max('order');
            $makes = Category::create([
                'name' => $request->name,
                'order' => $order + 1,
            ]);
            return response()->json(['data' => $makes], 201);
        }else{
            //
        }
    }
    
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail(intval($id));
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json(['data' => $category], 200);
    }
}
