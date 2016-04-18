<?php
namespace goreilly\WebConnector\Tests;

use goreilly\WebConnector\SimpleXMLElementFactory;

class SimpleXMLElementFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateQBXML()
    {
        $factory = new SimpleXMLElementFactory();

        $v7element = $factory->createQBXML();

        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<?qbxml version="7.0"?>
<QBXML/>
', $v7element->asXML());

        $v10Element = $factory->createQBXML('10.0');

        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<?qbxml version="10.0"?>
<QBXML/>
', $v10Element->asXML());

    }
}
