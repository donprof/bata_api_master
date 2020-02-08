<?php
namespace App\Pesaswap;

class CheckCardPaymentStatus {

     public function __construct()
     {
          $this->consumer_key                          = '34Fp5PkL8P';
          $this->api_key                               = 'fkzYzZnvkoDX5nVySH8xJwxbv';
          $this->card_transaction_endpoint_url         = "https://www.pesaswap.com/api/get-transaction-record";
     }
     
     public function CheckCardPaymentStatus($transaction_external_id)
     {
          $curl_post_data = array(
               'consumer_key'           => $this->consumer_key,
               'api_key'                => $this->api_key,
               'transaction_external_id'=> $transaction_external_id
          );

          $curl = curl_init();
          
          $data = http_build_query($curl_post_data);

          $getUrl = $this->card_transaction_endpoint_url."?".$data;

          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

          curl_setopt($curl, CURLOPT_URL, $getUrl);

          curl_setopt($curl, CURLOPT_TIMEOUT, 80);

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));

          curl_setopt($curl, CURLOPT_HEADER, true);

          curl_setopt($curl, CURLOPT_VERBOSE, 1);

          $curl_response = curl_exec($curl);

          $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

          $body = substr($curl_response, $header_size);

          curl_close($curl);
          
          $jsonObject = json_decode($body);

          return $jsonObject;

     }

}