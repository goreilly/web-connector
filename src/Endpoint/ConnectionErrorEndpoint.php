<?php
namespace goreilly\WebConnector\Endpoint;

class ConnectionErrorEndpoint implements EndpointInterface
{

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'connectionError';
    }

    /**
     * @param mixed[] $argv
     * @return mixed
     */
    public function handle(array $argv)
    {
        return null;
    }
}