<?php

namespace App\Listeners;

use App\Events\Imageupload;
use App\Models\Productimages\Productimages;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImageUploadListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Handle the event.
     *
     * @param  Imageupload  $event
     * @return void
     */
    public function handle(Imageupload $event)
    {
        Productimages::create([
            'product_id'                    => $event->producId,
            'product_variation_type_id'     => $event->colorid,
            'status'                        => $event->variationumber,
            'image'                         => $event->imagename,
            'user_id'                       => 1,
        ]);
    }
}
