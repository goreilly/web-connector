<?php
namespace goreilly\WebConnectorExample\Request;

use goreilly\WebConnector\QBXMLRequest\QBXMLRequestInterface;

/**
 * Queries for Items in Quickbooks
 */
class ItemQueryRequest implements QBXMLRequestInterface
{
    /** @var  string Set to search for a specific item by ListID */
    public $listID;
    
    /** @var  \DateTime Set to find all modified items since the date */
    public $fromModifiedDate;
    
    /**
     * @param \SimpleXMLElement $root
     * @return \SimpleXMLElement
     */
    public function appendElementTo(\SimpleXMLElement $root)
    {
        $message = $root->addChild('QBXMLMsgsRq');
        
        $message->addAttribute('onError', 'stopOnError');
        
        $request = $message->addChild('ItemQueryRq');

        if ($this->listID) {
            $request->ListID = $this->listID;
        }

        if ($this->fromModifiedDate instanceof \DateTime) {
            $request->FromModifiedDate = $this->fromModifiedDate->format(\DateTime::W3C);
        }
    }
}