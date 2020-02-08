<?php

namespace App\Events\Users;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class OrderTransactionSuccessfull
{
    use Dispatchable, SerializesModels;

    public $user, $order, $shippingcost;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $order, $shippingcost)
    {
        $this->user = $user;
        $this->order = $order;
        $this->shippingcost = $shippingcost;
    }
}
