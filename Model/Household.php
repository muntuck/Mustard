<?php

require_once(MODEL."/BaseModel.php");

class Household extends BaseModel {
 
    public $id;
    public $clientID;
    public $name;
    public $birthdate;
    public $relationship;
    
    function __construct() {
        parent::__construct();
        
    }
    
    function get($householdID) {
        $query = "select * from household where id = ". $householdID . ";";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        
        $row = $array[0];
        $this->set($row['id'], $row['clientID'], $row['name'], $row['birthdate'], $row['relationship']);
    }
    
    function set($id, $clientID, $name, $birthdate, $relationship) {
         $this->id = $id;
         $this->clientID = $clientID;
         $this->name = Any::removeSpecialChars($name);
         $this->birthdate = $birthdate;
         $this->relationship = $relationship;
    }
    
    function householdList($clientID) {
        
        $query = "select id,name,birthdate,relationship from household where clientID = " . $clientID . 
                " ORDER by name DESC";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function save() {
        $columns = "clientID, name, birthdate, relationship";
        $query = "Insert into household(" . $columns . ") Values( ".
                $this->clientID . ",'" .
                $this->name . "', '" . 
                $this->birthdate . "', '" . 
                $this->relationship . "');";
        // echo "household save query = " . $query . "<br>";
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
    }
    
    function update() {
        $query = "UPDATE household SET name = '". $this->name .
            "', birthdate = '" . $this->birthdate . "',  relationship = '" .
                 $this->relationship . "' WHERE id = ". $this->id . ";";
        
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
    }
     
}    
    
?>
    

