<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VDate
 *
 * @author muntu
 */

require_once(MODEL."/BaseModel.php");

class VDate extends BaseModel {
     
    public $id;
    public $clientID;
    public $date;  
    public $shift1;   // 1 - ON, and 0 - off
    public $shift2;
    public $shift3;
    
    function __construct() {
        parent::__construct();
    }
    
    public static function retrieve($clientID, $forDate) {
        $vdate = new VDate();
        $vdate->getFromDB($clientID, $forDate);
        return $vdate;
    }
    
    public static function summaryForDate($thisDate) {
        $shiftArray = array(0,0,0);
        for ($i=0; $i<3; $i++) {
            $vdate = new VDate();
            $shiftArray[$i] = $vdate->countShift($thisDate, $i+1);
        }
        return $shiftArray;
    }
    
    public function countShift($thisDate, $nbr) {
        $query = "SELECT count(*) FROM vdate WHERE date='".$thisDate . "' and shift" . $nbr . "=1";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = null;
        $this->database = null;
        return $row[0];
    }
    
    public function getFromDB($clientID, $forDate) {
        $query = "select id, clientID, date, shift1, shift2, shift3 from vdate where clientID = "
                . $clientID . " and date='" . $forDate . "'";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $row['id'];
        $this->clientID = $row['clientID'];
        $this->date = $row['date'];
        $this->shift1 = $row['shift1'];
        $this->shift2 = $row['shift2'];
        $this->shift3 = $row['shift3'];
        
        $stmt = null;
        $this->database = null;
    }
    
    public static function update($clientID, $shiftArray) {
        
        $dateStr = "";
        $vdate = null;
        VDate::removeAll($clientID);
        foreach ($shiftArray as $checked) {
            $shiftNbr = substr($checked, 0, 1);
            $forDate = substr($checked, 2);
            // echo "<br> check = " . $checked ;
            // echo "<br> shiftNbr = " . $shiftNbr;
            // echo "<br> fordate = " . $forDate;
            
            // echo "<br>dateStr = " . $dateStr;
            if ($dateStr == "") { // first time
                // remove an existing vdate with the same clientID and forDate
                // echo "<br>first time";
                $vdate = new VDate();
                $vdate->remove($clientID, $forDate);
                $vdate->reset($clientID, $forDate);
            } else {
                if ($dateStr == $forDate) {
                    // echo "<br> dateStr equal";
                } else { // a different date - save the previous one
                    // echo "<br>datestr not equal";
                    $vdate->save();
                    $vdate = new VDate();
                    $vdate->remove($clientID, $forDate);
                    $vdate->reset($clientID, $forDate);
                }
            }
            $vdate->setShift($shiftNbr);
            $dateStr = $forDate;
            
        }
        $vdate->save();
        
    }
    
    public static function removeAll($clientID, $forDate) {
        // echo "<br>Vdate::removeAll . " . $forDate;
        $arr = Any::nextFoodDay(3);
        
        $vdate = new VDate();
        foreach($arr as $thisDate) {
            $vdate->remove($clientID, $thisDate);
        }
    }
    
    public function reset($clientID, $forDate) {
        $this->clientID = $clientID;
        $this->id = 0;
        $this->date = $forDate;
        $this->shift1 = 0;
        $this->shift2 = 0;
        $this->shift3 = 0;
    }
    
    public function setShift($shiftNbr) {
        switch ($shiftNbr) {
            case "1" :
                $this->shift1 = 1;
                break;
            case "2" :
                $this->shift2 = 1;
                break;
            case "3" :
                $this->shift3 = 1;
                break;
            default:
                break;
        }
    }
    
    public function save() {
        $columns = "clientID, date, shift1, shift2, shift3";
        $query1 = "Insert into vdate(" . $columns . ") Values (" . $this->clientID . 
                ",'" . $this->date  . "'," . $this->shift1 . "," . $this->shift2 . "," . $this->shift3 . ");";   
        // echo "<br>vdate->save query= " . $query1;
        
        $stmt = $this->database->query($query1);
        $stmt = null;
        $this->database = null;
    }
    
    
    public function remove($clientID, $forDate) {
        $query = "delete from vdate where date = '" . $forDate . 
                "' AND clientID = " . $clientID ;
        // echo "<br>remove - query = " . $query;
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);

    }
    
    
    public function getForThisDate($forDate) {
        $query = "SELECT client.firstname,client.lastname, "
            ."vdate.shift1, vdate.shift2, vdate.shift3, client.email FROM `client` "
            ." join vdate on vdate.clientID = client.id where vdate.date = '"
            .$forDate ."' group by client.firstname,client.lastname,vdate.shift1, "
                . "vdate.shift2, vdate.shift3, client.email";
        //echo "<br> query = " . $query;
        $stmt = $this->database->query($query);
        $array = $stmt->fetchAll();
        return $array;
    }
    
    public static function sendReminders($forDate) {
        
        $endMessage = "<br><br>Do not reply. Reminders are automatically generated.";
        $mailSent = array();
        $mailNotSent = array();
        
        $mailgo = new Mailgo();
        $mailgo->setSubject("Next Community Closet Day is " . $forDate);
        $str1 = "<h3>Reminder: Your next Community Closet Day is " . $forDate . "</h3>"
                . "<h4>You have signed up for the following shifts: <br>";
        $vdate = new VDate();
        $array = $vdate->getForThisDate($forDate);
        foreach ($array as $row) {
            $fname = $row[0];
            $lname = $row[1];
            $shift1 = $row[2];
            $shift2 = $row[3];
            $shift3 = $row[4];
            $email = $row[5];
            
            $str0 = "<b>" . $fname . ",</b><br>";
            $str2 = "";
            if ($email != NULL) {
                if (strlen($email) < 5) {
                    $mailNotSent[] = $fname . " " . $lname . " [no email]";
                }
                else {
                    if ($shift1 == 1)
                        $str2 = $str2 . "<br>" . SHIFT_1;
                    if ($shift2 == 1)
                        $str2 = $str2 . "<br>" . SHIFT_2;
                    if ($shift3 == 1)
                        $str2 = $str2 . "<br>" . SHIFT_3;
                    $mailgo->setBody( $str0 . $str1. $str2 . "</h4>" . $endMessage);
                    $mailgo->addAddress($email);
                    if (!$mailgo->send()) {
                        $mailNotSent[] = $fname . " " . $lname . " [ERROR: ". $mailgo->getError() ."]";
                    } else {
                        $mailSent[] = $fname . " " . $lname . " [" . $email . "]";
                    }
                }
            } else {
                $mailNotSent[] =  $fname . " " . $lname . " [no email]";
            }
        }
        
        return array($mailNotSent, $mailSent);
    }
    
}
