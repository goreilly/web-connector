<?php
namespace goreilly\WebConnectorExample;

use goreilly\WebConnector\Authentication\NullAuthenticator;
use goreilly\WebConnector\Endpoint\AuthenticateEndpoint;
use goreilly\WebConnector\Endpoint\ClientVersionEndpoint;
use goreilly\WebConnector\Endpoint\CloseConnectionEndpoint;
use goreilly\WebConnector\Endpoint\ConnectionErrorEndpoint;
use goreilly\WebConnector\Endpoint\EndpointInterface;
use goreilly\WebConnector\Endpoint\GetLastErrorEndpoint;
use goreilly\WebConnector\Endpoint\ReceiveResponseXMLEndpoint;
use goreilly\WebConnector\Endpoint\SendRequestXMLEndpoint;
use goreilly\WebConnector\Endpoint\ServerVersionEndpoint;
use goreilly\WebConnector\HandlerInterface;
use goreilly\WebConnector\SimpleXMLElementFactory;
use goreilly\WebConnector\TaskQueue;
use goreilly\WebConnector\ResponseDelegator;
use goreilly\WebConnector\TaskInterface;
use goreilly\WebConnectorExample\Task\ImportItemsTask;
use goreilly\WebConnectorExample\Handler\ItemHandler;

require_once __DIR__.'/../vendor/autoload.php';

session_start();

$server = new \SoapServer(__DIR__.'/../wsdl.xml', [
    'exceptions' => true,
    'cache_wsdl' => WSDL_CACHE_NONE
]);

// Get the Queue
if (empty($_SESSION['queue'])) {
    $_SESSION['queue'] = new TaskQueue();
}
$queue = $_SESSION['queue'];

// Get the Handlers
/** @var HandlerInterface[] $handlers */
$handlers = [
    new ItemHandler(),
];

// Get the Delegator
$delegator = new ResponseDelegator($handlers);


// Get the Tasks
/** @var TaskInterface[] $tasks */
$tasks = [
    new ImportItemsTask(),
];

// Get the Authenticator
$authenticator = new NullAuthenticator();

$factory = new SimpleXMLElementFactory();

/** @var EndpointInterface[] $endpoints */
$endpoints = [
    (new AuthenticateEndpoint($authenticator, $queue, $tasks)),
    (new ClientVersionEndpoint()),
    (new CloseConnectionEndpoint()),
    (new ConnectionErrorEndpoint()),
    (new GetLastErrorEndpoint()),
    (new SendRequestXMLEndpoint($queue, $factory)),
    (new ReceiveResponseXMLEndpoint($delegator, $queue)),
    (new ServerVersionEndpoint()),
];

$server->setClass(
    'goreilly\\WebConnector\\WebConnectorServer',
    $queue,
    $endpoints
);

return $server;
