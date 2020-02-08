<?php
namespace App\Pesaswap;

class NewPesaswapUser {

     public function __construct()
     {
          $this->consumer_key                          = '34Fp5PkL8P';
          $this->api_key                               = 'fkzYzZnvkoDX5nVySH8xJwxbv';
          $this->pesaswap_new_user_endpoint_url        = 'https://www.pesaswap.com/api/pesaswap/create/customer';
     }
     
     public function NewPesaswapUser($user)
     {
          $curl_post_data = array(
               'consumer_key' => $this->consumer_key,
               'api_key'      => $this->api_key,
               'firstname'    => $user->name,
               'lastname'     => $user->name,
               'email'        => $user->email,
               'phone'        => (int) $user->phone
          );
          
          $curl = curl_init();

          curl_setopt($curl, CURLOPT_URL, $this->pesaswap_new_user_endpoint_url);

          curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept:application/json'));

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_POST, true);

          curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

          $curl_response = curl_exec($curl);

          curl_close($curl);

          $jsonObject = json_decode($curl_response);

          return $jsonObject;
     }

}