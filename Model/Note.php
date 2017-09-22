<?php

require_once(MODEL."/BaseModel.php");

class Note extends BaseModel {
 
    public $id;
    public $clientID;
    public $note;
    public $authorInitials;
    public $dateTime;
    
    function __construct() {
        parent::__construct();
        
    }
    
    function set($id, $clientID, $note, $authorInitials, $dateTime) {
         $this->id = $id;
         $this->clientID = $clientID;
         $this->note = Any::removeSpecialChars($note);
         $this->authorInitials = $authorInitials;
         $this->dateTime = $dateTime;
    }
    
    function getLatestNotes($clientID) {
        
        $query = "select note from notes where clientID = " . 
                          $clientID . " ORDER by dateTime DESC LIMIT 3";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function allNotes($clientID) {
        $query = "select dateTime, authorInitials, note from notes where clientID = " . 
                          $clientID . " ORDER by dateTime DESC";
        $stmt = $this->database->query($query);
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    
    function add($clientID, $authorInitials, $note) {
         
        $note = Any::removeSpecialChars($note);
        $query = "INSERT into notes(clientID, authorInitials, note) VALUES(" .
                 $clientID . ", '" . $authorInitials . "', '" . $note . "');";
         
        $stmt = $this->database->query($query);
        
        $stmt = NULL;
        $this->database = NULL;
     }
    
     
}    
    
?>
    

