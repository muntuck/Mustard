<?php

require_once(MODEL."/BaseModel.php");
/**
 * Description of Zipcode - put in database
 * For those unknown we should resolve it by doing a web call to 
 * http://ziptasticapi.com/95747
 * and parse the result: {"country":"US","state":"CA","city":"ROSEVILLE"}
 *
 * @author muntu
 */
class Zipcode extends BaseModel{
    
    static $url = "http://ziptasticapi.com/";
    static $zipLength = 5;
    
    public $zipcode;
    public $city;
    
    public static function zipCity($code) {
        $query = "Select city from zipcode where zipcode = " . $code;
        
        if ($code == NULL || strlen($code) < 5)
            return "BAD ZIP";
        
        $row = NULL;
        
        $zip = new Zipcode();
        $stmt = $zip->database->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $city = "Unresolved";
        if ($row == NULL) {
            if (strlen($code) < static::$zipLength)
                $city = "UNKNOWN";
            else {
                $city = Zipcode::resolveFromWeb($code);
                if ($city != NULL) {
                    Zipcode::addToDB($code, $city);
                }
                else
                    $city = "BAD ZIP";
            }
        } else {
            $city = $row['city'];
        }
        
        $stmt = NULL;
        $zip->database = NULL;
        
        return $city;
    }
    
    public static function resolveFromWeb($code) {
        $urlStr = static::$url . $code;
        $result = file_get_contents($urlStr);
        $city = Zipcode::decode($result);
        return $city;
    }
    
    public static function addToDB($code, $city) {
        $query = "Insert into zipcode (zipcode, city) Values (" . $code . ", " . "'" . $city . "')";
        $zip = new Zipcode();
        $stmt = $zip->database->query($query);
        $stmt = NULL;
        $zip->database = NULL;
    }
    
    public static function decode($str) {
        $key = 'city';
        
        $data = json_decode($str, true);
        if (isset($data[$key])) {
            return $data['city'];
        }  
            
        return NULL;
        
    }
}
?>