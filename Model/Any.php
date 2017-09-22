<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Config/parameters.php";

// a class for storing miscelleanous functions
//

    define ("BLANK", " ");
    define ("APOSTROPHE", "'");
    
    define ("FREEZE_RANK", 500);
    
    
class Any {
 
    public static $freeeRank = FREEZE_RANK;
    
    
public static function getFreezeRank() {
    $here = Any::$freezeRank;
    Any::$freeeRank = $here + 1;
    return $here;
}

public static function myRandom() {
    $min = 1;
    $max = 300;
    
    return rand($min, $max);
}
    
// return the date for today in y-m-d based on this location
// 
public static function currentDate() {
    date_default_timezone_set('America/Los_Angeles');
    $todayDate = date("Y-m-d");
    return $todayDate;
}

public static function niceDate() {
    $currentDate = Any::currentDate();
    $mDate = date_format(date_create($currentDate), "D, M d Y");
    return $mDate;
}
    
public static function toSqlDate($anyDate) {
    $str = date("Y-m-d", strtotime($anyDate));
    
   // echo "anyDate = " . $anyDate . " converted to sqlDate = " . $str ."<br>";

    return $str;
}

public static function removeSpecialChars($str) {

    
    return str_replace(APOSTROPHE, BLANK, $str);   
}

public static function httpHost() {
    return "http://" . $_SERVER['HTTP_HOST'];
}

public static function url() {
    $url = "http://" . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];
    return $url;
}

public static function urlReplace($find, $replace) {
    
    $url = "http://" . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];
    $newurl = str_replace($find, $replace, $url);
     
    return "Location:".$newurl;
}

public static function lastFoodDay($nbr) {
    $foodDay = "last " . FOOD_DAY;
    return Any::nextLastDay($foodDay, $nbr);
}

public static function nextFoodDay($nbr) {
    $foodDay = "next " . FOOD_DAY;
    return Any::nextLastDay($foodDay, $nbr);
}

public static function nextLastDay($day, $nbr) {
    $array = array();
    $dt = new DateTime();
    for ($i=0; $i<$nbr; $i++) {
        $dt->modify($day); // last food day
        $f1 = $dt->format('Y-m-d');
        $array[] = $f1;
    }
    return $array;
}


public static function backupMustard() {
    
    include $_SERVER["DOCUMENT_ROOT"]."/Mustard/Config/hostdb.php";
    
    $cmdPath = "c:/wamp/bin/mysql/mysql5.7.11/bin/";
        
    $backupFile = $dbname . date("Y-m-d-H-i-s") . '.sql';
    $command = $cmdPath . "mysqldump --opt -h " . $host 
               . "-u " . $user 
               . "-p " . $password ." " . $database . " > " . $backupFile;
    system($command);

}
    
}
?>
    

