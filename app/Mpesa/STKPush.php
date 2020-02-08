<?php
namespace App\Mpesa;

class STKPush {

     public function __construct()
     {
          $this->access_token       = (new Authenticator)->getAccessToken();
          $this->mpesa_stkpush_endpoint_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
          $this->timestamp          = date('Ymdhis');
          $this->lnmo_authorization = base64_encode( 
               (new Authenticator)->store_number . 
               (new Authenticator)->lnmo_passkey . 
               date('Ymdhis')
          );
     }
     
     public function sendRequest(int $amount, int $phone_number, $orderNumber)
     {

          $curl_post_data = array(
               'BusinessShortCode' => (new Authenticator)->store_number,
               'Password'          => $this->lnmo_authorization,
               'Timestamp'         => $this->timestamp,
               'TransactionType'   => "CustomerBuyGoodsOnline",
               'Amount'            => (string) $amount,
               'PartyA'            => (string) $phone_number,
               'PartyB'            => (new Authenticator)->till_number,
               'PhoneNumber'       => (string) $phone_number,
               'CallBackURL'       => config('app.url') . "/api/validation?secret=U1Pv9Xy/PjXS1J6UcsVLRWUi2yEHWOAwv/pVO6na2P3WcVUrcyAgteWghiV0P2XChAVv8HfUV0SKguZQEcP60nZdFcbrdzM8d03dWLM1tuhA3ViMTQpOM3xYh4TrBaHrZ65483rC7t",
               'AccountReference'  => "Bata Online Shop",
               'TransactionDesc'   => "Product purchase"
             );
             
          $data_string = json_encode($curl_post_data);
          
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $this->mpesa_stkpush_endpoint_url);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization:Bearer {$this->access_token}"));
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
          
          $curl_response = curl_exec($curl);
          
          return $curl_response;
     }

}