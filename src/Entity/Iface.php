<?php

namespace Fleek\Entity;

use Sabre\Xml\Writer;

class Iface extends BaseEntity
{
    public $source;
    public $mac;

    protected $entityName = 'interface';
    protected $entityAttributes = [];

    /**
     * Construct a new interface
     *
     * @param string interface type (network, user, bridge, etc.)
     */
    public function __construct($type)
    {
        $this->entityAttributes = [
            'type' => $type
        ];
    }

    /**
     * The xmlSerialize method is called during xml writing
     *
     * @param  Writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $data = [
            [
                'name' => 'source',
                'value' => null,
                'attributes' => [
                    'network' => $this->source
                ]
            ],
            [
                'name' => 'mac',
                'value' => null,
                'attributes' => [
                    'address' => $this->mac
                ]
            ]
        ];

        $writer->write($data);
    }

}