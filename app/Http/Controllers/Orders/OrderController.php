<?php

namespace App\Http\Controllers\Orders;

use App\Cart\Cart;
use App\Events\Checkpayment\Checkpayment;
use App\Events\Order\OrderCreated;
use App\Events\Users\CheckUserSubscription;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderStoreRequest;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\Logs\Logs;
use App\Models\Loyalty\Loyalty;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use SmoDav\Mpesa\Laravel\Facades\STK;
use Illuminate\Support\Arr;
use App\Models\Mpesa\Mpesa;
use App\Models\Order;
use App\Models\Ordernumbers\Ordernumbers;
use App\Models\Promocode\Promocode;
use App\Models\ShippingMethod;
use App\Mpesa\STKPush;
use App\Pesaswap\Cardpayment;
use App\Pesaswap\CheckCardPaymentStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;

class OrderController extends Controller
{
    protected $cart;

    public function __construct()
    {
        $this->middleware(['auth:api,admin']);
        $this->middleware(['cart.sync', 'cart.isnotempty'])->only('store');
    }

    public function status()
    {
        $orders = Order::where('status', 'pending')->whereNotNull('transaction_external_id')->get();
        if ($orders != null) {
            foreach ($orders as $value) {
                event(new Checkpayment($value));
            }
        }
    }

    public function checkpoints()
    {
        $orders = Order::where('status', 'completed')->whereNull('points_status')->get();
        if ($orders != null) {
            foreach ($orders as $value) {
                event(new CheckUserSubscription($value));
            }
        }
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with([
                'products',
                'products.stock',
                'products.type',
                'products.product',
                'products.product.variations',
                'products.product.variations.stock',
                'address',
                'shippingMethod'
            ])
            ->latest()
            ->paginate(30);

        return OrderResource::collection($orders);
    }

    public function allorders(Request $request)
    {
        $orders = Order::with([
                'products',
                'products.stock',
                'products.type',
                'products.product',
                'products.product.variations',
                'products.product.variations.stock',
                'address',
                'user',
                'shippingMethod'
            ])
            ->latest()
            ->paginate(30);

        return OrderResource::collection($orders);
    }

    public function annualsales(Request $request)
    {
        $Year = Carbon::now()->format('Y');
        $PYear = $Year-1;
        $count = 12;

        for ($i=1; $i <= $count; $i++) {
            $cyear = $Year.'-'.$i;
            $yyear = $PYear.'-'.$i;
            $cmonthname = Carbon::parse($cyear)->format('M');
            $pmonthname = Carbon::parse($yyear)->format('M');

            $issue = DB::select("SELECT SUM(subtotal) AS 'total', '$cmonthname' AS 'month' FROM orders WHERE DATE_FORMAT(created_at, '%Y-%c') = '$cyear' AND `status` = 'completed'");

            $previousyear = DB::select("SELECT SUM(subtotal) AS 'total', '$pmonthname' AS 'month' FROM orders WHERE DATE_FORMAT(created_at, '%Y-%c') = '$yyear' AND `status` = 'completed'");

            $curr[] = $issue[0];
            $prev[] = $previousyear[0];
        }
        return response()->json([
            "curr" => $curr,
            "prev" => $prev,
            "y" => $Year,
            "p" => $PYear,
        ], 200);
    }

    public function weeklysales(Request $request)
    {
        $postedDate = (!empty($request->date) ? Carbon::parse($request->date)->format('Y-m-d') : Carbon::today()->format('Y-m-d'));
        $bookings = Order::week($postedDate)->get()->toArray();
        return response()->json(['data' => $bookings], 200);
    }

    public function store(OrderStoreRequest $request, Cart $cart, STKPush $STKPush, Cardpayment $cardpayment)
    {
        $order = $this->createOrder($request, $cart, $STKPush, $cardpayment);
        if ($order->experience_profile_id) {
            return $order;
        }else{
            $order->products()->sync($cart->products()->forSyncing());
            event(new OrderCreated($order));
            return new OrderResource($order);
        }
    }

    protected function meta(Cart $cart, Request $request)
    {
        return [
            'empty' => $cart->isEmpty(),
            'subtotal' => $cart->subtotal(),
            'total' => $cart->withShipping($request->shipping_method_id)->total(),
            'changed' => $cart->hasChanged(),
        ];
    }

    protected function retrypayment(Request $request, STKPush $STKPush)
    {
        $issue = Order::findOrFail(intval($request->id));

        $payments = PaymentMethod::findOrFail(intval($issue->payment_method_id));
        $str1 = $request->total;
        $x = str_replace( ',', '', $str1);
        if( is_numeric($x))
        {
            $response = $STKPush->sendRequest(intval($x), $payments->provider_id);
            Logs::create([
                'user_id'   => $request->user()->id,
                'mpesalog'  => $response,
            ]);

            $data = json_decode($response);

            if ($data->ResponseCode == 0) {
                $issue->merchantrequestid = $data->MerchantRequestID;
                $issue->checkoutrequestid = $data->CheckoutRequestID;
                $issue->save();
            }else{
                \Log::info('Wrong code');
            }
        }
    }

