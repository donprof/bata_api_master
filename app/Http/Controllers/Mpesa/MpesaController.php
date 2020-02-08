<?php

namespace App\Http\Controllers\Mpesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use App\Http\Resources\OrderResource;
use App\Models\Mpesa\Mpesa;
use App\Events\Order\OrderPaid;
use App\Events\Users\OrderTransactionSuccessfull;
use App\Models\Logs\Logs;
use App\Models\Loyalty\Loyalty;
use App\Models\productVariationOrder\productVariationOrder;
use App\Models\ShippingMethod;
use App\Models\User;
use App\Mpesa\Registrar;
use App\Mpesa\STKPush;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MpesaController extends Controller
{
    public function mpesaupdate(Request $request)
    {
        // array (
        //     'TransactionType' => 'Customer Merchant Payment',
        //     'TransID' => 'OB61V7KIKZ',
        //     'TransTime' => '20200206095339',
        //     'TransAmount' => '1.00',
        //     'BusinessShortCode' => '733037',
        //     'BillRefNumber' => NULL,
        //     'InvoiceNumber' => NULL,
        //     'OrgAccountBalance' => '4.00',
        //     'ThirdPartyTransID' => NULL,
        //     'MSISDN' => '254713472151',
        //     'FirstName' => 'EMMANUEL',
        //     'MiddleName' => 'KARURU',
        //     'LastName' => 'KARANJA',
        //     'secret' => 'U1Pv9Xy/PjXS1J6UcsVLRWUi2yEHWOAwv/pVO6na2P3WcVUrcyAgteWghiV0P2XChAVv8HfUV0SKguZQEcP60nZdFcbrdzM8d03dWLM1tuhA3ViMTQpOM3xYh4TrBaHrZ65483rC7t',
        // )
        \Log::info($request["secret"]);
        if ($request["secret"]) {
            \Log::info($request["MSISDN"]);

            $order = Order::where('checkoutrequestid',$request["MSISDN"])->first();

            \Log::info($order);

            $shipcost = ShippingMethod::findOrFail(floatval($order->shipping_method_id));
            
            $shippingcost = $shipcost->price;
            
            $costWithoutShipping = $order->subtotal;
            
            $finalCost = $costWithoutShipping + $shippingcost;
            
            if ((int)$request["TransAmount"] == $finalCost) {
                $user = User::findOrFail(intval($order->user_id));
                if ($user) {
                    event(new OrderPaid($order));
                    event(new OrderTransactionSuccessfull($user, $order, $shippingcost));
                }
            }else{
                $order->status = 'payment_failed';
                $order->save();
            }
        }

    }

    public function index(Request $request, Registrar $registrar)
    {
        return collect($registrar->registerUrl())->toJson();
    }

    public function show(Request $request, $id)
    {
        $orders = Order::with(['paymentMethod','shippingMethod','address'])->where('id', intval($id))->first();
        return $orders;

        return OrderResource::collection($orders);
    }

    public function getspec(Request $request)
    {
        return null;
    }

}
