<?php
namespace goreilly\WebConnector\Endpoint;

interface EndpointInterface
{
    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method);

    /**
     * @param mixed[] $argv
     * @return mixed
     */
    public function handle(array $argv);

}