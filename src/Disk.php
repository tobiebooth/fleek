<?php

namespace Fleek;

use Sabre\Xml\Writer;

class Disk extends BaseEntity
{
    public $source;
    public $target;
    public $readonly;

    protected $entityName = 'disk';
    protected $entityAttributes = [];

    /**
     * Construct a new disk
     *
     * @param string disk type (file, block, dir, network, volume)
     * @param string device (floppy, disk, cdrom, lun)
     */
    public function __construct($type, $device)
    {
        $this->entityAttributes = [
            'type' => $type,
            'device' => $device
        ];
    }

    /**
     * The xmlSerialize method is called during xml writing
     *
     * @param  Writer
     * @return void
     */
    function xmlSerialize(Writer $writer)
    {
        $data = [
            [
                'name' => 'source',
                'value' => null,
                'attributes' => [
                    'file' => $this->source
                ]
            ],
            [
                'name' => 'target',
                'value' => null,
                'attributes' => [
                    'dev' => $this->target
                ]
            ]
        ];

        if ($this->readonly) {
            $data[] = [
                'name' => 'readonly',
                'value' => null
            ];
        }

        $writer->write($data);
    }

}