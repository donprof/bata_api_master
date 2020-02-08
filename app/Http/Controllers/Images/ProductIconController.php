<?php

namespace App\Http\Controllers\Images;

use App\Events\Imageupload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Images\IconImageRequest;
use App\Models\Product;
use App\Models\Productimages\Productimages;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
use Intervention\Image\ImageManager;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\EventDispatcher\Event;

class ProductIconController extends Controller
{
    protected $imageManager;

    
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    protected function storeimages($producId, $colorid, $variationumber, $imagename)
    {
        event(new Imageupload($producId, $colorid, $variationumber, $imagename));
        return true;
    }
    
    public function store(IconImageRequest $request)
    {
        $pathicon = public_path('storage/icons/');
        $pathlarge = public_path('storage/large/');
        $pathnormal = public_path('storage/normal/');
        $paththum = public_path('storage/thumb/');

        if(!File::isDirectory($pathicon)){
            File::makeDirectory($pathicon, 0777, true, true);
        }
   
        if(!File::isDirectory($pathlarge)){
            File::makeDirectory($pathlarge, 0777, true, true);
        }

        if(!File::isDirectory($pathnormal)){
            File::makeDirectory($pathnormal, 0777, true, true);
        }

        if(!File::isDirectory($paththum)){
            File::makeDirectory($paththum, 0777, true, true);
        }

        if ($request->hasFile('images')) {

            foreach($request->file('images') as $file){
                
                $path = uniqid(true).'.jpg';
                //get filename with extension
                $filenamewithextension = $file->getClientOriginalName();
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                $first = substr($filename,0,3);
                $colorcode = substr($filename,4,2);
                $colorcodeshort = substr($filename,4,1);
                $second = substr($filename,6,2);
                $final = $first.$second;
                $productgroup = $first.$colorcode.$second;

                $foundcode = Product::where('code', intval($final))->first();
                
                if ($foundcode != null) {
                    $color = ProductVariationType::where('code', $colorcode)->first();
                    if ($color != null) {
                        for ($i=1; $i <= 3; $i++) {
                            $this->storeimages($foundcode->id, $color->id, $i, $path);
    
                            if ($i == 1) {
                                $storagepath = $paththum;
                                $imagesize = 90;
                            }elseif ($i == 2) {
                                $storagepath = $pathnormal;
                                $imagesize = 444;
                            }elseif ($i == 3) {
                                $storagepath = $pathlarge;
                                $imagesize = 800;
                            }
            
                            $this->imageManager->make($file->getPathName())
                            ->fit($imagesize, $imagesize, function ($c) {
                                $c->aspectRatio();
                            })
                            ->encode('jpg')
                            ->save($storagepath.$path);
                        }
                    }
                    else{
                        $closercolor = ProductVariationType::where('code', 'LIKE', $colorcodeshort . '%')->first(); //Finds any values that start with
                        if ($closercolor != null) {
                            for ($likei=1; $likei <= 3; $likei++) {
                                $this->storeimages($foundcode->id, $closercolor->id, $likei, $path);
        
                                if ($likei == 1) {
                                    $storagepath = $paththum;
                                    $imagesize = 90;
                                }elseif ($likei == 2) {
                                    $storagepath = $pathnormal;
                                    $imagesize = 444;
                                }elseif ($likei == 3) {
                                    $storagepath = $pathlarge;
                                    $imagesize = 800;
                                }
                
                                $this->imageManager->make($file->getPathName())
                                ->fit($imagesize, $imagesize, function ($c) {
                                    $c->aspectRatio();
                                })
                                ->encode('jpg')
                                ->save($storagepath . $path);
                            }
                        }else{
                            // $newvariationcolor = ProductVariationType::create([
                            //     'name'          => 'amaranth',
                            //     'colorcode'     => 'amaranth',
                            //     'code'          => $colorcode,
                            // ]);
                            
                            // for ($newdt=1; $newdt <= 3; $newdt++) {
                            //     $this->storeimages($foundcode->id, $newvariationcolor->id, $newdt, $path);
        
                            //     if ($newdt == 1) {
                            //         $storagepath = $paththum;
                            //         $imagesize = 90;
                            //     }elseif ($newdt == 2) {
                            //         $storagepath = $pathnormal;
                            //         $imagesize = 444;
                            //     }elseif ($newdt == 3) {
                            //         $storagepath = $pathlarge;
                            //         $imagesize = 800;
                            //     }
                
                            //     $this->imageManager->make($file->getPathName())
                            //     ->fit($imagesize, $imagesize, function ($c) {
                            //         $c->aspectRatio();
                            //     })
                            //     ->encode('jpg')
                            //     ->save($storagepath . $path);
                            // }

                            // $sizes = explode('-',$foundcode->sizerange);
                            // $lowsize = $sizes[0];
                            // $highsize = $sizes[1];
                            // for ($sz=$lowsize; $sz <= $highsize; $sz++) {
                            //     $variationtype = ProductVariation::create([
                            //         'product_id'                => $foundcode->id,
                            //         'product_variation_type_id' => $newvariationcolor->id,
                            //         'name'                      => $sz,
                            //     ]);

                            //     Stock::create([
                            //         'quantity'                  => 2,
                            //         'product_variation_id'      => $variationtype->id,
                            //     ]);
                            // }
                        }
                    }

                    if (empty($foundcode->icon)) {
                        $this->imageManager->make($file->getPathName())
                        ->fit(180, 180, function ($c) {
                            $c->aspectRatio();
                        })
                        ->encode('jpg')
                        ->save($pathicon . $path);

                        $foundcode->icon = $path;
                        $foundcode->save();
                    }
                    if (empty($foundcode->icon2) || $foundcode->icon2 == $foundcode->icon) {
                        $this->imageManager->make($file->getPathName())
                        ->fit(180, 180, function ($c) {
                            $c->aspectRatio();
                        })
                        ->encode('jpg')
                        ->save($pathicon . $path);

                        $foundcode->icon2 = $path;
                        $foundcode->save();
                    }
                }else {
                    // \Log::info($productgroup);
                }

            }
        }

        return response(['data' => $path], 200);
    }
}
