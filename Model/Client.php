<?php

require_once(MODEL."/BaseModel.php");

class Client extends BaseModel {
 
    public $id;
    public $firstName;
    public $lastName;
    public $birthDate;
    public $gender;
    
    public $nbrOver18;       // numbers initially provided by client
    public $nbr6To17;        // and will be verified by household data
    public $nbrUnder5;       // so we do not need to trust their household information
    
    public $street;
    public $apartment;
    public $city;
    public $state;
    public $zip;
    
    public $phone;     
    public $email;
    public $photo;
    
    public $churchMember;
    public $type;
    public $lifescan;
    
    public $layawaySponsor;   // volunteer who delivers to layaway. A client must be a volunteer to deliver.
    public $sponsorID;    //the volunteer who brings food to person
    
    public $active;  // whether person is still ative
    
    function __construct() {
        parent::__construct();
        
    }
    
    function set($id, $firstName, $lastName, $birthDate, $gender,
                            $nbrOver18, $nbr6To17, $nbrUnder5,
                            $street, $apartment, $city, $state, $zip, 
                            $phone, $email, $photo,
                            $churchMember, $type, $lifescan, $layawaySponsor, $sponsorID, $active) {
        $this->id = $id;
        $this->firstName = Any::removeSpecialChars($firstName);
        $this->lastName = Any::removeSpecialChars($lastName);
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        
        $this->nbrOver18 = $nbrOver18;
        $this->nbr6To17 = $nbr6To17;
        $this->nbrUnder5 = $nbrUnder5;
        
        $this->street = Any::removeSpecialChars($street);
        $this->apartment = $apartment;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        
        $this->phone = $phone;
        $this->email = $email;
        $this->photo = $photo;
        
        $this->churchMember = $churchMember;
        $this->type = $type;
        $this->lifescan = $lifescan;
        
        $this->layawaySponsor = $layawaySponsor;
        $this->sponsorID = $sponsorID;
        
        $this->active = $active;
    }
    
    function save() {
        $columns = "firstName, lastName, birthDate, gender, street, apartment, city, state, zip, "
                    .  "nbrOver18, nbr6To17, nbrUnder5, phone, email, churchMember, type, lifescan, "
                    . "layawaySponsor, sponsorID, active";
        $query = "Insert into client(" . $columns . ") Values (" .
                "'" . $this->firstName . "'," .
                "'" . $this->lastName . "'," .
                "'" . $this->birthDate ."'," .
                "'" . $this->gender . "'," .
                
                "'" . $this->street . "'," .
                "'" . $this->apartment . "'," .
                "'" . $this->city . "'," .
                "'" . $this->state . "'," .
                "'" . $this->zip . "'," .
                
                $this->nbrOver18 . "," .
                $this->nbr6To17 . "," .
                $this->nbrUnder5 . "," .
                
                "'" . $this->phone . "'," .
                "'" . $this->email . "'," .
                "'" . $this->churchMember . "'," .
                "'" . $this->type . "'," .
                "'" . $this->lifescan . "'," .
                 "'" . $this->layawaySponsor . "', " .
                  $this->sponsorID . ", " .
                "'" .   $this->active . "'" . ")";
        
        echo "<br>client save query = " . $query . " <br>";
        
        $stmt = $this->database->query($query);
        $this->id = $this->database->lastInsertId();
        $stmt = NULL;
        $this->database = NULL;
    }
    
    function update() {
        $columns = "firstName, lastName, birthDate, gender, street, apartment, city, state, zip, "
                    .  "nbrOver18, nbr6To17, nbrUnder5, phone, email, churchMember, type, lifescan, "
                    . "layawaySponsor, sponsorID, active";
        
        $query = "Update client "  .
                "set firstName='" . $this->firstName . "'," .
                " lastName='" . $this->lastName . "'," .
                " birthDate='" . $this->birthDate ."'," .
                " gender='" . $this->gender . "'," .
                
                " street='" . $this->street . "'," .
                " apartment='" . $this->apartment . "'," .
                " city='" . $this->city . "'," . 
                " state='" . $this->state . "'," .
                " zip='" . $this->zip . "'," .
                
                " nbrOver18=" . $this->nbrOver18 . "," .
                " nbr6To17=" . $this->nbr6To17 . "," .
                "  nbrUnder5=" .$this->nbrUnder5 . "," .
                
                "  phone='" . $this->phone . "'," .
                " email='" . $this->email . "'," .
                " churchMember='" . $this->churchMember . "'," .
                " type='" . $this->type . "'," .
                " lifescan='" . $this->lifescan . "',".
                " layawaySponsor='" . $this->layawaySponsor . "',".
                " sponsorID=" . $this->sponsorID . ", ".
                " active='" . $this->active . "' " .
                " where id = " . $this->id . ";";
        
        // echo "update client query = " . $query . "<br>";
        
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
        
    }
    
