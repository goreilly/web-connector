<?php
namespace goreilly\WebConnector\Endpoint;

use goreilly\WebConnector\SOAP\Response\ServerVersionResponse;

class ServerVersionEndpoint implements EndpointInterface
{

    public $version;

    public function __construct($version = 'PHP Quickbooks Web Connector 0.1') { $this->version = $version; }

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'serverVersion';
    }

    /**
     * @param mixed[] $argv
     * @return mixed
     */
    public function handle(array $argv)
    {
        return new ServerVersionResponse($this->version);
    }
}