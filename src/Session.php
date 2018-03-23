<?php

namespace Basiq;

use GuzzleHttp\Client;
use Basiq\Utilities\ResponseParser;
use Basiq\Services\UserService;

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
            'timeout'  => 30.0,
            "http_errors" => false
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

        $body = ResponseParser::parse($response);
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

        return ResponseParser::parse($response);
    }

    public function getInstitution($id)
    {
        $response = $this->apiClient->get("/institutions/" . $id, [
            "headers" => [
                "Authorization" => "Bearer ".$this->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        return ResponseParser::parse($response);
    }

    public function getUser($id)
    {
        return (new UserService($this))->get($id);
    }

    public function forUser($id)
    {
        return (new UserService($this))->forUser($id);
    }

}