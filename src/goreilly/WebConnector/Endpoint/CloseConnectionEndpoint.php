<?php
namespace goreilly\WebConnector\Endpoint;

class CloseConnectionEndpoint implements EndpointInterface
{

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'closeConnection';
    }

    /**
     * @param mixed[] $argv
     * @return mixed
     */
    public function handle(array $argv)
    {
        return 'Complete!';
    }
}