<?php

require_once(MODEL."/BaseModel.php");

class Pool extends BaseModel {
    
    public static $ERROR_EXIST = 11;
    public static $ERROR_FULL = 33;
    
    public $id;
    public $poolRank;
    public $poolName;
    public $name1;
    public $name2;
    public $name3;
    public $name4;
    public $name5;
    public $name6;
    public $name7;
    
    function __construct() {
        parent::__construct();
        
    }
    
    function set($poolID, $poolRank, $poolName, $name1, $name2, $name3, $name4, $name5, $name6, $name7) {
         $this->id = $poolID;
         $this->poolRank = $poolRank;
         $this->poolName = $poolName;
         $this->name1 = $name1;
         $this->name2 = $name2;
         $this->name3 = $name3;
         $this->name4 = $name4;
         $this->name5 = $name5;
         $this->name6 = $name6;
         $this->name7 = $name7;
    }
    
    
    function reset() {
        $query = "UPDATE pool SET " .
                "poolRank = 0, " .
                "name1 = NULL, " .
                "name2 = NULL, " .
                "name3 = NULL, " .
                "name4 = NULL, " .
                "name5 = NULL, " .
                "name6 = NULL, " .
                "name7 = NULL; ";
        
        $stmt = $this->database->query($query);
        $stmt = NULL;
        $this->database = NULL;
    }
    
    function poolName($poolID) {
        $query = "SELECT poolName from pool where id = " . $poolID . ";";
        
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = NULL;
        $this->database = NULL;
        return $row[0];
    }
    
    function get($poolID) {
        $query = "SELECT * from pool where id = " . $poolID . ";";
        
        $stmt = $this->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->set($row['id'], $row['poolRank'], $row['poolName'], 
                $row['name1'], $row['name2'], $row['name3'], $row['name4'], $row['name5'],
                $row['name6'], $row['name7']);
    }
    
    function save() {
        
        $query = "Update pool SET poolRank = " .$this->poolRank . ", ".
                   "name1 = '" . $this->name1 . "', " .
                "name2 = '" . $this->name2 . "', " .
                "name3 = '" . $this->name3 . "', " .
                "name4 = '" . $this->name4 . "', " .
                "name5 = '" . $this->name5 . "', " .
                "name6 = '" . $this->name6 . "', " .
                "name7 = '" . $this->name7 . "' " .
                "WHERE id = " . $this->id . ";";
         // echo "query = " . $query . "<br>";
         $stmt = $this->database->query($query);
         $stmt = NULL;
         $this->database = NULL;
         // echo "save == " . $this->display() . "<br>";
    }
    
    
    function alreadyInPool($name) {
        $query = "select poolName from pool where name1='".$name."' or name2='".$name
                ."' or name3='".$name."' or name4='".$name."' or name5='".$name
                . "' or name6='".$name."'" . "or name7='".$name."'";

        $stmt = $this->database->query($query);
        $array = $stmt->fetch(PDO::FETCH_NUM);
        if ($array == NULL || sizeof($array) == 0)
            return NULL;

        return $array[0];
    }
    
    
    function addName($name, $rank) {
        $result = $this->alreadyInPool($name);
        if ( $result != NULL) {
            $this->poolName = $result;
            return self::$ERROR_EXIST; // name already in pool
        }
        
        // look for the first empty spot
        if (strlen($this->name1) == 0) {  
            $this->name1 = $name;
        }
        else {  
            if (strlen($this->name2) == 0) {
                $this->name2 = $name;
            } else {
                if (strlen($this->name3) == 0) {
                    $this->name3 = $name; 
                } else {
                    if (strlen($this->name4) == 0) {
                        $this->name4 = $name;
                    } else {
                        if (strlen($this->name5) == 0) {
                            $this->name5 = $name;
                        } else {
                            if (strlen($this->name6) == 0) {
                                $this->name6 = $name;
                            } else {
                                if (strlen($this->name7) == 0) {
                                    $this->name7 = $name;
                                } else
                                    return self::$ERROR_FULL; // error - no more room
                            }
                            
                        }
                    }
                }
            }
        }
        // echo "<br> pool dateTime = " . $this->dateTime;
        if ($this->poolRank == 0) {
            $this->poolRank = $rank;
            // echo "<br> ". $this->poolName . " has new rank ".$this->poolRank;
        }
        $this->save();
        return 0;  // successsful
    }
    
    function display() {
        
        return $this->poolName . "<br>" .
                $this->poolRank .  "<br>" .
                 $this->name1 . "<br>" .
                $this->name2 . "<br>" .
                $this->name3 . "<br>" .
                $this->name4 . "<br>" .
                $this->name5 . "<br>" .
                $this->name6 . "<br>" .
                $this->name7 . "<br>" ;
    }
    
    function poolList() {
        
        $columns = "id, poolRank, poolName, name1, name2, name3, name4, name5, name6, name7";
        $query = "select " . $columns . " from pool ORDER by poolName ASC";
        
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
         
        $stmt = NULL;
        $this->database = NULL;
        return $array;
    }
    
    function isEmpty() {
        if ($this->name1 != NULL)
            return FALSE;
        if ($this->name2 != NULL)
            return FALSE;
        if ($this->name3 != NULL)
            return FALSE;
        if ($this->name4 != NULL)
            return FALSE;
        if ($this->name5 != NULL)
            return FALSE;
        if ($this->name6 != NULL)
            return FALSE;
        if ($this->name7 != NULL)
            return FALSE;
        return TRUE;
    }
    
    function removeName($name) {
        if ($name == $this->name1)
            $this->name1 = NULL;
        else if ($name == $this->name2)
            $this->name2 = NULL;
            else if ($name == $this->name3)
                $this->name3 = NULL;
                else if ($name == $this->name4)
                    $this->name4 = NULL;
                    else if ($name == $this->name5)
                        $this->name5 = NULL;
                        else if ($name == $this->name6)
                            $this->name6 = NULL;
                            else if ($name == $this->name7)
                                $this->name7 = NULL;
        if ($this->isEmpty())
            $this->poolRank = 0;
        $this->save();
    }
    
     
    public static function removeNameInPool($poolID, $name) {
        $pool = new Pool();
        $pool->get($poolID);
        $pool->removeName($name);
    }
    
}    
    
?>
    

