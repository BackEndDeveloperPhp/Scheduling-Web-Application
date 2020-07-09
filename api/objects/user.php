<?php

// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $error = [];

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 

// create new user record
function create(){
 
    //check username exist

    $sql_u = "SELECT * FROM " . $this->table_name . " WHERE username= :username";
    $statement = $this->conn->prepare($sql_u);
    $this->username=htmlspecialchars(strip_tags($this->username));
    $statement->bindParam(':username', $this->username);
    $statement->execute();

    //check username exist in db
    if(!$statement->rowCount() > 0) {

        //pattern for validation password - should be at least 8 characters long, should have at least one alphabet letter, one special character and at least one number
        $pattern = "/^(?=.{8,})(?=.*[A-z])(?=.*[@#$%^!&*+=]).*$/";

            //CHECK password
            if ( preg_match( $pattern, $this->password) ) {

                // insert query
                $query = "INSERT INTO " . $this->table_name . "
                SET
                    username = :username,
                    password = :password";
        
                // prepare the query
                $stmt = $this->conn->prepare($query);
        
                // sanitize
                $this->username=htmlspecialchars(strip_tags($this->username));
                $this->password=htmlspecialchars(strip_tags($this->password));
        
                // bind the values
                $stmt->bindParam(':username', $this->username);
        
                // hash the password before saving to database
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
        
                // execute the query, also check if query was successful
                if($stmt->execute()){
                return true;
                }
        
                return false;
            }
     
    }



}
 
// check if given username exist in the database
function usernameExists(){
 
    // query to check if username exists
    $query = "SELECT id, username, password
            FROM " . $this->table_name . "
            WHERE username = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->username=htmlspecialchars(strip_tags($this->username));
 
    // bind given username value
    $stmt->bindParam(1, $this->username);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // if username exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // assign values to object properties
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
 
        // return true because username exists in the database
        return true;
    }
 
    // return false if username does not exist in the database
    return false;
}
 

}

