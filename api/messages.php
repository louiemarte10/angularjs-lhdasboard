<?php
require_once 'config.php';
require_once 'query.php';
$request = json_decode(file_get_contents('php://input'));


$smm = new SMM();

$smm->showMessagesForDebug();