    function addPhoto($clientID, $photoFile) {
        $query = "UPDATE client set photo = '" . $photoFile . "' where id = " . $clientID . ";";
        
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
    }
    
    function housetotal($clientID) {
        $query = "SELECT (nbrOver18 + nbr6To17 + nbrUnder5) as htotal FROM client where id = " . $clientID .";";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        
        return $row[0];
    }
    
    function name($clientID) {
        if ($clientID == 0)
            return "";
        
        $query = "SELECT firstName, lastName from client where id = " . $clientID .";";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        // $stmt = NULL;
        // $this->database = NULL;
        
        return $row[1] . ", " . $row[0];
        
    }
    
    function nameFirstLast($clientID) {
        if ($clientID == 0)
            return "";
        
        $query = "SELECT firstName, lastName from client where id = " . $clientID .";";
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        // $stmt = NULL;
        // $this->database = NULL;
        
        return $row[0] . " " . $row[1];
        
    }
    
    function sponsorList() {
        $query = "SELECT concat(client.lastName, ', ',client.firstName), id from client " .
                 " WHERE type = 'V' AND layawaySponsor = 'Y';";
        $stmt = $this->database->query($query);
        $arr = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $arr;
    }
    
    
    function get($clientID) {
        
        $query = "SELECT * from client WHERE id = " . $clientID .";";
        
        $stmt = $this->database->query($query);
        // $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // $stmt = NULL;
        // $this->database = NULL;
                
        $this->set( $row["id"], //$id,
                $row["firstName"], // $firstName, 
                $row["lastName"], // $lastName, 
                $row["birthDate"], // $birthDate, 
                $row["gender"], // 
                
                $row["nbrOver18"], //  
                $row["nbr6To17"],
                $row["nbrUnder5"],
                
                $row["street"], // $street, 
                $row["apartment"], // $apartment, 
                $row["city"], // $city, 
                $row["state"], // $state, 
                $row["zip"], // $zip, 
                
                $row["phone"], // $phone, 
                $row["email"], // $email, 
                $row["photo"], // photo
                $row["churchMember"], // $churchMember, 
                $row["type"], // $volunteer, 
                $row["lifescan"], // lifescan
                $row["layawaySponsor"], // $layaway)    
                $row["sponsorID"],  // $Sponsor);   
                $row["active"] );
   }
    
    
    
    
    // returns an array of clients
    function getExistList($lastName, $firstName, $active) {
        
        $query = $this->existQuery($lastName, $firstName, $active);
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }

    
    function existQuery($lastName, $firstName, $active) {
        $lstr = "";
        $fstr = "";
        
        if (strlen($lastName) > 0)
            $lstr = "lastName LIKE \"" . $lastName . "%\"";
        if (strlen($firstName) > 0)
            $fstr = "firstName LIKE \"" . $firstName . "%\"";
 
        $order = " order by firstName, lastName";
        $query = "SELECT id, firstName, lastName, zip, (nbrOver18 + nbr6To17 + nbrUnder5) as number, type "
                . " FROM `client` WHERE active='" . $active . "'";

        if (strlen($lstr) > 0 && strlen($fstr) > 0) {
            $query = $query . " AND " . $lstr . "AND " . $fstr . $order;
        } else {
            if (strlen($lstr) > 0) {
                $query = $query . " AND " . $lstr 
                        . $order;
            } else {
                if (strlen($fstr) > 0) {
                $query = $query . " AND " . $fstr . $order;
                } else {
                    $query = $query . $order;
                }
            }
        }

        return $query;
    }
    
