<?php

namespace App\Listeners\Users;

use App\Events\Users\CheckUserSubscription;
use App\Loyaltypoints\Adduserpoint;
use App\Loyaltypoints\SearchCustomer;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckUSerSubscriptionListender implements ShouldQueue
{
    use InteractsWithQueue;
    
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CheckUserSubscription $event)
    {
        $order = $event->order;
        $id = $order->user_id;

        $paymentstate = new SearchCustomer();

        $user = User::findOrFail(intval($id));
        $data = $paymentstate->SearchCustomer($user->phone, $user->email);
        if ($data->response->customer->count != 0) {
            $postpayment = new Adduserpoint();
            $data = $postpayment->Adduserpoint($order, $user);
            if ($data->response->status->code == 200) {
                $event->order->update([
                    'points_status' => 1
                ]);
            }
        }
    }
}
