<?php

namespace App\Listeners\Checkpayment;

use App\Events\Checkpayment\Checkpayment;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Events\Users\OrderTransactionSuccessfull;
use App\Models\Logs\Logs;
use App\Models\ShippingMethod;
use App\Models\User;
use App\Pesaswap\CheckCardPaymentStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckpaymentListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Checkpayment $event)
    {
        $paymentstate = new CheckCardPaymentStatus();

        $order = $event->order;

        $response = $paymentstate->CheckCardPaymentStatus($order->transaction_external_id);
        $fine = collect($response);

        if (isset($fine[0])) {
            if ($fine[0] == 'Record not found.') {
                event(new OrderPaymentFailed($order));
                Logs::create([
                    'user_id'   => $order->user_id,
                    'cardlog'   => serialize($response),
                ]);
            }
        }else {
            if ( isset($response->status) && !empty($response->status)) {
                if ($response->status === 'Completed') {
                    Logs::create([
                        'user_id'   => $order->user_id,
                        'cardlog'   => serialize($response),
                    ]);
        
                    $shipcost = ShippingMethod::findOrFail(floatval($order->shipping_method_id));
        
                    $shippingcost = $shipcost->price;
        
                    $user = User::findOrFail(intval($order->user_id));
        
                    event(new OrderPaid($order));
        
                    event(new OrderTransactionSuccessfull($user, $order, $shippingcost));
        
                }elseif ($response->status === 'Pending') {
                    # code...
                }elseif ($response->status === 'Failed') {
                    event(new OrderPaymentFailed($order));
                }
            }else {
                event(new OrderPaymentFailed($order));
                Logs::create([
                    'user_id'   => $order->user_id,
                    'cardlog'   => serialize($response),
                ]);
            }
        }


    }
}
