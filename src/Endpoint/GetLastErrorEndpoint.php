<?php
namespace goreilly\WebConnector\Endpoint;

class GetLastErrorEndpoint implements EndpointInterface
{

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'getLastError';
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