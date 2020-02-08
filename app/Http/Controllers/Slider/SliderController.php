<?php

namespace App\Http\Controllers\Slider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sliders\SliderFormRequest;
use App\Http\Requests\Sliders\SliderUpdateRequest;
use App\Models\Slider\Slider;
use File;

class SliderController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:api,admin']);
    // }

    public function index(Request $request)
    {
        $sliders = Slider::sliders();
        return response($sliders);
    }

    public function store(SliderFormRequest $request)
    {
        $slider = Slider::create([
            'title'         => $request->title,
            'categoriesid'  => $request->category,
            'description'   => $request->description,
            'image'         => $request->image,
            'gradient'      => $request->gradient,
            'user_id'       => request()->user()->id
        ]);

        return response()->json(['data' => $slider], 201);
    }

    public function update(SliderUpdateRequest $request, $id)
    {
        
        if (!empty($request->newImage)) {
            $image = $request->newImage;
            $root = public_path('storage/banners/');
            File::delete($root.$request->image);
        }else {
            $image = $request->image;
        }

        $slider = Slider::findOrFail(intval($id));

        $slider->title        = $request->title;
        $slider->categoriesid = $request->category;
        $slider->description  = $request->description;
        $slider->image        = $image;
        $slider->gradient     = $request->gradient;
        $slider->save();

        return response()->json(['data' => $slider], 200);
    }
}
