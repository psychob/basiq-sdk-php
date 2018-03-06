<?php

namespace Basiq\Entities;

class Job extends Entity {

    private $service;
    
    public $id;
    public $created;
    public $updated;
    public $steps;
    
    public function __construct($service, $data)
    {
        $this->id = $data["id"];
        $this->created = isset($data["created"]) ? new \DateTime($data["created"]) : null;
        $this->updated = isset($data["updated"]) ? new \DateTime($data["updated"]) : null;
        $this->steps = isset($data["steps"]) ? (array)$data["steps"] : [];
    }
}