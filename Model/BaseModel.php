<?php



class BaseModel {
	protected $database;
	public function __construct() {
            
include $_SERVER["DOCUMENT_ROOT"]."/Mustard/Config/hostdb.php";

            $firstParam = "mysql:host=" . $host . ";dbname=" . $database . ";charset=" . $charset;
            
            try {
		$this->database = new PDO($firstParam, $user, $password);
                $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
	}
        
        
}


