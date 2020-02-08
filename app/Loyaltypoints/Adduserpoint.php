<?php
namespace App\Loyaltypoints;

class Adduserpoint {

     public function __construct()
     {
          $this->addpoints_endpoint_url =  (new PointsAuthenticator)->addpoints_endpoint_url;
          $this->authorization          = base64_encode((new PointsAuthenticator)->username.':'.(new PointsAuthenticator)->password);
     }
     
     public function Adduserpoint($order, $user)
     {
          $curl_post_data = "{\"root\": {\"transaction\": [{\"bill_client_id\": \"\",\"type\": \"regular\",\"number\": \"$order->order_number\",\"amount\": \"$order->subtotal\",\"currency_code\": \"KES\",\"billing_time\": \"$order->created_at\",\"gross_amount\": \"$order->subtotal\",\"delivery_status\": \"Pending\",\"shipping_source_till_code\": \"\",\"source\": \"ECOMMERCE\",\"outlier_status\": \"NORMAL\",\"discount\": \"0\",\"customer\": {\"mobile\": \"$user->phone\"},\"payment_details\": {\"payment\": [{\"mode\": \"CASH\",\"value\": \"$order->subtotal\"}]}}]}}";
          
          $headers = array(
               'Content-Type:application/json',
               'Authorization: Basic '. $this->authorization
          );
          
          $curl = curl_init();

          curl_setopt($curl, CURLOPT_URL, $this->addpoints_endpoint_url);

          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_POST, true);

          curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

          $curl_response = curl_exec($curl);

          curl_close($curl);

          $jsonObject = json_decode($curl_response);

          return $jsonObject;
     }

}