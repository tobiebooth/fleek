<?php

namespace Fleek\Entity;

use Sabre\Xml\Writer;

class OS extends BaseEntity
{
    public $type;
    public $arch;
    public $machine;
    public $bootDevices = [];

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
                'name' => 'type',
                'value' => $this->type,
                'attributes' => [
                    'arch' => $this->arch,
                    'machine' => $this->machine
                ]
            ]
        ];

        foreach ($this->bootDevices as $bootDevice) {
            $data[] = [
                'name' => 'boot',
                'value' => null,
                'attributes' => ['dev' => $bootDevice]
            ];
        }

        $writer->write($data);
    }
}