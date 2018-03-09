<?php 

namespace Basiq\Services;

use Basiq\Entities\User;
use Basiq\Entities\Account;
use Basiq\Entities\Transaction;
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

    public function fetchAccounts($userId, $accountId = null, $connectionId = null)
    {
        $url = "/users/" . $userId . "/accounts";

        if ($accountId !== null) {
            $url .= "/". $accountId;
        }

        if ($connectionId !== null) {
            $url .= "?filter=connection.id.eq('" . $connectionId . "')";
        }

        $response = $this->session->apiClient->get($url, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        $body = ResponseParser::parse($response);

        if (isset($body["data"]) && is_array($body["data"])) {
            return array_map(function ($account) {
                return new Account($account);
            }, $body["data"]);
        } else {
            return new Account($body);
        }
    }

    public function fetchTransactions($userId, $transactionId = null, $connectionId = null)
    {
        $url = "/users/" . $userId . "/transactions";

        if ($transactionId !== null) {
            $url .= "/". $transactionId;
        }

        if ($connectionId !== null) {
            $url .= "?filter=connection.id.eq('" . $connectionId . "')";
        }

        $response = $this->session->apiClient->get($url, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        $body = ResponseParser::parse($response);

        if (isset($body["data"]) && is_array($body["data"])) {
            return array_map(function ($transaction) {
                var_dump($transaction);
                return new Transaction($transaction);
            }, $body["data"]);
        } else {
            return new Transaction($body);
        }
    }
}