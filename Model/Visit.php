<?php

require_once(MODEL."/BaseModel.php");

class Visit extends BaseModel {
 
    public $id;
    public $clientID;
    public $dateTime;
    public $poolID;
    public $number; // assigned number when checking in
    
    function __construct() {
        parent::__construct();
    }
    
    function set($id, $clientID, $dateTime, $poolID, $number) {
         $this->id = $id;
         $this->clientID = $clientID;
         $this->poolID = $poolID;
         $this->dateTime = $dateTime;
         $this->number = $number;
    }
    
    public static function removeThisPool($poolID, $name) {
        $today = Any::currentDate();
        $visit = new Visit();
        $array = $visit->getWithPool($poolID, $today);
        // echo "<br> sizearray = ".sizeof($array);
        foreach ($array as $row) {
            $client = new Client();
            $clientName = $client->nameFirstLast($row['clientID']);
            // echo "<br> clientName = ".$clientName . " == " . $name;
            if ($clientName == $name) {
                // echo "<br> == ";
                $visit = new Visit();
                $visit->get($row['id']);
                $visit->poolID = 0;
                $visit->update();
                break;
            }
        }
    }
    
    function getWithPool($poolID, $forDate) {
        // get the list of visits with this poolID and date
        
        $query = "Select * from visit where poolID = ". $poolID . " and date(dateTime) = '" . $forDate . "'";
        $stmt = $this->database->query($query);
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function get($visitID) {
        $query = "SELECT * from Visit where id = " . $visitID . ";";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // $this->database = NULL;
        
        $this->set($row['id'], $row['clientID'], $row['dateTime'], $row['poolID'], $row['number']);
    }
    
    function remove($clientID, $forDate) {
        $query = "delete from Visit where clientID = " . $clientID . " and date(dateTime) = '".$forDate."'";
        echo "<br>" . $query;
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
    }
    
    
    function update() {
        $query = "Update Visit SET dateTime = '" . $this->dateTime . "', poolID = " . $this->poolID . 
                " WHERE id = " . $this->id . ";";
        // echo "update query = " . $query ."<br>";
        
        $stmt = $this->database->query($query);
        $this->database = NULL;
    }
    
    function createWithDate($clientID, $forDate, $aNumber) {
        $columns = "clientID, dateTime, number";
        $query1 = "Insert into visit(" . $columns . ") Values (" . $clientID . 
                "," . $forDate .  "," . $aNumber . ");";
        
        // print "\n createWithDate - query1 =  " . $query1;
        $stmt = $this->database->query($query1);
        $this->id = $this->database->lastInsertId();
        $this->clientID = $clientID;
        $this->poolID = 0;
        $stmt = NULL;
        $this->database = null;
    }
    
    function create($clientID, $isClient) {
        
       // add check here to prevent double checkin
        
        $currentDate = Any::currentDate(); // for today
        $visit = new Visit();
        // $isCheckin = $visit->isCheckin($clientID, $currentDate);
        
        // if ($isCheckin) {
        //    echo "<br>Double checkin detected for clientID = " . $clientID;
        //    return;
        // }
        
         // layaway, volunteer and staff do not get assigned Numbers
        $columns = "clientID, number";
        
        $assignedNumber = 0;
        if ($isClient) {
            $state = new State();
            $assignedNumber = $state->getCounter();
        }
        
        // print("\n create - assignedNumber = " . $assignedNumber);
        $query1 = "Insert into visit(" . $columns . ") Values (" . $clientID . "," . $assignedNumber . ");";
        // print "\n create - query1 =  " . $query1;
        $stmt = $this->database->query($query1);
        $this->id = $this->database->lastInsertId();
        $this->clientID = $clientID;
        
        // doing this because we get the datetime from MySQL and not from PHP
        
        $query2 = "select dateTime, poolID from visit where id = " . $this->id . ";";
        $stmt = $this->database->query($query2);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $this->dateTime = $row[0];
        $this->poolID = $row[1];
        $this->number = $assignedNumber;
        $stmt = NULL;
        $this->database = null;
    }
    
    function lastVisit($clientID) {
        $query = "select datetime from visit where visit.clientID = " . $clientID 
                . " ORDER BY visit.datetime DESC LIMIT 1 ";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == "") {
            return 0;
        } 
        return $row[0];
    }
    
    // remove all pool id for this date
    function removePool($forDate) {
        $query = "update visit set poolID = 0 where date(dateTime) = '" . $forDate . "'" ;
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
    }
    
    
    function visitID($clientID, $forDate) {
        $query = "select id from visit where date(dateTime) = '" . $forDate . 
                "' AND clientID = " . $clientID ;
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == "") {
            return 0;
        } 
              
