<?php

namespace App\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Appointment\Appointment;
use App\Http\Requests\Clinic\AppointmentRequest;
use Mail;
use App\Mail\ClnicBookingMail;
use App\Mail\ClnicMessageMail;
class BookappointmentController extends Controller
{
    public function book(AppointmentRequest $request) {
        $logo = "/images/pedlogo.png";
        $today = date("F j Y, g:i a");
        $appurl = config('app.url');

        $appointment = Appointment::create($request->only('date','time','name','email','phone','location','message'));
        // drbashiradmani@gmail.com
        try {
            Mail::to('drbashiradmani@gmail.com')->later(10, new ClnicBookingMail($appointment, $request->servicedesc, $today, $logo, $appurl));
        } catch (Swift_TransportException $e) {
            \Log::info("Mail not sent, reasons: ".$e->getMessage());
        }
        if ($appointment->email) {
            try {
                Mail::to($appointment->email)->later(10, new ClnicMessageMail($appointment, $request->servicedesc, $today, $logo, $appurl));
            } catch (Swift_TransportException $e) {
                \Log::info("Mail not sent, reasons: ".$e->getMessage());
            }
        }

        return response()->json(['data' => $appointment ], 201);
    }
}
