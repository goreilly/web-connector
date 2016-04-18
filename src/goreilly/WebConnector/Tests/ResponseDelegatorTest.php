<?php
namespace goreilly\WebConnector\Tests;

use goreilly\WebConnector\ResponseDelegator;

class ResponseDelegatorTest extends \PHPUnit_Framework_TestCase
{
    public function testDelegate()
    {

        $handlerBuilder = $this->getMockBuilder('goreilly\\WebConnector\\HandlerInterface');

        $itemHandler = $handlerBuilder->getMock();

        $itemHandler->expects($this->once())->method('supports')->willReturnCallback(function ($name) {
            return $name === 'ItemQueryRs';
        });

        $itemHandler->expects($this->once())->method('handle');

        $handlers = [
            $itemHandler,
        ];

        $delegator = new ResponseDelegator($handlers);
        $response = $this->getResponse();

        $delegator->delegate($response);
    }

    /**
     * @return \stdClass
     */
    protected function getResponse()
    {
        $response = new \stdClass();

        // todo, real element names
        $response->response = <<<XML
<Root>
    <QBXMLMsgsRs>
        <ItemQueryRs/>
    </QBXMLMsgsRs>
</Root>
XML;

        return $response;
    }

    public function getResponseElement()
    {
        $delegator = new ResponseDelegator();
        $response = $this->getResponse();
        $element = $delegator->getResponseElement($response->response);
        $this->assertInstanceOf('SimpleXMLElement', $element);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Error Reading XML: Extra content at the end of the document
     */
    public function testInvalidXML()
    {
        $response = $this->getResponse();
        $xml = $response->response;
        $xml .= 'banana';

        $delegator = new ResponseDelegator();
        $delegator->getResponseElement($xml);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Quickbooks Response, missing QBXMLMsgsRs
     */
    public function testInvalidRequest()
    {
        $xml = <<<XML
<Root/>
XML;
        $delegator = new ResponseDelegator();
        $delegator->getResponseElement($xml);
    }
}
