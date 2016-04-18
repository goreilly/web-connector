<?php
namespace goreilly\WebConnector;

class SimpleXMLElementFactory implements SimpleXMLElementFactoryInterface
{
    /**
     * @param string $version
     * @return \SimpleXMLElement
     */
    public function createQBXML($version = '7.0')
    {
        $element = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><?qbxml version="'.$version.'"?><QBXML/>');
    
        return $element;
    }

}