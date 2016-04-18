<?php
namespace goreilly\WebConnectorExample\Task;

use goreilly\WebConnector\TaskInterface;
use goreilly\WebConnectorExample\Request\ItemQueryRequest;

class ImportItemsTask implements TaskInterface
{

    /**
     * Select Items modified in the last 30 days
     * @return ItemQueryRequest
     */
    public function getRequest()
    {
        $request = new ItemQueryRequest();
        $request->fromModifiedDate = new \DateTime('-30 days');

        return $request;
    }

    /**
     * Always runs
     * @return bool
     */
    public function shouldRun()
    {
        return true;
    }

    public function serialize()
    {
        return '';
    }

    public function unserialize($serialized)
    {
        return;
    }
}