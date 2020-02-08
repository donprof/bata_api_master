<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserTransactionCompleteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user, $order, $shipping, $logo, $today, $appurl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order, $shipping, $logo, $today, $appurl)
    {
        $this->user = $user;
        $this->order = $order;
        $this->shipping = $shipping;
        $this->logo = $logo;
        $this->today = $today;
        $this->appurl = $appurl;
        $this->totalcost = $shipping+$order->subtotal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("🎉 Successfull Payment to Bata Kenya Shop!! 🥳")->view('emails.orderpaid');
    }
}
