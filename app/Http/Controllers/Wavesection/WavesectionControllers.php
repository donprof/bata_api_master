<?php

namespace App\Http\Controllers\Wavesection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wavesection\WaveFormRequest;
use App\Http\Requests\Wavesection\WaveUpdateRequest;
use App\Models\Wavesection\Wavesection;

class WavesectionControllers extends Controller
{
    public function index(Request $request)
    {
        $sales = Wavesection::wave();
        return response($sales);
    }

    public function store(WaveFormRequest $request)
    {
        $slider = Wavesection::create([
            'title'         => $request->title,
            'categoryid'    => $request->category,
            'offer'         => $request->offer,
            'description'   => $request->description,
            'image'         => $request->image,
            'user_id'       => request()->user()->id
        ]);

        return response()->json(['data' => $slider], 201);
    }

    public function update(WaveUpdateRequest $request, $id)
    {
        $slider = Wavesection::findOrFail(intval($id));

        $slider->title          = $request->title;
        $slider->categoryid     = $request->title;
        $slider->offer          = $request->offer;
        $slider->description    = $request->description;
        $slider->image          = $request->image;
        $slider->save();

        return response()->json(['data' => $slider], 200);
    }
}
