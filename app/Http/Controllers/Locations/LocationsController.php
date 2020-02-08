<?php

namespace App\Http\Controllers\Locations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Locations\Locations;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $locations = Locations::locations();
        return response($locations);
    }

    public function store(AdvertFormRequest $request)
    {
        $slider = Locations::create([
            'title'         => $request->title,
            'blinker'         => $request->blinker,
            'description'   => $request->description,
            'image'         => $request->image,
            'gradient'      => $request->gradient,
            'user_id'       => request()->user()->id
        ]);

        return response()->json(['data' => $slider], 201);
    }

    public function update(AdvertUpdateRequest $request, $id)
    {
        $slider = Locations::findOrFail(intval($id));

        $slider->title        = $request->title;
        $slider->blinker      = $request->blinker;
        $slider->description  = $request->description;
        $slider->image        = $request->image;
        $slider->gradient     = $request->gradient;
        $slider->save();

        return response()->json(['data' => $slider], 200);
    }
}
