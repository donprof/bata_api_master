<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Imageupload
{
    use Dispatchable, SerializesModels;

    public $producId, $colorid, $variationumber, $imagename;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($producId, $colorid, $variationumber, $imagename)
    {
        $this->producId = $producId;
        $this->colorid = $colorid;
        $this->variationumber = $variationumber;
        $this->imagename = $imagename;
    }
}
