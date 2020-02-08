<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Images\SingleImageRequest;
use Intervention\Image\ImageManager;
use File;

class ProductImagesController extends Controller
{
    protected $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function store(SingleImageRequest $request)
    {
        $image = uniqid(true).'.jpg';
        $returnpath = asset('storage').'/';

        $pathlarge = public_path('storage/large');
        $pathnormal = public_path('storage/normal');
        $paththum = public_path('storage/thumb');
        $pathicon = public_path('storage/icons/');
   
        if(!File::isDirectory($pathlarge)){
            File::makeDirectory($pathlarge, 0777, true, true);
        }

        if(!File::isDirectory($pathicon)){
            File::makeDirectory($pathicon, 0777, true, true);
        }

        if(!File::isDirectory($pathnormal)){
            File::makeDirectory($pathnormal, 0777, true, true);
        }

        if(!File::isDirectory($paththum)){
            File::makeDirectory($paththum, 0777, true, true);
        }
        
        $this->imageManager->make($request->file('images')->getPathName())
            ->fit(900, 900, function ($c) {
                $c->aspectRatio();
            })
            ->encode('jpg')
            ->save(public_path('storage/large/').$image);

        
        $this->imageManager->make($request->file('images')->getPathName())
            ->fit(444, 444, function ($c) {
                $c->aspectRatio();
            })
            ->encode('jpg')
            ->save(public_path('storage/normal/').$image);


        $this->imageManager->make($request->file('images')->getPathName())
            ->fit(90, 90, function ($c) {
                $c->aspectRatio();
            })
            ->encode('jpg')
            ->save(public_path('storage/thumb/').$image);

        $this->imageManager->make($request->file('images')->getPathName())
            ->fit(180, 180, function ($c) {
                $c->aspectRatio();
            })
            ->encode('jpg')
            ->save($pathicon.$image);
        
        return response(['data' => $image, 'show' => $returnpath.'thumb/'.$image], 200);
    }
}
