<?php

namespace Basiq\Entities;

use Basiq\Services\ConnectionService;

class Connection extends Entity {

    /** @var ConnectionService */
    private $service;
    private $user;

    public $status;
    public $lastUsed;
    public $institution;

    /** @var Account[] */
    public $accounts;
    
    public function __construct(ConnectionService $service, $user, $data)
    {
        $this->id = $data["id"];
        $this->status = isset($data["status"]) ? (string) $data["status"] : null;
        $this->lastUsed = isset($data["lastUsed"]) ? new \DateTime($data["lastUsed"]) : null;
        $this->institution = isset($data["institution"]) ? $data["institution"] : null;
        $this->accounts = isset($data["accounts"]) ? array_map(function ($value) {
            return new Account($value);
        }, (array)$data["accounts"]) : [];

        $this->user = $user;
        $this->service = $service;
    }

    public function update($data)
    {
        return $this->service->update($this->id, $data);
    }

    public function refresh()
    {
        return $this->service->refresh($this->id);
    }

    public function delete()
    {
        return $this->service->delete($this->id);
    }
}
