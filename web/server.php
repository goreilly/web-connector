<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';

try {
    $server = require __DIR__.'/../example/server.php';
    $server->handle(file_get_contents('php://input'));
} catch (SoapFault $e) {
    error_log("SOAP ERROR: ".$e->getMessage());
}
