<?php

namespace App\Http\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class FatoorahServices
{
    private $base_url;
    private $headers;

    public function __construct()
    {
        $this->base_url = env('fatoorah_base_url');
        $this->headers = [
            'Content-Type'=>'application/json',
            'authorization'=>'Bearer ' . env('fatoorah_token'),
        ];
    }
    
    private function buildRequest($url , $method , $data=[])
    {
        $request_client = new Client();
        $request = new Request($method , $this->base_url . $url , $this->headers);
        
        $response = $request_client->send($request , ['json'=>$data]);
        $response = json_decode($response->getBody() , true);
        return $response;
    }

    protected function sednPayment($data)
    {
        $response = $this->buildRequest('/v2/SendPayment' , 'POST' , $data);
        return $response;
    }

    protected function getPaymentStatus($data)
    {
        $response = $this->buildRequest('/v2/getPaymentStatus' , 'POST' , $data);
        return $response;
    }
}