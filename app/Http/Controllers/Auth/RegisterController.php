<?php

namespace App\Http\Controllers\Auth;

use App\Events\Users\UserPesaswapAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\Users\UsersCreated;
use App\Mail\NewUserMail;
use App\Models\Promocode\Promocode;
use App\Models\Voucherprice\Voucherprice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function action(RegisterRequest $request)
    {
        $user = User::create($request->only('email', 'phone', 'name', 'password', 'newsletters'));
        $code = (string) Str::uuid();

        event(new UserPesaswapAccount($user));

        if ($user) {
            $vcode = Voucherprice::where('status', 1)->first();
            Promocode::create([
                'user_id'       => $user->id,
                'promocode'     => $code,
                'voucheprice_id'=> $vcode->id,
                'status'        => 1,
            ]);
        }

        $logo = "/images/bata.jpg";
        $today = date("F j Y, g:i a");
        $appurl = config('app.url');

        try {
            Mail::to($user->email)->later(10, new NewUserMail($user->email, $user->name, $today, $logo, $appurl, $code));
        } catch (Swift_TransportException $e) {
            \Log.info("Mail not sent, reasons: ".$e->getMessage());
        }

        return new PrivateUserResource($user);
    }
}
