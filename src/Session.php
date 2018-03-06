<?php

namespace Basiq;

use GuzzleHttp\Client;

class Session {

    private $apiKey;

    private $accessToken;

    public $apiClient;

    private $sessionTimestamp;

    private $tokenValidity;    

    public function __construct($apiKey) {
        $this->apiClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://au-api.basiq.io',
            // You can set any number of default request options.
            "headers" => [
                "Content-Type" => "application/json"
            ],
            'timeout'  => 12.0,
        ]);

        $this->tokenValidity = 3600;
        $this->apiKey = $apiKey;
        $this->accessToken = $this->getAccessToken();
    }
 
    public function getAccessToken()
    {
        if (time() - $this->sessionTimestamp < $this->tokenValidity) {
            return $this->accessToken;
        }

        $response = $this->apiClient->post("/oauth2/token", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Basic ".$this->apiKey,
                "basiq-version" => "1.0"
            ]
        ]);

        // ADD LOGIC TO CHECK FOR VALID RESPONSE

        $this->sessionTimestamp = time();

        $body = json_decode($response->getBody()->getContents(), true);
        $this->tokenValidity = $body["expires_in"];

        return $body["access_token"];
    }

    public function getInstitutions()
    {
        $response = $this->apiClient->get("/institutions", [
            "headers" => [
                "Authorization" => "Bearer ".$this->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getInstitution($id)
    {
        $response = $this->apiClient->get("/institutions/" . $id, [
            "headers" => [
                "Authorization" => "Bearer ".$this->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}