<?php

namespace goreilly\WebConnector;

interface SimpleXMLElementFactoryInterface
{
    /**
     * @param string $version
     * @return \SimpleXMLElement
     */
    public function createQBXML($version = '7.0');
}