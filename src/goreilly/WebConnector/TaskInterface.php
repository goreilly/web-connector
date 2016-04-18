<?php
namespace goreilly\WebConnector;

use goreilly\WebConnector\QBXMLRequest\QBXMLRequestInterface;

/**
 * Will build a request to send to Quickbooks.
 * Checks if it should be sent.
 * Must be serializable so we can persist it between requests.
 */
interface TaskInterface extends \Serializable
{
    /**
     * Get the request that will be sent to Quickbooks when this task runs.
     * @return QBXMLRequestInterface
     */
    public function getRequest();

    /**
     * @return boolean The task will only be queued to send XML to quickbooks if this is true.
     */
    public function shouldRun();
}