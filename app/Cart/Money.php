<?php

namespace App\Cart;

use NumberFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;

class Money
{
    protected $money;

    public function __construct($value)
    {
        // $this->money = new BaseMoney($value, new Currency('KES'));
        $this->money = $value;
    }

    public function amount()
    {
        return $this->money;
        // return $this->money->getAmount();
    }

    public function formatted()
    {
        // $formatter = new IntlMoneyFormatter(
        //     new NumberFormatter('en_KE', NumberFormatter::DECIMAL),
        //     new ISOCurrencies()
        // );

        // return $formatter->format($this->money);
        return $this->money;
    }

    public function add(Money $money)
    {
        // $this->money = $this->money->add($money->instance());
        $this->money = $this->money + $money->instance();

        return $this;
    }

    public function instance()
    {
        return $this->money;
    }
}