<?php

namespace Fleek;

class Domain extends BaseEntity
{
    public $name;
    public $uuid;
    public $title;
    public $description;
    public $memory;
    public $currentMemory;
    public $vcpu;
    public $os;
    public $devices = [];

    protected $entityName = 'domain';
    protected $entityAttributes = [];

    /**
     * @param string domain type (hvm, linux)
     */
    public function __construct($type)
    {
        $this->entityAttributes = [
            'type' => $type
        ];
    }

}