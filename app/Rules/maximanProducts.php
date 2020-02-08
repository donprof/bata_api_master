<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class maximanProducts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (request()->user()->cart->sum('pivot.quantity') + $value) <= 4;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your cart can contain a maximum of 4 items.';
    }
}
