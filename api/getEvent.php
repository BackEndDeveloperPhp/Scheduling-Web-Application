<?php

include_once 'config/database.php';
include_once 'objects/event.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$event = new Event($db);

$getEvent = $event->getEvent();


?>