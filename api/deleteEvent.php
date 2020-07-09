<?php

include_once 'config/database.php';
include_once 'objects/event.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$event = new Event($db);

 // if the form was submitted 
 if(isset($_POST['event_id'])){
 
    // set product property values
    $event->id = $_POST['event_id'];


    $event->delete();
 }


?>