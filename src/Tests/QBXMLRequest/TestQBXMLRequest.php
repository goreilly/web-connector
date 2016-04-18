<?php
namespace goreilly\WebConnector\Tests\QBXMLRequest;

use goreilly\WebConnector\QBXMLRequest\QBXMLRequestInterface;

class TestQBXMLRequest implements QBXMLRequestInterface
{

    /**
     * Will append the request's content to the $root element (the QBXML node)
     * Notes:
     * - Make sure you set the onError attribute on the first child, it's always required.
     * @param \SimpleXMLElement $root
     * @return \SimpleXMLElement
     */
    public function appendElementTo(\SimpleXMLElement $root)
    {
        $root->addChild('Test', 'Hello World');
    }
}