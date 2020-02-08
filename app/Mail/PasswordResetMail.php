<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User\User;

class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user, $password, $logo, $today, $appurl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password, $logo, $today, $appurl)
    {
        $this->user = $user;
        $this->password = $password;
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
        return $this->subject("Bata Kenya Password Reset!! 🔑")->view('emails.passwordreset');
    }
}
