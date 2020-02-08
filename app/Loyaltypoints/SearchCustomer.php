<?php
namespace App\Loyaltypoints;

class SearchCustomer {

     public function __construct()
     {
          $this->search_endpoint_url    =  (new PointsAuthenticator)->search_endpoint_url;
          $this->authorization = base64_encode((new PointsAuthenticator)->username.':'.(new PointsAuthenticator)->password);
          $this->mlp = true;
     }
     
     public function SearchCustomer(int $phone_number, $email)
     {
          $headers = array(
               'Content-Type:application/json',
               'Accept:application/json',
               'Authorization: Basic '. $this->authorization
           );

          $curl = curl_init();
          
          $getUrl = $this->search_endpoint_url."?q=mobile:EQUALS:".$phone_number;

          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

          curl_setopt($curl, CURLOPT_URL, $getUrl);

          curl_setopt($curl, CURLOPT_TIMEOUT, 80);

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

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