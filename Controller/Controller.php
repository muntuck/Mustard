<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";
require VIEW."View.php";
require VIEW."Statistics.php";
require MODEL."Any.php";
require MODEL."VDate.php";
require MAIL."Mailgo.php";
require MODEL."Today.php";

class Controller {
	
    public function __construct() {  
    } 
    
    public function invoke() {
        
        if (!isset($_GET['cmd'])) {
            include 'view/home.php';
	}
	else {
            switch ($_GET['cmd']) {
                
            case 100: // 'existing': 
                $content = EXISTING_HELP;
                if (isset($_GET['lastName'])) { 
                    $lastName = $_GET['lastName'];
                    $firstName = $_GET['firstName'];
                    $active = $_GET['active'];
                    $content = View::existList($lastName, $firstName, $active);
                }
                $sideContent = View::existParameters();
                $title="Existing Clients";
                include TEMPLATE."mTemplate.php";
                break;
                
            case 200: // 'new':                              
                $content = View::newClient();
                $sideContent =  DATE_FORMAT . LAYAWAY_HELP;
                $title = "New Client";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 205: // 'newClient':
                $client = new Client();
                $birthdate = Any::toSqlDate($_GET['birthDate']);
                $client->set(0, $_GET['firstName'], $_GET['lastName'], 
                        $birthdate, $_GET['gender'], 
                        $_GET['nbrOver18'], $_GET['nbr6To17'], $_GET['nbrUnder5'],        
                        $_GET['street'], $_GET['apartment'], $_GET['city'], $_GET['state'], $_GET['zip'], 
                        $_GET['phone'], $_GET['email'], "",
                        $_GET['churchMember'], $_GET['type'], $_GET['lifescan'],
                        $_GET['layawaySponsor'],$_GET['sponsorID'], 'Y') ;
                $client->save();
                
                $redirect = "Location: ".Any::httpHost().
                        "/Mustard/index.php?cmd=215&clientID=".$client->id;
                header($redirect);
                break;
            
            case 210: // 'updateClient':
                $clientID = $_GET['clientID'];
                $birthdate = Any::toSqlDate($_GET['birthDate']);
                $client = new Client();
                $client->set($clientID, $_GET['firstName'], $_GET['lastName'], 
                        $birthdate, $_GET['gender'], 
                        $_GET['nbrOver18'], $_GET['nbr6To17'], $_GET['nbrUnder5'],        
                        $_GET['street'], $_GET['apartment'], $_GET['city'], $_GET['state'], $_GET['zip'], 
                        $_GET['phone'], $_GET['email'], "",
                        $_GET['churchMember'], $_GET['type'], $_GET['lifescan'],
                        $_GET['layawaySponsor'],$_GET['sponsorID'], $_GET['active'] );
                $client->update();
                
                $redirect = "Location: ".Any::httpHost().
                        "/Mustard/index.php?cmd=215&clientID=".$clientID;
                header($redirect);
                break;
            
            
            case 213: // store the file and name of file
                $clientID = $_GET['clientID'];
                $photoFile = $_GET['photoFile'];
                $client = new Client();
                $client->addPhoto($clientID, $photoFile); // this will do an update
                $redirect = "Location: ".Any::httpHost().
                        "/Mustard/index.php?cmd=215&clientID=".$clientID;
                header($redirect);
                break;
            
            case 215: // 'getClient':
                $clientID = $_GET['clientID'];
                $client = new Client();
                $client->get($clientID);
                $arr = View::client($client);
                $title = "GetClient";
                $content = $arr[0];
                $sideContent = $arr[1];
                include TEMPLATE."mTemplate.php";
                break;
            
            case 220: // 'editClient' : 
                $clientID = $_GET['clientID'];
                $client = new Client();
                $client->get($clientID);
                $content = View::editClient($client);
                $sideContent =  DATE_FORMAT . LAYAWAY_HELP;
                $title = "Edit Client";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 225: // 'visits' : 
                $clientID = $_GET['clientID'];
                $visit = new Visit();
                $array = $visit->visitList($clientID);
                $content = View::visitList($array);
                $sideContent = "nothing here yet";
                $title = "Visits";
                include TEMPLATE."mTemplate.php";
                break;
                                    
            case 230: //'household' : 
                $clientID = $_GET['clientID'];
                $household = new Household();
                $array = $household->householdList($clientID);
                $content = View::householdList($clientID, $array);
                $sideContent = "display persons in household";
                $title = "Household Display";
                include TEMPLATE."mTemplate.php";
                break;
                        
            case 235: //'editHousehold' : 
                $householdID = $_GET['id'];
                $household = new Household();
                $household->get($householdID);
                $content = View::householdPerson($household);
                $sideContent =  DATE_FORMAT;
                $title = "Household Edit";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 240: //'updateHousehold' :
                $householdID = $_GET['householdID'];
                $clientID = $_GET['clientID'];
                $name = $_GET['name'];
                $relationship = $_GET['relationship'];
                $birthdate = Any::toSqlDate($_GET['birthdate']);
                $household = new Household();
                $household->set($householdID, $clientID, $name, $birthdate, $relationship);
                $household->update();
                
                $redirect = "Location: ".Any::httpHost().
                        "/Mustard/index.php?cmd=230&clientID=".$clientID;
                header($redirect);
                break;

            case 245: //'addHousehold' : 
                $clientID = $_GET['clientID'];
                $content = View::addHousehold($clientID);
                $title = 'Household Add';
                $sideContent = "Add a person to household. Birthdate is required even if estimate <br>" .
                " Main purpose is to get the age. Relationship is optional ";
                include TEMPLATE."mTemplate.php";
                break;

            case 250: //'newHousehold' :
                $clientID = $_GET['clientID'];
                $name = $_GET['name'];
                $relationship = $_GET['relationship'];
                $birthdate = date("Y-m-d", strtotime($_GET['birthDate']));
                $household = new Household();
                $household->set(0, $clientID, $name, $birthdate, $relationship);
                $household->save();
                
                $redirect = "Location: ".Any::httpHost().
                        "/Mustard/index.php?cmd=230&clientID=".$clientID;
                header($redirect);
                break;
            
               
            case 260: // 'notes' : 
                $clientID = $_GET['clientID'];
                // $authorInitials = $_GET['authorInitials']; Need a way to get author's initials
                $note = new Note();
                $array = $note->allNotes($clientID);
                $arr = View::notes($clientID, $array);
                $content = $arr[0];
                $sideContent = $arr[1];
                $title = "Notes 1";
                include TEMPLATE."mTemplate.php";  
                break;
            
            case 265: //'addNote' :
                $clientID = $_GET['clientID'];
                $authorInitials = $_GET['author']; 
                $note1 = $_GET['note'];
                $note = new Note();
                $note->add($clientID, $authorInitials, $note1);
                
                $redirect = "Location: ".Any::httpHost().
                        "/Mustard/index.php?cmd=260&clientID=".$clientID;
                header($redirect);
                break;
            
                        
            case 300: // 'checkinList': 
                $currentDate = Any::currentDate();
                $mDate = Any::niceDate();
                // $client = new Client();
                $array = Today::checkinList();
                $arr = View::checkinList($array);
                $content = $arr[0];
                $sideContent =  "<b>" .$mDate . "</b><br><br>" .
                             "<h4># clients checked in = " . $arr[1] ."</h4><br><br>";
                $freeze = new State();
                if ($freeze->isFreeze())
                    $sideContent = $sideContent . "<h4>Client checkin List is FROZEN. </h4> "
                        . "<h5>New checkins will be added to the back of this list</h5><br>";
                
                $title = "Checkin List";
                // refresh the web page every 3 seconds
                header("Refresh: 3");
                include TEMPLATE."mTemplate.php";
                break;
                
            case 304: // randomize and freeze
                $title = "Randomize and Freeze";
                $currentDate = Any::currentDate();
                $freeze = new State();
                $content = "";
                $sideContent = "";
                if ($freeze->isFreeze()) {
                    $sideContent = $sideContent 
                            . "<h4> WARNING ......... </h4>"
                            . "<b>The client list is already Frozen. </b>";
                } else {
                    $sideContent = $sideContent
                            . "<b>When to freeze</b><br>"
                            . "Either after 20 mins of checkin or the first 30 people checkin"
                            . "<br><br>"
                            . "The process of freezing the list is actually two steps:<br>"
                            . "1. Client checkin list is randomize.<br>"
                            . "2. The randomized list is then displayed in groups. "
                            . "<br>    Default is 5.<br><br>"
                            . "If the freeze is done in error, go to Utility to unfreeze";
                    $content = $content 
                            . "<h4>Command to freeze the client checkin</h4>"
                            . View::randomizeParam($currentDate, "Freeze Client Checkin");
                }
                include TEMPLATE."mTemplate.php";
                break;
            
            case 305:  // Freezing the client list
                $forDate = $_GET['forDate'];
                $nbrPerGroup = $_GET['nbrPerGroup'];
                $state = new State();
                if (!$state->isFreeze()) {
                    $title = "Freeze Client";
                    $client = new Client(); 
                    // $array = $client->randomize($forDate); 
                    $array = Today::rankPriorityList();
                    $content = View::rankList($array, $nbrPerGroup);
                    $state->setFreeze(1);
                    $state->setNbrPerGroup($nbrPerGroup);
                    $state->save();
                    $sideContent = "<h4>Client List is now Frozen</h4>" 
                            . "Incoming clients will be added to the end of the list. <br>"
                            . "No pool is required.<br><br> To unfreeze go to utility<br><br>";
                    $sideContent = $sideContent . View::displayFrozen("Refresh");
                    include TEMPLATE."mTemplate.php";
                } else {              
                    // redirect to the frozen page
                    header(Any::urlReplace('305','309'));
                }
                break;
                
            case 309 : // display Frozen List
                $currentDate = Any::currentDate();
                $state = new State();
                if ($state->isFreeze()) {
                    // $client = new Client();
                    // $array = $client->rankList();
                    $array = Today::rankPriorityList();
                    $content = View::rankList($array, $state->getNbrPerGroup());
                    $sideContent = "Click on Refresh to get an updated list<br><br> "
                            . View::displayFrozen("Refresh");
                }
                else {
                    $content = "<h3>List is not frozen. <br>Wait for list to be frozen<h3>";
                    $sideContent = "<h4>When to freeze is dependent on your choice</h4>";
                }
                
                $title = "Frozen 2";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 310 :  //freeze
                $forDate = $_GET['forDate'];
                $nbrPerGroup = $_GET['nbrPerGroup'];
                $freeze = new State();
                $freeze->setFreeze(1);
                $freeze->setNbrPerGroup($nbrPerGroup);
                $freeze->save();
                $client = new Client();
                $array = $client->rankList();
                $content = View::rankList($array, $nbrPerGroup);
                $title = "Display Frozen";
                $sideContent = "<h4>Display of Frozen List </h4>" 
                        . "<b> New client checkins will be tagged to the back of this list. <br><br>" 
                        . View::displayFrozen($forDate, $nbrPerGroup, "Refresh");
                include TEMPLATE."mTemplate.php";
                break;
            
            case 311: // show status 
                $content = State::statusString();
                $sideContent = "<h4>Do you know what to do?</h4>";
                $title = "State Status";
                include TEMPLATE."mTemplate.php";  
                break;

            case 315: // 'resetFreeze' :
                $state = new State();
                $state->setFreeze(0);
                $state->save();
                Today::unfreeze();
                $content = "<h3>Freeze is OFF</h3>";
                $sideContent = "<h4>Checkin list is now open</h4>";
                $title = "Reset Freeze";
                include TEMPLATE."mTemplate.php";        
                break;
            
            case 316: // reset Counter to some number
                $state = new State();
                $state->setCounter(1);
                $state->save();
                $content = "Counter is set to 1";
                $sideContent = "Now things are back to starting point";
                $title = "Reset Counter";
                include TEMPLATE."mTemplate.php";        
                break;
            
            case 317: // reset everything - resetAll
                $yes = FALSE;
                if (isset($_GET['yes']))
                    $yes = TRUE;
                if ($yes) {
                    $state = new State();
                    $state->setCounter(1);
                    $state->setFreeze(0);
                    $state->save();
                    $pool = new Pool();
                    $pool->reset();
                    $visit = new Visit();
                    $visit->removePool($forDate = Any::currentDate());
                    Today::removeAll();  // remove all entries in Today
                    
                    $content = State::statusString();
                    $sideContent = "<h4>Now you are at the start of a new checkin.<h4> ";
                } else {
                    $content = "click below if you are sure you want to reset Checkin counter <br><br>" 
                        . "<b>Current state :: </b><br><br>"
                        . State::statusString() . "<br>"
                        . "<center><form action='/Mustard/index.php'>"
                        . "<input type='hidden' name='cmd' value='317'>" 
                        . "<input type='hidden' name='yes' value='1'>" 
                        . "<input type = 'submit' class='button'"
                            . " value='Reset CheckinCounter and Freeze'></form></center>";
                    $sideContent = "<h4>BEWARE: reset will set checkin counter to 1, and Freeze to OFF</h4>";
                }
                $title = "ResetAll";
                include TEMPLATE."mTemplate.php";        
                break;
            
            case 318: // remove all layaway - for cases where each set of layaways are different
                $yes = FALSE;
                if (isset($_GET['yes']))
                    $yes = TRUE;
                if ($yes) {
                    $client = new Client();
                    $client->removeLayaway();
                    $content = "<br><h4>All layaways are removed. </h4>";
                    $sideContent = "<h4>Are you happy?</h4>";
                }
                else {
                    $content = "Click on the link below to remove all layaway <br><br>"
                            . "<center><a href='/Mustard/index.php?cmd=318&yes=1'><h4>"
                            . "Remove all layaways<h4></a></center>";
                    $sideContent = "<h4>BEWARE: there is no turning back on remove</h4>";
                }
                $title = "Remove Layaway";
                include TEMPLATE."mTemplate.php";        
                break;
             
            case 319: // remove all checkin - actual removal
                $checkinDate = $_GET['checkinDate'];
                $pin = $_GET['pin'];
                if ($pin == CHECKIN_PIN) {
                    $visit = new Visit();
                    $content = $visit->removeCheckin($checkinDate);
                    $sideContent = "<h4>All visits or checkins for this specified date: " . $checkinDate
                        . " are gone. <br><br>Too late. <br>There is no recovery </h4> <br><br>";
                } else {
                    $content = "<h4> Access Denied </h4>";
                    $sideContent = "<h4> Not allowed to remove checkin</h4>";
                }
                $title = "Remove Checkins";
                include TEMPLATE."mTemplate.php";        
                break;
            
            case 320:  //'preCheckin' :
                $clientID = $_GET['clientID'];
                $lastName = $_GET['lastName'];
                $firstName = $_GET['firstName'];
                $name = $firstName . " " . $lastName;
                        
                $client = new Client();
                $htotal = $client->housetotal($clientID);
                $visit = new Visit();
                $poolName = "";
                $visit->create($clientID, TRUE);
                $state = new State();
                if ($state->isFreeze()) {
                    $rank = FREEZE_RANK;  // declaration is in file Any.php
                }
                else {
                    $rank = Any::myRandom ();
                }
                
                Today::add($name, $htotal, $visit->number, $rank, $poolName, $visit->dateTime, $clientID );
                
                if ($state->isFreeze()) {                    
                    // $state->addToRankList($firstName . " " . $lastName, 99, 0, $visit->number, $htotal);
                    $sideContent = View::existParameters();
                    $content = "<h4>" . $firstName .  " " . $lastName . " is checked in and added to end of Frozen List</h4>";
                    $title="Existing Clients";
                } else {
                    $pool = new Pool();
                    $array = $pool->poolList();
                    $content = View::selectThisPool($clientID, Today::getRankOfClient($clientID),
                            $lastName, $firstName, $array);
                    $sideContent = "<b>" . $firstName .  " " . $lastName . " is checkin with tag #".$visit->number." </b>"
                            . "<br><br>Does the client come in a car pool? "
                            . "<br><br> IF YES, click on 'select' on the left pane for that pool"
                            . "<br><br> If NO, just click on 'Continue' "
                            . "<br>Leave the pool selection to 'NONE'."
                            . View::justContinue($visit->id, $lastName, $firstName);
                    $title = "Checkin";
                }
                include TEMPLATE."mTemplate.php";
                break;
            
            case 322: // show pool to add after checkin
                $clientID = $_GET['clientID'];
                $lastName = $_GET['lastName'];
                $firstName = $_GET['firstName'];
                $forDate = $_GET['forDate'];
                
                // $visit = new Visit();
                // $visitID = $visit->visitID($clientID, $forDate);
                $clientRank = Today::getRankOfClient($clientID);
                $pool = new Pool();
                $array = $pool->poolList();
                $content = View::selectThisPool($clientID, $clientRank, $lastName, $firstName, $array);
                $sideContent = View::selectPool($clientRank, $lastName, $firstName, $array);
                $title = "Pool";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 325: //'vcheckin' : volunteer checkin
                $clientID = $_GET['clientID'];
                $marker = $_GET['marker'];
                $visit = new Visit();
                $visit->create($clientID, FALSE);
                
                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=400&marker=".$marker ;
                header($redirect);
                break;
            
            case 327: // staff checkin
                $clientID = $_GET['clientID'];
                $marker = $_GET['marker'];
                $visit = new Visit();
                $visit->create($clientID, FALSE);
                
                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=440&marker=".$marker ;
                header($redirect);
                break;
            
            case 330: //'lcheckin' :
                $clientID = $_GET['clientID'];
                $visit = new Visit();
                $visit->create($clientID, FALSE);
                
                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=500";
                header($redirect);
                break;
            
            case 333: // present the remove CLIENT checkin view
                $currentDate = Any::currentDate();
                $mDate = Any::niceDate();
 
                // $client = new Client();
                // $array = $client->allCheckin($currentDate);
                $array = Today::checkinList(); // only clients, no volunteer or layaway
                $arr = View::AllCheckinView($array, $currentDate, "CLIENT");
                $content = $arr;
                $sideContent = "Remove CLIENT checkin:  <b><br>" . $mDate . "<b>";
                $title = "Remove CLIENT checkin";
                include TEMPLATE."mTemplate.php";   
                break;
            
            case 334: // do the actual remove
                $clientID = $_GET['clientID'];
                $forDate = $_GET['forDate'];
                $number = $_GET['number'];
                $visit = new Visit();
                $visitID = $visit->visitID($clientID, $forDate);
                $client = new Client();
                $client->get($clientID);
                if ($visitID != 0) {
                    $visit->get($visitID);
                    if ($visit->poolID != 0) {
                        $name = $client->nameFirstLast($clientID);
                        Pool::removeNameInPool($visit->poolID, $name);
                    }
                }
                $visit->remove($clientID, $forDate);
                if ($client->type == 'C')
                    Today::remove($clientID);
                 
                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=333";
                header($redirect);
                break;
                
            case 338:    // remove VOLUNTEER checkin              
                $currentDate = Any::currentDate();
                $mDate = Any::niceDate();
 
                $client = new Client();
                $array = $client->volunteerCheckin($currentDate);
                // $array = Today::checkinList(); // only clients, no volunteer or layaway
                $arr = View::AllCheckinView($array, $currentDate, "VOLUNTEER");
                $content = $arr;
                $sideContent = "Remove VOLUNTEER checkin:  <b><br>" . $mDate . "<b>";
                $title = "Remove VOlunteer checkin";
                include TEMPLATE."mTemplate.php";   
                break;
            
            case 340: // 'resetPool' :
                $pool = new Pool();
                $pool->reset();
                $visit = new Visit();
                $visit->removePool($forDate = Any::currentDate());
                $pool = new Pool();
                $array = $pool->poolList();
                $content = View::showPool($array);
                $sideContent = "<br>The pool has been cleared.";
                $title = "Reset Pool";
                include TEMPLATE."mTemplate.php";        
                break;
            
            case 345: // 'addToPool' :
                $clientID = $_GET['clientID'];
                $clientRank = $_GET['clientRank'];
                $name = $_GET['name'];
                $poolID = $_GET['poolID'];

                if ($poolID != 0) {                      
                    $pool = new Pool();
                    $pool->get($poolID);
                    $sideContent = "";
                    $result = $pool->addName($name, $clientRank);
                    // after an addName, the poolRank may change
                    if ($result != 0) {
                        if ($result == Pool::$ERROR_EXIST)
                            $sideContent = "<h4><font color='red'>ERROR: " . $name 
                                ." is already in Pool " . $pool->poolName . " </font></h4>";
                        if ($result == Pool::$ERROR_FULL) {
                            $sideContent = "<h4><font color='red'>ERROR: No more room in Pool "
                                    . $pool->poolName . " </font></h4>";
                        }
                    } else {
                        $visit = new Visit();
                        $visitID = $visit->visitID($clientID, Any::currentDate());
                        $visit->get($visitID);
                        $visit->poolID = $poolID;
                        $visit->update();
                        Today::addPoolName($clientID, $pool->poolName, $pool->poolRank);
                    }
            
                    $pool = new Pool();
                    $array = $pool->poolList();
                    $content = View::showPool($array);
                    $sideContent = $sideContent . View::existParameters();
                    $title = "Pool";

                } else {
                    $sideContent = View::existParameters();
                    $content = "<h4>" . $name . " is checked in </h4>";
                    $title="Existing Clients";
                }
                include TEMPLATE."mTemplate.php";                
                break;
                
            case 350:  // show the pool
                $pool = new Pool();
                $array = $pool->poolList();
                $content = View::showPool($array);
                $sideContent = "<h4>Display of Pool. To edit pool go to 'Cleanup->editPool'</h4>";
                        
                $title = "Show Pool";
                include TEMPLATE."mTemplate.php";    
                break;
            

            case 400: // 'volunteers' :
                $marker = "";
                if (isset($_GET['marker']))
                    $marker = $_GET['marker'];
                $forDate = Any::currentDate();
                $client = new Client();
                $array = $client->volunteerList();
                $arr = View::volunteerList($array, $forDate);
                        
                $content =  $arr[0];
                $sideContent = "<script> "
                        . "document.getElementById('".$marker ."').scrollIntoView();"
                        ."</script>";
                $sideContent = $sideContent . "<h4>" . Any::niceDate() 
                        ."<br># Volunteers Checked IN : " . $arr[1] . "</h4>"
                        . View::SummaryTodaySignup($forDate)
                        . "<br><br>"
                        . View::findInPage();
                      
                $title = "Volunteer Checkin";
                include TEMPLATE."mTemplate.php";  
                break;
            
            case 410: // 'mark the volunteer date and then go back to volunteer list :
                $clientID = $_GET["clientID"];
                $forDate = $_GET["vdate"];
                $vDate = new VDate();
                $vDate->create($clientID, $forDate);
                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=400";
                header($redirect);
                break;
            
            case 430: // signup for volunteer to different shifts              
                $marker="";
                if (isset($_GET['marker']))
                    $marker = $_GET['marker'];
                $forDate = Any::currentDate();
                $client = new Client();
                $array = $client->volunteerList();
                $arr = View::volunteerSignup($array, $forDate);
                $content = $arr;
                $sideContent = "<script> "
                        . "document.getElementById('".$marker ."').scrollIntoView();"
                        ."</script>" ;
                $sideContent = $sideContent . "<h3>Today is ". Any::niceDate() . "</h3>"
                        . "<b>Signup for the next 3 weeks</b>" . View::summarySignup();
                        
                $title = "Volunteer Signup";
                include TEMPLATE."mTemplate.php";   
                break;
            
            case 431: // execute the update for volunteer signup
                $clientID = $_GET['clientID'];
                // $forDate = Any::currentDate();
                $marker="";
                if(isset($_GET['marker'])) {
                    $marker = $_GET['marker'];
                }
                if(isset($_GET['shift'])) {
                     $shiftArray = $_GET['shift'];
                     VDate::update($clientID, $shiftArray);                       
                } else {
                     // if there is no shiftArray then we remove all signons for this volunteer
                     VDate::removeAll($clientID);
                }

                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=430&marker=".$marker;
                header($redirect);
                break;
                
            case 440: // checkin staff
                $marker = "";
                if (isset($_GET['marker']))
                    $marker = $_GET['marker'];
                $forDate = Any::currentDate();
                $client = new Client();
                $array = $client->staffList();
                $arr = View::staffList($array, $forDate);
                        
                $content =  $arr[0];
                $sideContent = "<script> "
                        . "document.getElementById('".$marker ."').scrollIntoView();"
                        ."</script>";
                $sideContent = $sideContent . "<h4>" . Any::niceDate() 
                        ."<br># Staff Checked IN : " . $arr[1] . "</h4>";
                        
                      
                $title = "Staff Checkin";
                include TEMPLATE."mTemplate.php";  
                break;
                
            
            case '500' :
                $forDate = Any::currentDate();
                $client = new Client();
                $array = $client->layawayList();
                $arr = View::layawayList($array, $forDate);
                $content = $arr[0];
                $sideContent = "<h4>" . Any::niceDate() ."<br><br># Layaways delivery : " . $arr[1] . "<h4><br>";
                $title = "Layaways";
                include TEMPLATE."mTemplate.php";   
                break;
            
            case 550: // move a client to be the first
                $currentDate = Any::currentDate();
                $mDate = Any::niceDate();
                $array = Today::checkinList(); // only clients, no volunteer or layaway
                $arr = View::MoveToFront($array, $currentDate);
                $content = $arr;
                $sideContent = "Move this client up to the front:  <b><br>" . $mDate . "<b>";
                $title = "Reprioritize Client";
                include TEMPLATE."mTemplate.php";   
                break;
            
            case 551: // reprioritize this client to the top of the chain
                $clientID = $_GET['clientID'];
                $forDate = $_GET['forDate'];
                $number = $_GET['number'];
                
                // action: set the priority to 0 - the top of the chain
                // client is in Today list
                Today::moveToFront($clientID);
                 
                $redirect = "Location: ".Any::httpHost()."/Mustard/index.php?cmd=550";
                header($redirect);
                break;
            
            case 600: // display pool to select for edit :
                $pool = new Pool();
                $array = $pool->poolList();
                $content = View::showPoolForRemoval($array);
                $sideContent = "Select the pool for edit";
                $title = "Pool for removal";
                include TEMPLATE."mTemplate.php";  
                break;
            
            case 601: // display the selected pool to remove a name
                $poolID = $_GET['poolID'];
                $pool = new Pool();
                $array = $pool->poolList();
                $content = View::showPoolForRemoval($array);
                $sideContent = View::showSelectedPoolForEdit($poolID);
                $title = "Select Pool to edit";
                include TEMPLATE."mTemplate.php";  
                break;
            
            case 602: // remove the name and go back to display pool
                $poolID = $_GET['poolID'];
                $name = $_GET['name'];
                Pool::removeNameInPool($poolID, $name);
                Visit::removeThisPool($poolID, $name); // assume today
                Today::removePool($name);
                $pool = new Pool();
                $array = $pool->poolList();
                $content = View::showPool($array);
                $sideContent = "<h4>Pool after a removal</h4>";
                $title = "After a name removal";
                include TEMPLATE."mTemplate.php";  
                break;
            
            case 700: // families and bags' - get parameters :
                $content = Statistics::statsParameters();
                $sideContent = "provide the date range of report";
                $title = "Usage Statistics 1";
                include TEMPLATE."mTemplate.php";    
                break;
            
            case 701: // families and bags - produce the report :
                $fromDate = $_GET['fromDate'];
                $toDate = $_GET['toDate'];

                $content = Statistics::usageStatistics($fromDate, $toDate);
                $sideContent = "Statistics required by Placer County Food Bank<br><br>  "
                        . "Bag multiplier = " . BAG_MULTIPLIER 
                        . "<br><br>Meal multiplier = " . MEAL_MULTIPLIER;
                $title = "Families and bags";
                include TEMPLATE."mTemplate.php";    
                break;
            
            case 710: // zip area
                $client = new Client();
                $array = $client->zipcodeStats();
                $content = Statistics::zipStats($array);
                $sideContent = "<h4> If you see 'unknown' in zip area, please inform me </h4>";
                $title = "zipcode statistics ";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 720: // Lifescan
                $client = new Client();
                $arrayWL = $client->VolunteerWithLifescan();
                $client = new Client();
                $arrayWOL = $client->VolunteerWithOutLifescan();
                $array2 = View::DisplayVolunteerLifescan($arrayWL, $arrayWOL);
                $sideContent = $array2[0];
                $content = $array2[1];
                $title = "Lifescan Report ";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 730: // report on volunteers coming next week
                $forDate = Any::currentDate();
                $day = Any::nextFoodDay(1);
                $content = "<b><center>Volunteers for next week: " . $day[0] ."<center></b><br>" . View::volunteersNextWeek();
                
                $sideContent = "<h3>Today is ". $forDate . "</h3>"
                        . "<b>Signup for the next 3 weeks</b>" . View::summarySignup();
                $title = "Volunteers next week";
                include TEMPLATE."mTemplate.php";
                break;
            
            case 800: // Reminders to Volunteers - ask to send
                $content = View::volunteersNextWeek();
                $sideContent = View::toSendEmail();
                $title = "Reminders to Volunteers ";               
                include TEMPLATE."mTemplate.php";
                break;
            
            case 801: // Reminders to Volunteers
                $forDate = $_GET['forDate'];
                $array = View::sendReminders($forDate);
                $content = $array[0];
                $sideContent = $array[1];
                $title = "Results of Mail Reminders to Volunteers ";               
                include TEMPLATE."mTemplate.php";
                break;
                       
            case 900: // Queries on clients
                $content = "<h4>Finding out about client's visits.</h4>"
                        . "Every time a client comes to the Center is defined as a visit.";
                $sideContent = "<b>Client Queries </b><br><br>" . Statistics::clientQueries();
                $title = "Query Client ";
                include TEMPLATE."mTemplate.php";
                break;
                
            case 901: // clients with their visits
                $nbr = intval($_GET['number']);
                if ($nbr == 0)
                    $nbr = 5;
                $content = "<b>Client with Visits greater than " . $nbr ."</b><br>" . View::clientVisitsGreater($nbr);
                $sideContent = "<b>Client Queries </b><br><br>" . Statistics::clientQueries();
                $title = "Client and Visits";
                include TEMPLATE."mTemplate.php";
                break;
                
            case 902: // clients visits less than
                $nbr = intval($_GET['number']);
                if ($nbr == 0)
                    $nbr = 5;
                $content = "<b>Client with visits less than " . $nbr ."</b><br>" . View::clientVisitsLess($nbr);
                $sideContent = "<b>Client Queries </b><br><br>" . Statistics::clientQueries();
                $title = "Client and Visits";
                include TEMPLATE."mTemplate.php";
                break;
                
            case 903: // clients with household greater than
                $nbr = intval($_GET['number']);
                if ($nbr == 0)
                    $nbr = 5;
                $content = "<b>Client with household greater than " . $nbr ."</b><br>" . View::clientHouseholdGreater($nbr);
                $sideContent = "<b>Client Queries </b><br><br>" . Statistics::clientQueries();
                $title = "Client and Visits";
                include TEMPLATE."mTemplate.php";
                break;    
            
            case 904: // clients household less than
                $nbr = intval($_GET['number']);
                if ($nbr == 0)
                    $nbr = 5;
                $content = "<b>Client with household less than " . $nbr ."</b><br>" . View::clientHouseholdLess($nbr);
                $sideContent = "<b>Client Queries </b><br><br>" . Statistics::clientQueries();
                $title = "Client and Visits";
                include TEMPLATE."mTemplate.php";
                break;
                
            case 905: // clients with children
                $content = "<b>Client with children </b><br>" . View::clientWithChildren();
                $sideContent = "<b>Client Queries </b><br><br>" . Statistics::clientQueries();
                $title = "Client and Visits";
                include TEMPLATE."mTemplate.php";
                break;    
            
                case 950: // Queries on volunteers
                $content = "Query on volunteers - data mining";
                $sideContent = "Feature is coming soon";
                $title = "Query Volunteer ";
                include TEMPLATE."mTemplate.php";
                break;
            
            default:
                $content = "<br><h3>ERROR: unknown cmd = " . $_GET['cmd'] ."</h3><br>" ;
                $sideContent = "<h3> Report this error to muntuck@gmail.com </h3>";
                $title = "Unknown Command";
                include TEMPLATE."mTemplate.php";
                break;    
            }
        }
    }
}

