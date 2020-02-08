<?php
namespace App\Pesaswap;

class Cardpayment {

     public function __construct()
     {
          $this->consumer_key                          = '34Fp5PkL8P';
          $this->api_key                               = 'fkzYzZnvkoDX5nVySH8xJwxbv';
          $this->currency                              = 'KES';
          $this->pesaswap_card_payment_endpoint_url    = 'https://www.pesaswap.com/api/pesaswap/credit-card-payment';
     }
     
     public function Cardpayment(int $amount, int $expiry_date, int $card_security_code, int $card_number, $transaction_external_id, $customer_external_id)
     {
          $curl_post_data = array(
               'consumer_key'           => $this->consumer_key,
               'api_key'                => $this->api_key,
               'currency'               => $this->currency,
               'amount'                 => $amount,
               'expiry_date'            => $expiry_date,
               'card_security_code'     => $card_security_code,
               'card_number'            => $card_number,
               'transaction_external_id'=> $transaction_external_id,
               'customer_external_id'   => $customer_external_id
          );
          
          $curl = curl_init();

          curl_setopt($curl, CURLOPT_URL, $this->pesaswap_card_payment_endpoint_url);

          curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept:application/json'));

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_POST, true);

          curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

          $curl_response = curl_exec($curl);

          curl_close($curl);

          return $curl_response;
     }

}