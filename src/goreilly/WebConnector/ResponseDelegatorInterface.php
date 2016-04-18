<?php

namespace goreilly\WebConnector;

/**
 * Delegates a response to the correct Handler.
 */
interface ResponseDelegatorInterface
{
    /**
     * @param \stdClass $raw Raw response
     * @throws \Exception On Invalid XML
     */
    public function delegate($raw);
}