<?php
namespace goreilly\WebConnector\Tests;

use goreilly\WebConnector\QBXMLRequest\QBXMLRequestInterface;
use goreilly\WebConnector\TaskInterface;
use goreilly\WebConnector\Tests\QBXMLRequest\TestQBXMLRequest;

class TestTask implements TaskInterface
{
    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * TestTask constructor.
     * @param $date
     */
    public function __construct(\DateTime $date = null)
    {
        if ($date === null) {
            $date = new \DateTime();
        }
        
        $this->date = $date;
    }

    /**
     * String representation of object
     * @link  http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->date,
        ]);
    }

    /**
     * Constructs the object
     * @link  http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->date
        ) = unserialize($serialized);
    }

    /**
     * Get the request that will be sent to Quickbooks when this task runs.
     * @return QBXMLRequestInterface
     */
    public function getRequest()
    {
        return new TestQBXMLRequest();
    }

    /**
     * @return boolean The task will only be queued to send XML to quickbooks if this is true.
     */
    public function shouldRun()
    {
        return true;
    }
}