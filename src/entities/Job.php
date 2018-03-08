<?php

namespace Basiq\Entities;

use Basiq\Services\ConnectionService;

class Job extends Entity {

    private $service;
    
    public $id;
    public $created;
    public $updated;
    public $steps;
    public $links;

    public function __construct(ConnectionService $service, $data)
    {
        $this->id = $data["id"];
        $this->created = isset($data["created"]) ? new \DateTime($data["created"]) : null;
        $this->updated = isset($data["updated"]) ? new \DateTime($data["updated"]) : null;
        $this->steps = isset($data["steps"]) ? (array)$data["steps"] : [];
        $this->links = isset($data["links"]) ? $data["links"] : [];

        $this->service = $service;
    }

    public function getConnectionId($url)
    {
        return substr($url, strrpos($url, "/") + 1);
    }

    public function waitForCredentials($interval, $timeout, $start = 0)
    {
        if ($start === 0) {
            $start = time();
        }
        if (time() - $start > $timeout) {
            return null;
        }


        $job = $this->service->getJob($this->id);

        for ($i = 0; $i < count($job->steps); $i++) {
            $step = $job->steps[$i];
            if ($step["title"] === "verify-credentials") {
                if ($step["status"] === "success") {
                    return $this->service->get($this->getConnectionId($job->links["source"]));
                }
                if ($step["status"] === "failed") {
                    return null;
                }
            }
            $i++;
        }

        sleep($interval / 1000);

        return $this->waitForCredentials($interval, $timeout, $start);
    }
}