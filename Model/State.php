<?php

require_once(MODEL."/BaseModel.php");

class State extends BaseModel {
    
    const FREEZE_ID = 1;
 
    public $id;
    public $freeze;
    public $counter;
    public $nbrPerGroup;
     
    
    function __construct() {
        parent::__construct();
        $this->get(self::FREEZE_ID);
    }
    
    function isFreeze() {
        if ($this->freeze == 1)
            return TRUE;
        return FALSE;
    }
    
    function setFreeze($freeze) {
        $this->freeze = $freeze;
    }
    
    function setNbrPerGroup($nbr) {
        $this->nbrPerGroup = $nbr;
    }
    
    function getNbrPerGroup() {
        return $this->nbrPerGroup;
    }
    
    function getCounter() {
        $acount = $this->counter++;
        $this->save();
        return $acount;
    }
    
    function setCounter($aNumber) {
        $this->counter = $aNumber;
    }
    
    function get($stateID) {
        $query = "SELECT * from state where id = " . $stateID . ";";
        
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = NULL;
        
        $this->id = $row['id'];
        $this->freeze = $row['freeze'];
        $this->counter = $row['counter'];
        $this->nbrPerGroup = $row['nbrPerGroup'];
    }
    
    public static function statusString() {
        $state = new State();
        if ($state->freeze == 1)
            $freezeState = "ON";
        else
            $freezeState = "OFF";
        $str = "Checkin Counter = " . $state->counter
                . "<br>"
                . "Freeze = " . $freezeState
                . "<br>";
        return $str;
    }
    
    function save() {
        $query = "Update state SET freeze = " . $this->freeze .
                ", counter = " . $this->counter .
                ", nbrPerGroup = " . $this->nbrPerGroup .
                " WHERE id = " . $this->id . ";";
                    
        // echo $query . "<br>";
        
         $stmt = $this->database->query($query);
         $stmt = NULL;
         $this->database = NULL;
    }
    
    function addToRankList($name, $arank, $apool, $anumber, $htotal) {
        // print "\naddToRankList " . $anumber;
        $columns = "name, rank, poolID, number, housetotal";
        $query = "Insert into today (" . $columns . ") Values ('" . $name . "'," .
                $arank . ", " . $apool . ", " . $anumber . ", " . $htotal . ");";
        // print "query = ". $query;
        $stmt = $this->database->query($query);
        
        $stmt = NULL;
        $this->database = NULL;
    }
     
}    
    
?>
    

