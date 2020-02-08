<?php

namespace App\Loyaltypoints;

class PointsAuthenticator
{
         
     public function __construct()
     {
          $this->points_endpoint_url         = 'https://eu.api.capillarytech.com/v1.1/customer/get';
          $this->search_endpoint_url         = 'https://eu.api.capillarytech.com/v1.1/customer/search';
          $this->addpoints_endpoint_url      = 'https://eu.api.capillarytech.com/v1.1/transaction/add?format=json';
          $this->username = 'batakenya.bataecomm1';
          $this->password = '3619a0ece018b797c38b20972d28fad0';
          // $this->username = 'batakenya.admin1';
          // $this->password = '3619a0ece018b797c38b20972d28fad0';
     }
}