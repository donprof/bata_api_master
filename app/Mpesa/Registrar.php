<?php
namespace App\Mpesa;

class Registrar {

     public function __construct()
     {
          $this->mpesa_callback_registrar = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
          $this->access_token = (new Authenticator)->getAccessToken();
     }
     
     public function registerUrl()
     {
          $url = config('app.url') . "/api/validation?secret=U1Pv9Xy/PjXS1J6UcsVLRWUi2yEHWOAwv/pVO6na2P3WcVUrcyAgteWghiV0P2XChAVv8HfUV0SKguZQEcP60nZdFcbrdzM8d03dWLM1tu+hA3ViMTQpOM3xYh4T+rBaHrZ65483rC7t6/6qovxk3fawRzTD01xvoEsn5nQrqhynsbusQItk7MwZLVFSgZ9aXq3/DG3uSRB+XqL2jbHvQgd+xJ0vy6xGJazkRhQ0q8WvNH3/v8KTTIqNT6xANFx9F+6duRBEOHP3xwDqKdVRpJOiEnupT2ViYl+21WTJcaMQBjZ3MzK236AYsaozXGgOAXFEo15KC1EL1EMy6Hg49Q==";
     
          $curl_post_data = array(
               'ShortCode'         => (new Authenticator)->store_number,
               'ResponseType'      => 'Completed',
               'ConfirmationURL'   => $url,
               'ValidationURL'     => $url
          );
     
          $data_string = json_encode($curl_post_data);
     
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $this->mpesa_callback_registrar);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Authorization:Bearer {$this->access_token}"));
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
     
          $curl_response = curl_exec($curl);
     
          curl_close($curl);
     
          return json_decode($curl_response);
     }
}
