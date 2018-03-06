<?php 

namespace Basiq\Services;

use Basiq\Entities\Connection;
use Basiq\Entities\Job;

class ConnectionService extends Service {

    public function __construct($session, $user) 
    {
        $this->session = $session;
        $this->user = $user;
    }

    public function create($data = []) {
        if (!isset($data["institutionId"]) || !isset($data["loginId"]) || !isset($data["password"])) {
            throw new \InvalidArgumentException("Invalid parameters provided");
        }

        $data = array_filter($data, function ($key) {
            return $key === "institutionId" || $key === "loginId" || $key === "password" || $key === "securityCode";
        }, ARRAY_FILTER_USE_KEY);

        $data["institution"] = [
            "id" => $data["institutionId"]
        ];
        unset($data["institutionId"]);

        try {
            $response = $this->session->apiClient->post("users/" . $this->user->id . "/connections", [
                "headers" => [
                    "Content-type" => "application/json",
                    "Authorization" => "Bearer ".$this->session->getAccessToken(),
                    "basiq-version" => "1.0"
                ],
                "json" => $data
            ]);
        } catch (\Exception $err) {
            return var_dump($err->getResponse()->getBody()->getContents());
        }
        $body = json_decode($response->getBody()->getContents(), true);

        return (new Job($this, $body));
    }

    public function forConnection($id) {
        return (new Connection($this, [
            "id" => $id
        ]));
    }
}