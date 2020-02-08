<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Order\OrderCreated' => [
            // 'App\Listeners\Order\ProcessPayment',
            'App\Listeners\Order\EmptyCart',
            'App\Listeners\Order\Updateordernumber',
        ],

        'App\Events\Checkpayment\Checkpayment' => [
            'App\Listeners\Checkpayment\CheckpaymentListener',
        ],
        
        'App\Events\Order\OrderPaymentFailed' => [
            'App\Listeners\Order\MarkOrderPaymentFailed'
        ],

        'App\Events\Order\OrderPaid' => [
            'App\Listeners\Order\CreateTransaction',
            'App\Listeners\Order\MarkOrderProcessing'
        ],

        'App\Events\Users\PasswordChanged' => [
            'App\Listeners\Users\UsersListener',
        ],

        'App\Events\Users\UserPesaswapAccount' => [
            'App\Listeners\Users\UserPesaswapAccountListener',
        ],

        'App\Events\Users\CheckUserSubscription' => [
            'App\Listeners\Users\CheckUSerSubscriptionListender',
        ],

        'App\Events\Users\OrderTransactionSuccessfull' => [
            'App\Listeners\Users\UsersTansaction',
        ],

        'App\Events\Imageupload' => [
            'App\Listeners\ImageUploadListener',
        ],
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