        return $row[0];
    }
    
    function isCheckin($clientID, $forDate) {
        
        $query = "select id from visit where date(dateTime) = '" . $forDate . 
                "' AND clientID = " . $clientID ;
        
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == "") {
                $zz = FALSE;
        } else {
                $zz = TRUE;
        }
           // not closing the database
        return $zz;
    }
    
    function visitList($clientID) {
        
        $query = "select dateTime, poolID from visit where clientID = " . $clientID . " ORDER by dateTime DESC";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    
    function visitZipStats($fromDate, $toDate) {
        $query = "SELECT client.zip, count(client.zip) from client JOIN visit " .
                  "on client.id = visit.clientID where date(visit.dateTime) >= '". $fromDate . 
                   "' AND date(visit.dateTime) <= '". $toDate . "' group by zip order by zip";
               
       $stmt = $this->database->prepare($query);
       $stmt->execute();
       $array = $stmt->fetchAll();
       $stmt = NULL;
       $this->database = NULL;
       return $array;
    }
    
    
    function visitStats($fromDate, $toDate) {
        $query = "SELECT count(*), sum(nbrOver18), sum(nbr6To17), sum(nbrUnder5) from client JOIN visit " .
                  "on client.id = visit.clientID where date(visit.dateTime) >= '". $fromDate . 
                   "' AND date(visit.dateTime) <= '". $toDate . "'";
        
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        return $row;
        
    }
    
    function clientNbr($fromDate, $toDate) {
        $query = "SELECT count(*), sum(nbrOver18), sum(nbr6To17), sum(nbrUnder5) from client JOIN visit " .
                  "on client.id = visit.clientID where client.type = 'C' "
                . " and date(visit.dateTime) >= '". $fromDate . 
                   "' AND date(visit.dateTime) <= '". $toDate . "'";
                
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        return $row;
    }
    
    function volunteerNbr($fromDate, $toDate) {
        $query = "SELECT count(*), sum(nbrOver18), sum(nbr6To17), sum(nbrUnder5) from client JOIN visit " .
                  "on client.id = visit.clientID where client.type = 'V' and date(visit.dateTime) >= '". $fromDate . 
                   "' AND date(visit.dateTime) <= '". $toDate . "'";
                
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        return $row;
    }
    
    function staffNbr($fromDate, $toDate) {
        $query = "SELECT count(*), sum(nbrOver18), sum(nbr6To17), sum(nbrUnder5) from client JOIN visit " .
                  "on client.id = visit.clientID where client.type = 'S' and date(visit.dateTime) >= '". $fromDate . 
                   "' AND date(visit.dateTime) <= '". $toDate . "'";
                
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        return $row;
    }
    
    function layawayNbr($fromDate, $toDate) {
        $query = "SELECT count(*), sum(nbrOver18), sum(nbr6To17), sum(nbrUnder5) from client JOIN visit " .
                  "on client.id = visit.clientID where client.type = 'L' and date(visit.dateTime) >= '". $fromDate . 
                   "' AND date(visit.dateTime) <= '". $toDate . "'";
                
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        return $row;
    }
    
    public function removeCheckin($date1) {
        $timestamp = strtotime($date1);
        $fromDate = date("Y-m-d", $timestamp);
        
        $query = "DELETE * from visit where date(visit.dateTime) = '" . $fromDate . "'";
        
        
    }
    
    public function visitsLess($nbr) {
        $qry1 = "SELECT client.firstName, client.lastName, count(visit.dateTime) as nbr FROM `visit` join client "
             . "on client.id = visit.clientID and client.type='C' and client.active='Y'  "
             . " group by client.firstName, client.lastName having count(visit.dateTime) < " . $nbr
             . " ORDER BY count(visit.dateTime)DESC, client.firstName ASC";
        // echo "<br> query = " . $qry1;
        $stmt = $this->database->query($qry1);
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
     
    
    public function visitsGreater($nbr) {
        $qry1 = "SELECT client.firstName, client.lastName, count(visit.dateTime) as nbr FROM `visit` join client "
             . "on client.id = visit.clientID and client.type='C'  and client.active='Y'  "
             . " group by client.firstName, client.lastName having count(visit.dateTime) > " . $nbr
             . " ORDER BY count(visit.dateTime)DESC, client.firstName ASC";
        // echo "<br> query = " . $qry1;
        $stmt = $this->database->query($qry1);
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
     
}    
    
?>
    

