<?php
namespace goreilly\WebConnector;

interface ErrorAwareHandlerInterface extends HandlerInterface
{
    /**
     * Implement something to log error messages.
     * @param string $code Code returned by Quickbooks
     * @param string $message Message returned by Quickbooks
     */
    public function error($code, $message);
}