<?php

namespace App\Events\Users;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\User;

class PasswordChanged
{
    use Dispatchable, SerializesModels;

    public $user, $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
