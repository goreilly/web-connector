<?php
namespace goreilly\WebConnector;

class ResponseDelegator implements ResponseDelegatorInterface
{
    /** @var  HandlerInterface[] */
    protected $handlers = [];

    /**
     * ResponseParser constructor.
     * @param HandlerInterface[] $handlers
     */
    public function __construct(array $handlers = [])
    {
        $this->handlers = $handlers;
    }

    /**
     * @param \stdClass $raw Raw response
     * @throws \Exception On Invalid XML
     */
    public function delegate($raw)
    {
        $element = $this->getResponseElement($raw->response);
        foreach ($element->xpath('*') as $element) {
            $name = $element->getName();
            foreach ($this->handlers as $handler) {
                if ($handler->supports($name)) {

                    list($severity, $code, $message) = $this->extractErrorAttributes($element);

                    if ($severity === 'Error') {
                        if ($handler instanceof ErrorAwareHandlerInterface) {
                            $handler->error($code, $message);
                        }
                    } else {
                        $handler->handle($element);
                    }
                }
            }
        }
    }

    /**
     * An error occurred in Quickbooks. Instead of receiving the expected 
     * format we will only get an error message.
     * @param \SimpleXMLElement $element
     * @return string[] (severity, code, message)
     */
    protected function extractErrorAttributes(\SimpleXMLElement $element)
    {
        $severity = null;
        $code = null;
        $message = null;

        foreach ($element->attributes() as $key => $value) {
            switch ($key) {
                case 'statusSeverity':
                    $severity = (string) $value;
                    break;
                case 'statusCode':
                    $code = (int) $value;
                    break;
                case 'statusMessage':
                    $message = (string) $value;
                    break;
            }
        }

        return [$severity, $code, $message];
    }

    /**
     * @param string $xml
     * @return \SimpleXMLElement
     * @throws \Exception On XML Errors
     */
    public function getResponseElement($xml)
    {
        $last = libxml_use_internal_errors(true);
        $message = null;

        $element = @simplexml_load_string($xml);
        if ($element === false) {
            $message = 'Error Reading XML:';

            /** @var \LibXMLError $error */
            foreach (libxml_get_errors() as $error) {
                $message .= ' '.$error->message;
            }

            libxml_clear_errors();
        } elseif (empty($element->QBXMLMsgsRs)) {
            $message = 'Invalid Quickbooks Response, missing QBXMLMsgsRs';
        }
        
        libxml_use_internal_errors($last);

        if ($message) {
            throw new \Exception($message);
        }
        
        return $element->QBXMLMsgsRs;
    }
}