<?php

namespace Fleek\Entity;

class Graphics extends BaseEntity
{
    protected $entityName = 'graphics';
    protected $entityAttributes = [];

    /**
     * Construct a new graphic device
     *
     * @param string device type (vnc, rdp, etc.)
     * @param int device port
     */
    public function __construct($type, $port)
    {
        $this->entityAttributes = [
            'type' => $type,
            'port' => $port
        ];
    }


}