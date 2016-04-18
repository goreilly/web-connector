<?php
namespace goreilly\WebConnector\Endpoint;

use goreilly\WebConnector\Authentication\AuthenticatorInterface;
use goreilly\WebConnector\SOAP\Request\AuthenticateRequest;
use goreilly\WebConnector\SOAP\Response\AuthenticateResponse;
use goreilly\WebConnector\TaskInterface;
use goreilly\WebConnector\TaskQueueInterface;

class AuthenticateEndpoint implements EndpointInterface
{

    /** @var  TaskQueueInterface */
    protected $queue;

    /** @var  AuthenticatorInterface */
    protected $authenticator;

    /** @var  TaskInterface[] */
    protected $tasks;

    /**
     * AuthenticateEndpoint constructor.
     * @param AuthenticatorInterface $authenticator
     * @param TaskQueueInterface     $queue
     * @param TaskInterface[]        $tasks
     */
    public function __construct(AuthenticatorInterface $authenticator, TaskQueueInterface $queue, array $tasks)
    {
        $this->authenticator = $authenticator;
        $this->queue = $queue;
        $this->tasks = $tasks;
    }

    /**
     * @param string $method
     * @return boolean
     */
    public function supports($method)
    {
        return $method === 'authenticate';
    }

    /**
     * @param \stdClass[] $argv
     * @return AuthenticateRequest
     * @throws \Exception Invalid Format
     */
    protected function mapRequest(array $argv)
    {
        if (!isset($argv[0])) {
            throw new \Exception("Invalid Request");
        }

        if (!$argv[0] instanceof \stdClass) {
            throw new \Exception("Invalid Request");
        }

        $raw = $argv[0];

        $request = new AuthenticateRequest();

        $request->strUserName = $raw->strUserName;
        $request->strPassword = $raw->strPassword;

        return $request;
    }

    /**
     * @param mixed[] $argv
     * @return mixed
     */
    public function handle(array $argv)
    {
        $request = $this->mapRequest($argv);

        $response = new AuthenticateResponse;

        $ticket = $this->authenticator->getTicket($request->strUserName, $request->strPassword);
        $alert = 'nvu'; // Not Valid User

        if ($ticket) {

            foreach ($this->tasks as $task) {
                if ($task->shouldRun()) {
                    $this->queue->add($task);
                }
            }

            $taskCount = $this->queue->count();

            $alert = ''; // Something to do

            if ($taskCount === 0) {
                $alert = 'none'; // Nothing to do
            }

            $response->authenticateResult = ['ticket', 'none'];
        }

        $response->authenticateResult = [
            $ticket,
            $alert,
        ];

        return $response;
    }
}