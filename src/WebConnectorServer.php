<?php
namespace goreilly\WebConnector;

/**
 * @method authenticate
 * @method closeConnection
 * @method connectionError
 * @method getLastError
 * @method receiveResponseXML
 * @method sendRequestXML
 * @method serverVersion
 */
class WebConnectorServer
{
    /** @var  TaskQueueInterface */
    protected $queue;

    /** @var Endpoint\EndpointInterface[] */
    protected $endpoints = [];

    /**
     * @param TaskQueueInterface           $queue
     * @param Endpoint\EndpointInterface[] $endpoints
     */
    public function __construct(TaskQueueInterface $queue, array $endpoints = [])
    {
        $this->endpoints = $endpoints;
        $this->queue = $queue;
    }

    function __call($name, $arguments)
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->supports($name) === true) {
                return $endpoint->handle($arguments);
            }
        }

        throw new \Exception("No endpoint supports $name");
    }
}