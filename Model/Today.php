<?php

require_once(MODEL."/BaseModel.php");
 
class Today extends BaseModel {
    //put your code here
    
    protected static $inst = null;
    
    function __construct() {
        parent::__construct();
    }
    
    public static function remove($clientID) {
        $query = "Delete from Today where clientID = " . $clientID;
        
        $today = new Today();
        $today->database->query($query);
    }
    
    public static function removePool($name) {
        $query = "Update Today set poolName = '' where name = '" . $name . "'";
        
        $today = new Today();
        $today->database->query($query);
    }
    
    public static function isCheckin($clientID) {
        $query = "select * from Today where clientID = " . $clientID;
        
        $today = new Today();
        $stmt = $today->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == "") {
                $zz = FALSE;
        } else {
                $zz = TRUE;
        }
            
        $stmt = NULL;
        
        return $zz;
    }
    
    public static function add($name, $houseTotal, $number, $rank, $poolName, $dateTime, $clientID) {
        
        $columns = "name, rank, poolName, number, houseTotal, dateTime, clientID";
        $query  = "Insert into today (" . $columns . ") Values ('" . $name . "', " .
                $rank . ", '" . $poolName . "', " . $number . ", " . $houseTotal . ", '" 
                . $dateTime . "', " . $clientID . ");";
        // print "\nToday::add - " . $query;
        
        $today = new Today();
        $today->database->query($query);
    }
    
    public static function addPoolName($clientID, $poolName, $clientRank) {
        $query = "Update Today set poolName = '" . $poolName . "', rank = " . $clientRank 
                . " where clientID = " . $clientID;
        
        // print "\nToday::addPoolName - " . $query;
        
        $today = new Today();
        $today->database->query($query);
 
    }
    
    public static function moveToFront($clientID) {
        $query = "update Today set name = concat(name, '  @@@'), rank = 0 where clientID = " . $clientID;
        
        $today = new Today();
        $today->database->query($query);
    }
    
    public static function checkinList() {
        $query = "select clientID, name,  DATE_FORMAT(dateTime,'%H:%i') as time, houseTotal, number, poolName, "
                . "rank from today order by number DESC";
 
        $today = new Today();
        $stmt = $today->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $today->database = NULL;
        
        return $array;
    }
    
    
    public static function getRankOfClient($clientID) {
        $query = "select rank from Today where clientID = " . $clientID;
        // echo "Today::getRankOfClient:: " . $query . "<br>";
        $today = new Today();
        $stmt = $today->database->query($query);
        $array = $stmt->fetch(PDO::FETCH_NUM);
        if ($array == NULL || sizeof($array) == 0)
            return NULL;

        return $array[0];
    }
    
    public static function unFreeze() {
        // check to see whether there are any clients that came in after the previous freeze
        $query1 = "select clientID from Today where rank = " . FREEZE_RANK;
        $today = new Today();
        $stmt = $today->database->prepare($query1);
        $stmt->execute();
        $array = $stmt->fetchAll();
        if ($array == NULL || sizeof($array) == 0)
            return;
        
        
        foreach ($array as $row) {
            $clientID = $row[0];
            $rank = Any::myRandom();
            $query2 = "update Today set rank = " . $rank . " where clientID = " . $clientID;
            // echo "<br> " . $query2 . "<br>";
            $today->database->query($query2);
        }
        
         
    }
    
    public static function rankPriorityList() {
        $query = "select * from Today order by rank, dateTime";
        
        $today = new Today();
        $stmt = $today->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $today->database = NULL;
        
        return $array;
    }
    
    function removeAllEntries() {
        $query2 = "DELETE from today; ";
        $stmt = $this->database->query($query2);
        $stmt = NULL;
        $this->database = NULL;
    }
    
    public static function removeAll() {
        $query2 = "DELETE from today; ";
        $today = new Today();
        $today->removeAllEntries();
    }
}
