<?php

include_once 'config/database.php';
include_once 'objects/event.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$event = new Event($db);

 // if the form was submitted 
 if(isset($_POST['title'])){
 
    // set product property values
    $event->title = $_POST['title'];
    $event->event_date = $_POST['event_date'];

    $event->create();
 }


?>