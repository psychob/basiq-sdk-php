<?php 

namespace Basiq\Services;

use Basiq\Entities\User;
use Basiq\Entities\Job;
use Basiq\Entities\Account;
use Basiq\Entities\Transaction;
use Basiq\Entities\TransactionList;
use Basiq\Entities\Connection;
use Basiq\Utilities\ResponseParser;
use Basiq\Utilities\FilterBuilder;

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

    public function fetchAccounts($userId, $accountId = null, FilterBuilder $filter = null)
    {
        $url = "/users/" . $userId . "/accounts";

        if ($accountId !== null) {
            $url .= "/". $accountId;
        }

        if ($filter !== null) {
            $url .= "?" . $filter->getFilter();
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

    public function fetchTransactions($userId, $transactionId = null, $filter = null)
    {
        $url = "/users/" . $userId . "/transactions";

        if ($transactionId !== null) {
            $url .= "/". $transactionId;
        }

        if ($filter !== null) {
            $url .= "?" . $filter->getFilter();
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
            return new TransactionList($body, $this->session);
        } else {
            return new Transaction($body);
        }
    }

    public function refreshAllConnections($userId)
    {
        $response = $this->session->apiClient->post("users/" . $userId . "/connections/refresh", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        $body = ResponseParser::parse($response);

        return array_map(function ($job) {
            return new Job($this, $job);
        }, $body["data"]);
    }

    public function getAllConnections($connectionService, $user, $filter)
    {
        $url = "users/" . $user->id . "/connections";

        if ($filter !== null) {
            $url .= "?" . $filter->getFilter();
        }

        $response = $this->session->apiClient->get($url, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer ".$this->session->getAccessToken(),
                "basiq-version" => "1.0"
            ]
        ]);

        $body = ResponseParser::parse($response);

        return array_map(function ($connection) use ($connectionService, $user) {
            return new Connection($connectionService, $user, $connection);
        }, $body["data"]);
    }
}