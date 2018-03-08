<?php 

namespace Basiq\Services;

use Basiq\Entities\User;
use Basiq\Utilities\ResponseParser;

class UserService extends Service {

    public function create($data = []) {
        if (!isset($data["email"]) && !isset($data["mobile"])) {
            throw new \InvalidArgumentException("No valid parameters provided");
        }

        $data = array_filter($data, function ($key) {
            return $key === "email" || $key === "mobile";
        }, ARRAY_FILTER_USE_KEY);

        $response = $this->session->apiClient->post("/users", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ],
            "json" => $data
        ]);

        return (new User($this, ResponseParser::parse($response)));
    }

    public function forUser($id) {
        return (new User($this, [
            "id" => $id
        ]));
    }

    public function setEmail($email) {
        if (!isset($this->data)) {
            $this->data = [];
        }
        
        $this->data["email"] = $email;
    }

    public function setMobile($mobile) {
        if (!isset($this->data)) {
            $this->data = [];
        }
        
        $this->data["mobile"] = $mobile;
    }

    public function get($id) {
        $response = $this->session->apiClient->get("/users/" . $id, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        return (new User($this, ResponseParser::parse($response)));
    }

    public function update($id, $data) {
        if (!isset($id)) {
            throw new \InvalidArgumentException("No id provided");
        }

        if (!isset($data["email"]) && !isset($data["mobile"])) {
            throw new \InvalidArgumentException("No valid parameters for update provided");
        }

        $data = array_filter($data, function ($key) {
            return $key === "email" || $key === "mobile";
        }, ARRAY_FILTER_USE_KEY);

        $response = $this->session->apiClient->post("/users/" . $id, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ],
            "json" => $data
        ]);
        return (new User($this, ResponseParser::parse($response)));
    }

    public function delete($id) {
        if (!isset($id)) {
            throw new \InvalidArgumentException("No id provided");
        }

        $response = $this->session->apiClient->delete("/users/" . $id, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        return null;
    }
}