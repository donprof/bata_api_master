<?php

namespace App\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clinic\MessageRequest;
use App\Models\Clinic\Messages\Messages;
use Mail;
use App\Mail\ClnicMessageMail;

class SendmessageController extends Controller
{
    public function message(MessageRequest $request) {
        $logo = "/images/pedlogo.png";
        $today = date("F j Y, g:i a");
        $appurl = config('app.url');

        $user = Messages::create($request->only('name', 'phone', 'email', 'message'));

        try {
            Mail::to($user->email)->later(10, new ClnicMessageMail($user->email, $user->name, $today, $logo, $appurl));
        } catch (Swift_TransportException $e) {
            \Log.info("Mail not sent, reasons: ".$e->getMessage());
        }

        return response()->json(['data' => $user ], 201);
    }
}
