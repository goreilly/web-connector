<?php
namespace goreilly\WebConnector\Endpoint;

use goreilly\WebConnector\SimpleXMLElementFactoryInterface;
use goreilly\WebConnector\SOAP\Response\SendRequestXMLResponse;
use goreilly\WebConnector\TaskQueueInterface;

class SendRequestXMLEndpoint implements EndpointInterface
{

    /** @var  TaskQueueInterface */
    protected $queue;
    
    /** @var  SimpleXMLElementFactoryInterface */
    protected $xmlFactory;

    /**
     * SendRequestXMLEndpoint constructor.
     * @param TaskQueueInterface               $queue
     * @param SimpleXMLElementFactoryInterface $xmlFactory
     */
    public function __construct(TaskQueueInterface $queue, SimpleXMLElementFactoryInterface $xmlFactory)
    {
        $this->queue = $queue;
        $this->xmlFactory = $xmlFactory;
    }

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'sendRequestXML';
    }

    /**
     * @param mixed[] $argv
     * @return mixed
     * @throws \Exception
     */
    public function handle(array $argv)
    {
        $response = new SendRequestXMLResponse;

        $task = $this->queue->pop();
        if (!$task) {
            return $response;
        }

        $root = $this->xmlFactory->createQBXML();

        $task->getRequest()->appendElementTo($root);

        $response->sendRequestXMLResult = $root->asXML();

        return $response;
    }
}