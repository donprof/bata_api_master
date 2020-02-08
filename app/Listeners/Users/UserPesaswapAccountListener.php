<?php

namespace App\Listeners\Users;

use App\Events\Users\UserPesaswapAccount;
use App\Models\User;
use App\Pesaswap\NewPesaswapUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPesaswapAccountListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  UserPesaswapAccount  $event
     * @return void
     */
    public function handle(UserPesaswapAccount $event)
    {
        $paymentstate = new NewPesaswapUser();
        $user = $event->user;
        $response = $paymentstate->NewPesaswapUser($user);
        if (isset($response->external_id) && !empty($response->external_id)) {
            $user = User::where('email', $response->email)->where('phone', $response->phone)->first();
            $user->external_id = $response->external_id;
            $user->save();
        }
    }
}
