<?php
namespace goreilly\WebConnector\Endpoint;

use goreilly\WebConnector\SOAP\Response\ServerVersionResponse;

class ServerVersionEndpoint implements EndpointInterface
{

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
        $response = new ServerVersionResponse();
        $response->serverVersionResult = 'NGC Quickbooks Soap Server v0.1';
        return $response;
    }
}