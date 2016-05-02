<?php
namespace goreilly\WebConnector\Endpoint;

use goreilly\WebConnector\TaskQueue;
use goreilly\WebConnector\ResponseDelegator;
use goreilly\WebConnector\SOAP\Response\ReceiveResponseXMLResponse;

class ReceiveResponseXMLEndpoint implements EndpointInterface
{
    
    /** @var  TaskQueue */
    protected $queue;
    
    /** @var  ResponseDelegator */
    protected $delegator;

    /**
     * ReceiveResponseXMLEndpoint constructor.
     * @param ResponseDelegator $delegator
     * @param TaskQueue         $queue
     */
    public function __construct(ResponseDelegator $delegator, TaskQueue $queue)
    {
        $this->delegator = $delegator;
        $this->queue = $queue;
    }

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'receiveResponseXML';
    }

    /**
     * @param mixed[] $argv
     * @return mixed
     */
    public function handle(array $argv)
    {
        $this->delegator->delegate($argv[0]);

        $total = $this->queue->getMax();
        $remaining = $this->queue->count();

        if ($total && $remaining) {
            $progress = round(($total - $remaining) / $total * 100);
        } else {
            $progress = 100;
        }

        $response = new ReceiveResponseXMLResponse();
        $response->receiveResponseXMLResult = $progress;

        return $response;
    }
}