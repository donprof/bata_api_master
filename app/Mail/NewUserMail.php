<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User\User;

class NewUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $email, $name, $today, $logo, $appurl, $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $today, $logo, $appurl, $code)
    {
        $this->email = $email;
        $this->name = $name;
        $this->logo = $logo;
        $this->today = $today;
        $this->appurl = $appurl;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Welcome to Bata Kenya !! 🎉🥳")->view('emails.newusermail');
    }
}
