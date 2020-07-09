<?php
// 'event' object
class Event{
 
    // database connection and table name
    private $conn;
    private $table_name = "events";
 
    // object properties
    public $id;
    public $title;
    public $event_date;

 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
    // add Event to DB
    public function create() {
       
            $query = "INSERT INTO " . $this->table_name . " (title, event_date) VALUES (:title, :event_date)";
            $statement =  $this->conn->prepare($query);
            $statement->execute(array(
                ':title' => $_POST['title'],
                ':event_date' => $_POST['start']
            ));
        
    }

    // move event
    public function editEvent() {
        $query = "UPDATE " . $this->table_name . " SET event_date =:event_date WHERE id =:event_id";
        $statement = $this->conn->prepare($query);
        $statement->execute(array(
            ':event_id' => $_POST['event_id'],
            ':event_date' => $_POST['start']
        ));
    }


    // get Event
    public function getEvent(){
        $data = array();
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $data[] = array(
                'id' => $row["id"],
                'title' => $row["title"],
                'start' => $row["event_date"]
            );
        }
        echo json_encode($data);
    }


      // delete Event
      public function delete(){
        $data = array();
        $query = "DELETE FROM " . $this->table_name . " WHERE  id =:event_id";
        $statement = $this->conn->prepare($query);
        $statement->execute(array(
            ':event_id' => $_POST['event_id'],
        ));
    
    }
}
?>