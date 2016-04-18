<?php
namespace goreilly\WebConnector\Endpoint;

class ClientVersionEndpoint implements EndpointInterface
{

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'clientVersion';
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