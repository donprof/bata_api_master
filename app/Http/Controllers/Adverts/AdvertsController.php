<?php

namespace App\Http\Controllers\Adverts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adverts\Adverts;
use App\Http\Requests\Adverts\AdvertFormRequest;
use App\Http\Requests\Adverts\AdvertUpdateRequest;
use File;

class AdvertsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['index']);
    }

    public function index(Request $request)
    {
        $sliders = Adverts::adverts();
        return response($sliders);
    }

    public function store(AdvertFormRequest $request)
    {
        $slider = Adverts::create([
            'title'         => $request->title,
            'slugid'        => $request->category,
            'blinker'       => $request->blinker,
            'description'   => $request->description,
            'image'         => $request->image,
            'gradient'      => $request->gradient,
            'user_id'       => request()->user()->id
        ]);

        return response()->json(['data' => $slider], 201);
    }

    public function update(AdvertUpdateRequest $request, $id)
    {
        $root = public_path('storage/offer/');
        File::delete($root.$request->oldImage);

        $slider = Adverts::findOrFail(intval($id));

        $slider->title        = $request->title;
        $slider->slugid       = $request->category;
        $slider->blinker      = $request->blinker;
        $slider->description  = $request->description;
        $slider->image        = $request->image;
        $slider->gradient     = $request->gradient;
        $slider->save();

        return response()->json(['data' => $slider], 200);
    }
}
