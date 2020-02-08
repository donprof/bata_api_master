<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User\User;

class ClnicMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $appointment, $servicedesc, $today, $logo, $appurl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment, $servicedesc, $today, $logo, $appurl)
    {
        $this->appointment = $appointment;
        $this->servicedesc = $servicedesc;
        $this->logo = $logo;
        $this->today = $today;
        $this->appurl = $appurl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("The Pediatric Clinic booking !! 🏥👩‍⚕️")->view('emails.clientemessage');
    }
}
