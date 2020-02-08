<?php

namespace App\Http\Controllers\Countries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Counties\CountiesRequest;
use App\Http\Requests\Counties\CountiesUpdateRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        return CountryResource::collection(Country::get());
    }

    public function store(CountiesRequest $request)
    {
        $type = Country::create([
            'name'  => $request->name,
            'code'  => $request->code,
        ]);

        return response()->json(['data' => $type ], 201);
    }

    public function update(CountiesUpdateRequest $request, $id)
    {
        $type = Country::where('id',$id)->first();
        $type->update([
            'name'     => $request->name,
        ]);

        return response()->json(['data'=>$type], 200);
    }
}
