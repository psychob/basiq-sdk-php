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
    
    private $apiVersion;

    public function __construct($apiKey, $apiVersion="1.0") {
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
        $this->apiVersion = $apiVersion;
        $this->accessToken = $this->getAccessToken();
    }

    public function getApiVersion() {
        return $this->apiVersion;
    }
 
    public function getAccessToken()
    {
        if (time() - $this->sessionTimestamp < $this->tokenValidity) {
            return $this->accessToken;
        }

        if ($this->apiVersion != "2.0" && $this->apiVersion != "1.0") {
            error_log("Given version isn't supported");
        }

        $response = $this->apiClient->post("/token", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Basic ".$this->apiKey,
                "basiq-version" => $this->apiVersion
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
                "Authorization" => "Bearer ".$this->getAccessToken()
            ]
        ]);

        return ResponseParser::parse($response);
    }

    public function getInstitution($id)
    {
        $response = $this->apiClient->get("/institutions/" . $id, [
            "headers" => [
                "Authorization" => "Bearer ".$this->getAccessToken()
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
