<?php
namespace goreilly\WebConnector\Authentication;

/**
 * Always authenticates a user.
 */
class NullAuthenticator implements AuthenticatorInterface
{

    /**
     * @param string $username
     * @param string $password
     * @return string Ticket
     */
    public function getTicket($username, $password)
    {
        return uniqid();
    }

    /**
     * @param string $ticket
     * @return boolean
     */
    public function validTicket($ticket)
    {
        return true;
    }
}