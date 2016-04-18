<?php
namespace goreilly\WebConnector\Tests;

use goreilly\WebConnector\Endpoint\ServerVersionEndpoint;
use goreilly\WebConnector\SOAP\Response\ServerVersionResponse;
use goreilly\WebConnector\TaskQueue;
use goreilly\WebConnector\WebConnectorServer;

class WebConnectorServerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  WebConnectorServer */
    protected $server;

    public function setUp()
    {
        $queue = new TaskQueue();

        $endpoints = [
            
            (new ServerVersionEndpoint())
        ];

        $this->server = new WebConnectorServer(
            $queue,
            $endpoints
        );
    }

    public function testServerVersion()
    {
        /** @var ServerVersionResponse $result */
        $result = $this->server->serverVersion();

        $this->assertInstanceOf('goreilly\\WebConnector\\SOAP\\Response\\ServerVersionResponse', $result);
        $this->assertNotEmpty($result->serverVersionResult);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No endpoint supports banana
     */
    public function testMissingEndpoint()
    {
        $this->server->banana();
    }

}
