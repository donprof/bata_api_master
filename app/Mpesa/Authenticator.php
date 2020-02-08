<?php

namespace App\Mpesa;

class Authenticator
{
         
     public function __construct()
     {
          $this->consumer_key        = "QOQ3DYfK11X40yKyziCmEyMQVS4ujp7E";
          $this->secret_key          = "fs5a2MYJ3ZOib8S0";
          $this->lnmo_passkey   = "6f2b25610bfa69797e9f136359ebaa69d87be0f9646cc6ffb50446deb541573f";
          $this->oauth_endpoint_url  = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
          // $this->lnmo_till      = '733037';
          $this->store_number = '733037';
          $this->till_number = '733043';
     }

     public function getAccessToken()
     {

          $credentials = base64_encode($this->consumer_key . ":" . $this->secret_key);

          $curl = curl_init();

          curl_setopt($curl, CURLOPT_URL, $this->oauth_endpoint_url);

          curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); 

          curl_setopt($curl, CURLOPT_HEADER, true);

          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_VERBOSE, 1);

          $curl_response = curl_exec($curl);

          $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

          $body = substr($curl_response, $header_size);

          curl_close($curl);

          $jsonObject = json_decode($body);

          return $jsonObject->access_token;
     }
}