    function volunteerWithLifescan() {
        $query = "SELECT id, lastName, firstName FROM `client` "
                . " where type = 'V' and active='Y' and lifescan='Y' order by lastName, firstName; ";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function volunteerWithOutLifescan() {
        $query = "SELECT id, lastName, firstName FROM `client` "
                . " where type = 'V' and active='Y' and lifescan='N' order by lastName, firstName; ";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function volunteerList() {
        $query = "SELECT id, lastName, firstName, zip FROM `client` "
                . " where type = 'V' and active='Y' order by firstName, lastName; ";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    
    function staffList() {
        $query = "SELECT id, lastName, firstName, zip FROM `client` "
                . " where type = 'S' and active='Y' order by firstName, lastName; ";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function householdGreater($nbr) {
        $query = "SELECT firstName,lastName,(nbrOver18+nbr6To17+nbrUnder5) as nbr FROM `client` "
                . " where type = 'C' and active='Y' group by nbr,firstName,lastName "
                . " having nbr > " . $nbr
                . " order by nbr DESC,firstName ASC,lastName ASC; ";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function householdLess($nbr) {
        $query = "SELECT firstName,lastName,(nbrOver18+nbr6To17+nbrUnder5) as nbr FROM `client` "
                . " where type = 'C' and active='Y' group by nbr,firstName,lastName "
                . " having nbr < " . $nbr
                . " order by nbr DESC,firstName ASC,lastName ASC; ";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    
    function withChildren() {
        $query = "SELECT firstName,lastName,nbrUnder5 FROM `client` "
                . " where type = 'C' and active='Y' group by nbrUnder5,firstName,lastName "
                . " having nbrUnder5 > 0 " 
                . " order by nbrUnder5 DESC,firstName ASC,lastName ASC; ";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    
    function layawayList() {
        $query = "SELECT id, firstName, lastName, sponsorID FROM `client` "
                . "where type = 'L' and active='Y' order by firstName, lastName; ";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function volunteerCheckin($forDate) {
        $query = "SELECT client.id as clientID, concat(client.lastName,', ',client.firstName) as name, "
                ." DATE_FORMAT(visit.dateTime,'%H:%i') as time,"
                 . "visit.number "
                 . " FROM client JOIN visit on client.id = visit.clientID WHERE client.type = 'V'" 
                 . " AND date(visit.dateTime) = '". $forDate 
                 . "' order by visit.number, visit.dateTime ASC; ";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    
    function checkinList($forDate) {
        $query = "SELECT client.id, concat(client.firstName,' ',client.lastName), DATE_FORMAT(visit.dateTime,'%H:%i'),".
                 "(client.nbrOver18 + client.nbr6To17 + client.nbrUnder5) as housetotal, visit.number, visit.poolID" .
                 " FROM client JOIN visit on client.id = visit.clientID " .
                " AND date(visit.dateTime) = '". $forDate .
                 "' AND client.type = 'C' order by visit.number DESC; ";
        
        // echo "<br>" . $query;
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function rankList() {
        // $time_start = microtime(true);
        
        $query4 = "Select name, rank, poolID, number, housetotal from today order by rank, poolID ASC";
        $stmt = $this->database->prepare($query4);;
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        
        // $time_end = microtime(true);
        // $time = $time_end - $time_start;
        // echo "<br>client::rankList in $time seconds\n";
        
        return $array;
    }
    
    function removeFromTodayList($number) {
        $query = "update today set name = 'XXXXX -- Removed XXXXX' where number=" . $number;
        // echo "<br> query = " . $query;
        $stmt = $this->database->query($query);
       
    }
    
    function randomize($forDate) {
         $query2 = "DELETE from today; ";
         
         $query3 = "INSERT into today SELECT concat(client.firstName,' ',client.lastName), " .
                    "RIGHT( visit.dateTime, 1 ), ".
                    "visit.poolID, visit.number, (client.nbrOver18 + client.nbr6To17 + client.nbrUnder5) " .
                    " FROM client JOIN visit ".
                    "on client.id = visit.clientID AND date(visit.dateTime) = '". $forDate .
                    "' AND client.type = 'C' order by visit.dateTime ASC; ";
                  
         // echo "query3 - " . $query3;
         $stmt = $this->database->query($query2);
         
         $stmt = $this->database->query($query3);
         
         return $this->rankList();
    }
    
    function removeLayaway() {
        $query = "update client set type = 'C' where type = 'L'";
        $stmt = $this->database->prepare($query);;
         $stmt->execute();
         $stmt = NULL;
         $this->database = NULL;
    }
    
    
    function zipcodeStats() {
        $query = "select zip, count(zip) as total from client where active='Y' group by zip order by zip";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
}    
    



?>
    

