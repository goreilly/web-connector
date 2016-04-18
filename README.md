# Usage

## Endpoints

The endpoints handle each individual SOAP request. You won't need to override them, but you will need to inject each
of their dependencies.

## Tasks

A task implements `goreilly\WebConnector\Task\TaskInterface` to determine if a request should be sent and what kind
of xml to send.

## Handlers

A handler implements `\goreilly\WebConnector\QBXMLResponseHandler\QBXMLResponseHandlerInterface`. When a response is
returned from Quickbooks, a handler that supports the response content will be selected and ran.

### Example Handler

```php
class ItemQueryHandler implements QBXMLResponseHandlerInterface
{
    public function supports($type)
    {
        return $type === 'ItemQueryRs';
    }

    public function handle(\SimpleXMLElement $element)
    {
        // Insert items into database...
    }
}
```

## Queue

The Queue persists between requests. It will last for one click of the "Update Selected" button in the
Web Connector because it clears cookies after that. You can store the Queue however you want, like in the session.
You just need to retrieve and pass the Queue to the Server each request.

The Queue must be injected into the Handlers that need it.

- SendRequestXMLHandler:
    Uses the Queue to build and send XML from tasks stored in the queue.
- AuthenticateEndpoint:
    Uses the Queue to report the initial progress.
- ReceiveResponseXMLEndpoint:
    Uses the Queue to report progress after handling the response.


## Authentication

Authentication is optional, but you must pass an Authenticator object to the Authentication Endpoint. If you
would like to always accept every request, use the NullAuthenticator.

# Where To Start

1. Determine what you want to get from Quickbooks.
2. Look up the correct Query and Response formats from the Intuit Documentation:
    https://developer-static.intuit.com/qbSDK-current/Common/newOSR/index.html
    (Choose qbXML and the correct SDK version)
3.

# Notes

* If changes don't seem to be effecting anything try to stop and start your PHP Development Server since it caches the SOAPServer.

# Road Map

1. Adding Responses to Handlers. I don't know if they need them?
2. Unit Tests
3. QBXML Validation via xsd
4. Error Handling
5. Find correct WSDL file