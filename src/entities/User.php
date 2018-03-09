<?php

namespace Basiq\Entities;

use \Basiq\Services\UserService;
use \Basiq\Services\ConnectionService;

class User extends Entity {

    public $email;
    public $mobile;
    public $connections;

    private $connectionService;
    private $userService;

    public function __construct(UserService $service, $data)
    {
        $this->id = $data["id"];
        $this->email = isset($data["email"]) ? (string)$data["email"] : null;
        $this->mobile = isset($data["mobile"]) ? (string)$data["mobile"] : null;
        $this->connections = isset($data["connections"]) ? (array)$data["connections"] : [];

        $this->userService = $service;
        $this->connectionService = new ConnectionService($service->session, $this);
    }

    public function update($data) 
    {
        return $this->userService->update($this->id, $data);
    }

    public function delete()
    {
        return $this->userService->delete($this->id);
    }

    /**
     * @param $institutionId
     * @param $userId
     * @param $password
     * @param null $securityCode
     * @return Job|void
     */
    public function createConnection($institutionId, $userId, $password, $securityCode = null)
    {
        $data = ["institutionId" => $institutionId, "loginId" => $userId, "password" => $password];
        if ($securityCode) {
            $data["securityCode"] = $securityCode;
        }
        
        return $this->connectionService->create($data);
    }

    public function getAllConnections()
    {
        if ($this->connections && count($this->connections) > 0) {
            return array_map(function ($value) {
                return new Connection($this->connectionService, $this, $value);
            }, $this->connections);
        }

        return $this->userService->getAllConnections($this->connectionService, $this);
    }

    public function fetchAccounts($connectionId = null)
    {
        return $this->userService->fetchAccounts($this->id, null, $connectionId);
    }

    public function fetchAccount($accountId)
    {
        return $this->userService->fetchAccounts($this->id, $accountId);
    }

    public function fetchTransactions($connectionId = null)
    {
        return $this->userService->fetchTransactions($this->id, null, $connectionId);
    }

    public function fetchTransaction($transactionId)
    {
        return $this->userService->fetchTransactions($this->id, $transactionId);
    }

    public function refreshAllConnections()
    {
        return $this->userService->refreshAllConnections($this->id);
    }
}