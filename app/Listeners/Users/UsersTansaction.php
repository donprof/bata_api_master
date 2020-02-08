<?php

namespace App\Listeners\Users;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\Users\OrderTransactionSuccessfull;
use App\Mail\UserTransactionCompleteMail;
use App\Models\Promocode\Promocode;
use App\Models\Voucherprice\Voucherprice;
use Illuminate\Support\Str;
use Swift_TransportException;

class UsersTansaction implements ShouldQueue
{
    use InteractsWithQueue;
/**
     * Handle the event.
     *
     * @param  OrderTransactionSuccessfull  $event
     * @return void
     */
    public function handle(OrderTransactionSuccessfull $event)
    {
        $logo = "/images/bata.jpg";
        $today = date("F j Y, g:i a");
        $appurl = config('app.url');
        // $code = (string) Str::uuid();

        // if ($event->costWithoutShipping >= 3000) {
        //     $vcode = Voucherprice::where('status', 3)->first();
        //     Promocode::create([
        //         'user_id'       => $event->user->id,
        //         'promocode'     => $code,
        //         'voucheprice_id'=> $vcode->id,
        //         'status'        => 1,
        //     ]);
        // }

        try {
            Mail::to($event->user->email)->later(10, new UserTransactionCompleteMail($event->user, $event->order, $event->shippingcost, $logo, $today, $appurl));
        } catch (Swift_TransportException $e) {
            \Log::info("Mail not sent, reasons: ".$e->getMessage());
        }
    }
}
