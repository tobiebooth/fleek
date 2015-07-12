<?php

namespace Fleek;

use Sabre\Xml\XmlSerializable;
use Sabre\Xml\Writer;

class BaseEntity implements XmlSerializable
{
    protected $entityName;
    protected $entityAttributes = [];

    /**
     * Serializes entity to XML
     *
     * @return string this returns the serialized XML string
     */
    public function toXML()
    {
        $writer = new Writer();
        $writer->openMemory();
        $writer->setIndent(1);

        $writer->write([
            [
                'name' => $this->entityName,
                'value' => $this,
                'attributes' => $this->entityAttributes
            ]
        ]);
        return $writer->outputMemory();
    }

    /**
     * The xmlSerialize method is called during xml writing
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        // Get objects public properties
        $elements = call_user_func('get_object_vars', $this);

        // Remove null elements and wrap object arrays in root element
        foreach ($elements as $key => $element) {
            if (is_null($element)) {
                unset($elements[$key]);
            }

            if (is_array($element)) {
                $element = array_map(function($item) {
                    if (is_object($item)) {
                        return [
                            'name' => $item->entityName,
                            'value' => $item,
                            'attributes' => $item->entityAttributes
                        ];
                    }

                    return $item;
                }, $element);

                $elements[$key] = $element;
            }
        }

        // Write XML
        $writer->write($elements);
    }
}