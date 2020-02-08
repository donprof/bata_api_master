<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Images\IconImageRequest;
use App\Http\Requests\Images\OfferimageRequest;
use App\Models\Product;
use App\Models\Productimages\Productimages;
use App\Models\ProductVariationType;
use App\Models\Stock;
use Intervention\Image\ImageManager;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class OfferimagesController extends Controller
{
    protected $imageManager;

    
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }
    
    public function store(OfferimageRequest $request)
    {
        $pathicon = public_path('storage/offer/');

        if(!File::isDirectory($pathicon)){
            File::makeDirectory($pathicon, 0777, true, true);
        }

        if ($request->hasFile('products')) {
            $this->imageManager->make($request->file('products')->getPathName())
                ->fit(800, 800, function ($c) {
                    $c->aspectRatio();
                })
                ->encode('jpg')
                ->save($pathicon . $path = uniqid(true) . '.jpg');
            
                return response(['data' => $path], 200);
        }
    }
}