    protected function createOrder(Request $request, Cart $cart, STKPush $STKPush, Cardpayment $cardpayment)
    {
        $payments = PaymentMethod::findOrFail(intval($request->payment_method_id));
        $shipcost = ShippingMethod::findOrFail(intval($request->shipping_method_id));
        $transaction_external_id = (string) Str::uuid();

        $data = Promocode::where('promocode', $request->voucher)->first();
        if ($data != null) {
            $voucher = $data->voucheprice;
        }else{
            $voucher = 0;
        }

        $selectedShipping = collect(collect($shipcost->price)->first());

        if (intval($selectedShipping->first()) <= 0) {
            $shippingcost = 0;
            $amount = intval($cart->subtotal()) - $voucher;
        }else{
            $shippingcost = intval($selectedShipping->first());
            $before = intval($cart->subtotal()) + $shippingcost;
            $amount = $before - $voucher;
        }

        if ($request->paywithcard == true) {
            $request->validate([
                'expiry_date' => 'required|digits:6',
                'card_security_code' => 'required|digits_between:3,4',
                'card_number' => 'required|digits_between:14,16'
            ]);

            $response = $cardpayment->Cardpayment($amount, $request->expiry_date, $request->card_security_code, $request->card_number, $transaction_external_id, $request->user()->external_id);
            // dd($response);
            Logs::create([
                'user_id'   => $request->user()->id,
                'cardlog'   => $response->toJson(),
            ]);

            if ($response) {
                return $request->user()->orders()->create(
                    array_merge($request->only(['address_id', 'shipping_method_id', 'payment_method_id']), ['subtotal' => $amount], ['transaction_external_id' => $transaction_external_id], ['voucher' => $voucher])
                );
            }
        }else {
            if ($payments->card_type == 'M-Pesa') {
                $orderNumber = Ordernumbers::ordernumber();
                $response = $STKPush->sendRequest($amount, $payments->provider_id, $orderNumber);
                
                Logs::create([
                    'user_id'   => $request->user()->id,
                    'mpesalog'  => $response,
                ]);

                $data = json_decode($response);
    
                if ($data->ResponseCode == 0) {
                    return $request->user()->orders()->create(
                        array_merge($request->only(['address_id', 'shipping_method_id', 'payment_method_id']), ['subtotal' => $amount], ['merchantrequestid' => $data->MerchantRequestID], ['checkoutrequestid' => $payments->provider_id], ['voucher' => $voucher], ['order_number' => $orderNumber])
                    );
                }
            }
        }

        // if ($payments->card_type == 'M-Pesa') {

        //     $response = $STKPush->sendRequest($amount, $payments->provider_id);

        //     $data = json_decode($response);

        //     if ($data->ResponseCode == 0) {
        //         return $request->user()->orders()->create(
        //             array_merge($request->only(['address_id', 'shipping_method_id', 'payment_method_id']), ['subtotal' => $amount], ['merchantrequestid' => $data->MerchantRequestID], ['checkoutrequestid' => $data->CheckoutRequestID], ['voucher' => $voucher])
        //         );
        //     }else{
        //         \Log::info('Wrong code');
        //     }
        // }
        // else{
        //     $request->validate([
        //         'expiry_date' => 'required|digits:6',
        //         'card_security_code' => 'required|digits_between:3,4',
        //         'card_number' => 'required|digits_between:14,16'
        //     ]);

        //     $response = $cardpayment->Cardpayment($amount, $request->expiry_date, $request->card_security_code, $request->card_number, $transaction_external_id, $request->user()->external_id);
        //     // dd($response);
        //     if ($response) {
        //         return $request->user()->orders()->create(
        //             array_merge($request->only(['address_id', 'shipping_method_id', 'payment_method_id']), ['subtotal' => $amount], ['transaction_external_id' => $transaction_external_id], ['voucher' => $voucher])
        //         );
        //     }
        // }
    }

    protected function makeOrder(Request $request, Cart $cart, STKPush $STKPush)
    {
        return $request->user()->orders()->create(
            array_merge($request->only(['address_id', 'shipping_method_id', 'payment_method_id']), ['subtotal' => $cart->subtotal()->amount()], ['merchantrequestid' => $request->payerID], ['checkoutrequestid' => $request->paymentID])
        );
    }

    public function execute_payment(OrderStoreRequest $request, Cart $cart, STKPush $STKPush)
    {
        $order = $this->makeOrder($request, $cart, $STKPush);
        $order->products()->sync($cart->products()->forSyncing());

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AVXJk2CUUgZ1JinSkJb6DqKMpd7Ded5ZxsGeC7mMXHLV7iL8b2QcBTKbkrDlmvg0VgwkMs51PQ8vz9Xi',     // ClientID
                'EBnWiq3vi8eg4PYSM4ERYps3AGPVzIlUS8HEkfGHuaYRGBHZ7MHKnSGinjri9JooyRKHy437TcmR5wFx'      // ClientSecret
            )
        );
    
        $paymentId = $request->paymentID;
        $payment = Payment::get($paymentId, $apiContext);
    
        $execution = new PaymentExecution();
        $execution->setPayerId($request->payerID);
    
        // $transaction = new Transaction();
        // $amount = new Amount();
        // $details = new Details();
    
        // $details->setShipping(2.2)
        //     ->setTax(1.3)
        //     ->setSubtotal(17.50);
    
        // $amount->setCurrency('USD');
        // $amount->setTotal(21);
        // $amount->setDetails($details);
        // $transaction->setAmount($amount);
    
        // $execution->addTransaction($transaction);
    
        try {
            $result = $payment->execute($execution, $apiContext);
        } catch (Exception $ex) {
            echo $ex;
            exit(1);
        }

        $order = Order::where('merchantrequestid',$request->payerID)->where('checkoutrequestid',$request->paymentID)->first();

        event(new OrderCreated($order));

        $order->status = 'completed';
        $order->save();
        $data = json_decode(collect(collect(collect($order->subtotal)->first())));

        $points = floor(floatval(substr($data->amount, 0, -2))/100);

        Loyalty::create([
            'user_id'       => $order->user_id,
            'earnedPoints'  => $points,
            'order_id'      => $order->id,
            'state'         => 1,
        ]);

        // event(new OrderTransactionSuccessfull($user, $order, $mpesa));
    
        return $result;
    }
}
