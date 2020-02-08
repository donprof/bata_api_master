<?php

namespace App\Listeners\Users;

use App\Events\Users\PasswordChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

class UsersListener implements ShouldQueue
{
    use InteractsWithQueue;
/**
     * Handle the event.
     *
     * @param  PasswordChanged  $event
     * @return void
     */
    public function handle(PasswordChanged $event)
    {
        $logo = "/images/bata.jpg";
        $today = date("F j Y, g:i a");
        $appurl = config('app.url');
        try {
            Mail::to($event->user->email)->later(10, new PasswordResetMail($event->user, $event->password, $logo, $today, $appurl));
        } catch (Swift_TransportException $e) {
            Log.info("Mail not sent, reasons: ".$e->getMessage());
        }
    }
}
