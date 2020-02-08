<?php

namespace App\Events\Checkpayment;

use App\Models\Order;
use App\Pesaswap\CheckCardPaymentStatus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Checkpayment
{
    use Dispatchable, SerializesModels;
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
