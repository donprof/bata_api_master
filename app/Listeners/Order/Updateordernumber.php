<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderCreated;
use App\Models\Ordernumbers\Ordernumbers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Updateordernumber implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $orderNumber = $order->order_number;

        $number = Ordernumbers::first();
        $number->update([
            'number' => $orderNumber
        ]);
    }
}
