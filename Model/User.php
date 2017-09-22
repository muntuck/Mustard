<?php

require_once(MODEL."/BaseModel.php");

class User extends BaseModel {
 
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $initials;
    
    function __construct() {
        parent::__construct();
    }
    
    function set($id, $username, $password, $fullname, $email, $initials) {
         $this->id = $id;
         $this->username = $username;
         $this->password = $password;
         $this->fullname = $fullname;
         $this->email = $email;
         $this->initials = $initials;
    }
    
    function save() {
         $columns = "username, password, fullname, email, initials";
         $query1 = "Insert into user(" . $columns . ") Values (" . 
                 $this->username .", " . 
                 $this->password .", " .
                 $this->fullname .", " .
                 $this->email .", " .
                 $this->initials .
                 ");";
        
        $stmt = $this->database->query($query1);
        $this->id = $this->database->lastInsertId();
    }
    
    function get($username) {
        
    }
    
     
}    
    
?>
    

