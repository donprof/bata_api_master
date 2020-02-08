<?php

namespace App\Http\Controllers\PaymentMethods;

use App\Cart\Payments\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethods\PaymentMethodStoreRequest;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function __construct(Gateway $gateway)
    {
        $this->middleware(['auth:api,admin']);
        $this->gateway = $gateway;
    }
    
    public function index(Request $request)
    {
        return PaymentMethodResource::collection(
            $request->user()->paymentMethods
        );
    }

    public function store(PaymentMethodStoreRequest $request)
    {
        if ($request->mpesa) {
            $request->validate([
                'phonenumber' => 'required|numeric',
                'name' => 'required|min:3',
            ]);
            // return ($this->gateway->withUser($request->user())->createCustomer());
            $card = PaymentMethod::create([
                'user_id'   => $request->user()->id,
                'card_type' => "M-Pesa",
                'last_four' => substr($request->phonenumber, -4),
                'provider_id'=> $request->phonenumber,
                'default'=> 1
            ]);
        }else{
            $card = PaymentMethod::create([
                'user_id'   => $request->user()->id,
                'card_type' => $request->name,
                'last_four' => substr($request->phonenumber, -4),
                'provider_id'=> $request->phonenumber,
                'default'=> 1
            ]);
            // $card = $this->gateway->withUser($request->user())
            //     ->createCustomer()
            //     ->addCard($request->token);
        }

        return new PaymentMethodResource($card);
    }
}
