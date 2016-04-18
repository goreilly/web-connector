<?php
namespace goreilly\WebConnector;

/**
 * Handlers are called by the ResponseDelegator to do stuff
 * with data you get back from Quickbooks.
 */
interface HandlerInterface
{
    /**
     * @param string $type Type of Result Element. Example: ItemQueryRs
     * @return boolean Should this handler be called with the data
     */
    public function supports($type);

    /**
     * @param \SimpleXMLElement $element
     * @return void
     */
    public function handle(\SimpleXMLElement $element);
}