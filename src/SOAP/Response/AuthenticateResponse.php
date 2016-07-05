<?php
namespace goreilly\WebConnector\SOAP\Response;

class AuthenticateResponse
{
    /** @var  ArrayOfStringResultObject */
    public $authenticateResult;
    public function __construct(array $authenticateResult = null) { $this->authenticateResult = $authenticateResult; }
}