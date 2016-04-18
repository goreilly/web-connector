<?php
namespace goreilly\WebConnector\Authentication;

interface AuthenticatorInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return string Ticket Blank string on error
     */
    public function getTicket($username, $password);

    /**
     * @param string $ticket
     * @return boolean
     */
    public function validTicket($ticket);

}