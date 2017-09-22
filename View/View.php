<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";

require(MODEL."/Client.php");
require(MODEL."/Household.php");
require(MODEL."/Note.php");
require(MODEL."/Visit.php");
require(MODEL."/Pool.php");
require(MODEL."/State.php");
require(CONFIG."/parameters.php");


class View {
    
    
    public static function clientVisitsLess($nbr) {
        $visit = new Visit();
        $array = $visit->visitsLess($nbr);
        $str0 = "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center>Name of client</center></th> " .
                    "<th class=\"row-Small\"><center>Visits</center></th>" .
                "</tr>" ;
        foreach ($array as $row) {
            $name = $row[0] . " " . $row[1];
            $nbr = $row[2];
            $str0 = $str0
            . "<tr>"  
                . "<td>" . $name .  "</td>"
                . "<td><center>" . $nbr . "</center></td>"
            . "</tr>";
        }
        $str0 = $str0 . "</table>";
        return $str0;
    }
    
    public static function clientVisitsGreater($nbr) {
        $visit = new Visit();
        $array = $visit->visitsGreater($nbr);
        $str0 = "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center>Name of client</center></th> " .
                    "<th class=\"row-Small\"><center>Visits</center></th>" .
                "</tr>" ;
        foreach ($array as $row) {
            $name = $row[0] . " " . $row[1];
            $nbr = $row[2];
            $str0 = $str0
            . "<tr>"  
                . "<td>" . $name .  "</td>"
                . "<td><center>" . $nbr . "</center></td>"
            . "</tr>";
        }
        $str0 = $str0 . "</table>";
        return $str0;
    }
    
    
    public static function clientHouseholdGreater($nbr) {
        $client = new Client();
        $array = $client->householdGreater($nbr);
        $str0 = "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center>Name of client</center></th> " .
                    "<th class=\"row-Small\"><center>Household</center></th>" .
                "</tr>" ;
        foreach ($array as $row) {
            $name = $row[0] . " " . $row[1];
            $nbr = $row[2];
            $str0 = $str0
            . "<tr>"  
                . "<td>" . $name .  "</td>"
                . "<td><center>" . $nbr . "</center></td>"
            . "</tr>";
        }
        $str0 = $str0 . "</table>";
        return $str0;
    }
    
    
    public static function clientHouseholdLess($nbr) {
        $client = new Client();
        $array = $client->householdLess($nbr);
        $str0 = "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center>Name of client</center></th> " .
                    "<th class=\"row-Small\"><center>Household</center></th>" .
                "</tr>" ;
        foreach ($array as $row) {
            $name = $row[0] . " " . $row[1];
            $nbr = $row[2];
            $str0 = $str0
            . "<tr>"  
                . "<td>" . $name .  "</td>"
                . "<td><center>" . $nbr . "</center></td>"
            . "</tr>";
        }
        $str0 = $str0 . "</table>";
        return $str0;
    }
    
    
    public static function clientWithChildren() {
        $client = new Client();
        $array = $client->withChildren();
        $str0 = "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center>Name of client</center></th> " .
                    "<th class=\"row-Small\"><center># Children</center></th>" .
                "</tr>" ;
        foreach ($array as $row) {
            $name = $row[0] . " " . $row[1];
            $nbr = $row[2];
            $str0 = $str0
            . "<tr>"  
                . "<td>" . $name .  "</td>"
                . "<td><center>" . $nbr . "</center></td>"
            . "</tr>";
        }
        $str0 = $str0 . "</table>";
        return $str0;
    }
    
    
    public static function toSendEmail() {
        $nextFoodDay = Any::nextFoodDay(1);
        $str1 = "<script>"
                . "function displayBox() {"
                . "  alert('Click OK below to start, and wait for the next screen');"
                . "}"
                . "</script>"
                . "<h4>Send email to volunteers for next Food Day  " . $nextFoodDay[0] . "</h4>"
            . "<form action = '/Mustard/index.php'>" 
            .  "<input type='hidden' name='cmd' value='801'>" 
            .  "<input type='hidden' name='forDate' value='" . $nextFoodDay[0] . "'>" 
            . "<input type = 'submit' class='button' value='Send Reminders' "
                . "onClick='return window.confirm(\"Send email reminders. Are you sure?\");'>" 
            . "</form>" 
                . "<br><br><br>It will take a few minutes to send the email. <br><br><b>Wait for the next screen.</b> ";
        return $str1;
    }
    
    public static function volunteersNextWeek() {
        
        $nextFoodDay = Any::nextFoodDay(1);
        $vdate = new VDate();
        $array = $vdate->getForThisDate($nextFoodDay[0]);
        
        $str0 = "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Small\"><center>Person</center></th> " .
                    "<th class=\"row-Action\"><center>email</center></th>" .
                    "<th class=\"row-Small\"><center>Shifts</center></th>" .
                "</tr>" ;
        
        foreach ($array as $row) {
            $fname = $row[0];
            $lname = $row[1];
            $shift1 = $row[2];
            $shift2 = $row[3];
            $shift3 = $row[4];
            $email = $row[5];
        
            $str0 = $str0
            . "<tr>"  
                . "<td>" . $fname . " " . $lname . "</td>"
                . "<td>" . $email . "</td>"
                . "<td>";
            
            if ($shift1 == 1)
                $str0 = $str0 . " " .SHIFT_1;
            if ($shift2 == 1)
                $str0 = $str0 . " " .SHIFT_2;
            if ($shift3 == 1)
                $str0 = $str0 . " " .SHIFT_3;
            $str0 = $str0 . "</td> </tr>";
        }
        $str0 = $str0 . "</table>";
        
        return $str0;
    }
    
    
    public static function justContinue($visitID, $lastName, $firstName) {
        $name = $firstName . " " . $lastName;
        $str = "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value='345' >" . 
              "<input type='hidden' name='clientID' value='0' >" . 
              "<input type='hidden' name='clientRank' value='0' >" . 
              "<input type='hidden' name='name' value='" . $name ."' ><br>" .  
              "<input type='hidden' name='poolID' value='0' ><br>" .  
              " <input type='submit' class='button' value='Continue' style='float: right;F'> " .               
          "</form> ";
        
        return $str;
    }
    
    
      public static function selectPool($clientRank, $lastName, $firstName, $array) {
        
        $name = $firstName . " " . $lastName;
        $str = "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value='345' >" . 
              "<input type='hidden' name='clientRank' value='" . $clientRank ."' >" . 
                
              "<input type='hidden' name='name' value='" . $name ."' ><br>" .  
              "<input type='hidden' name='poolID' value='0' ><br>" .    
              " <input type='submit' class='button' value='Continue' style='float: right;F'> " .               
          "</form> ";
        
        return $str;
        
    } 
    
    public static function sendReminders($forDate) {
        
        $jScript = "<Script>"     
            . "var ca = document.getElementById('content_area');"
            . "ca.style.width='500px';"   
            . "ca = document.getElementById('sidebar');"
            . "ca.style.width='500px';"
                . "</Script>";
        
        $array = VDate::sendReminders($forDate);
        // return two arrays of mail Not sent and mail sent
        $mailNotSent = $array[0];
        $mailSent = $array[1];
        
        $len = count($mailNotSent);
        $str0 = "<b>Mail Not Sent = ". $len . "</b><br>";
        
        if ($len > 0) {
            for ($i = 0; $i < $len; $i++) {
                $str0 = $str0 . "<br>" . $mailNotSent[$i];
            }
        }
                
        $len = count($mailSent);
        $str1 = "<b>Mail Sent = ". $len . "</b><br>" . $jScript;
        
        if ($len > 0) {
            for ($i = 0; $i < $len; $i++) {
                $str1 = $str1 . "<br>" . $mailSent[$i];
            }
        }
        
        return array($str0, $str1);
    }
    
    public static function client($client) {
        $aptStr = "";
        if (strlen($client->apartment) > 0) {
            $aptStr = " #";
        }
        
        $householdTotal = $client->nbr6To17 + $client->nbrOver18 + $client->nbrUnder5;
        
        $str = View::clientCmds($client) ."<br>";
        $nclient = new Client();
        
        $str = $str .       
                "<table class=\"clientTb\" >" .
                "<tr>" .
                "<th class=\"row-1 row-Field\"></th> ".
                "<th class=\"row-2 row-Value\"></th> " .
                "</tr>" .
        
            "<tr>" .
                "<td> Household </td>" . 
                    "<td>" . $householdTotal . "</td>" .
            "</tr>" .
            "<tr>" .
                "<td> Name </td>"  .
                     "<td>" . $client->lastName . ", " . $client->firstName . "</td>" .
            "</tr>" .   
             "<tr>" .
                "<td>18 and above # </td>" . 
                    "<td>" . $client->nbrOver18 . "</td>" .
            "</tr>" .      
            "<tr>" .
                "<td>6 to 17 # </td>" . 
                    "<td>" . $client->nbr6To17 . "</td>" .
            "</tr>" .    
            "<tr>" .
                "<td>5 and below # </td>" . 
                    "<td>" . $client->nbrUnder5 . "</td>" .
            "</tr>" .
            "<tr>" .
                "<td> BirthDate </td>" . 
                    "<td>" . $client->birthDate . "</td>" .
            "</tr>" .    
            "<tr>" .
                "<td> Gender </td>" . 
                    "<td>" . $client->gender . "</td>" .
            "</tr>" .   
            "<tr>" .
                "<td> Address </td>" . 
                    "<td>" . $client->street  . $aptStr .
                            $client->apartment . ", " .
                            $client->city .", " . $client->state . " " . $client->zip .
                "</td>" .
            "</tr>" .
            "<tr>" .
                "<td> Phone </td>" . 
                    "<td>" . $client->phone . "</td>" .
            "</tr>" .  
             "<tr>" .
                "<td> Email </td>" . 
                    "<td>" . $client->email . "</td>" .
            "</tr>" .  
             "<tr>" .
                "<td> Type </td>" . 
                "<td>" . $client->type. "</td>" .
            "</tr>" .  
             "<tr>" .
                "<td> Church Member? </td>" . 
                "<td>" . $client->churchMember . "</td>" .
            "</tr>" .  
             "<tr>" .
                "<td> LayawaySponsor? </td>" . 
                "<td>" . $client->layawaySponsor . "</td>" .
            "</tr>" .  
             "<tr>" .
                "<td> Sponsor Name </td>" . 
                "<td>" . $nclient->name($client->sponsorID) . "</td>" .   
            "</tr>" .  
             "<tr>" .
                "<td> Active? </td>" . 
                "<td>" . $client->active . "</td>" .   
            "</tr>" .  
                
         "</table>" ;
        
        // echo "strlen = " . strlen($client->photo) . "<br>";
        if (strlen($client->photo) > 0) {
            $strA = "<center><img src='Photos/" . $client->photo . "' class='imgCenter' /></center>";
        } else {       
            $strA = "<center><img src='Images/emptyPhoto.jpg' class='imgCenter' /></center>";
        }
        
        $strA = $strA . View::latestNotes($client->id);
                 
        return array($str, $strA);    
        
    }
    
    
        public static function latestNotes($clientID) {
        
        $note = new Note();
        $array = $note->getLatestNotes($clientID);
        
        $str = "";
        if (sizeof($array) > 0 ) {
            $str = "<table class='clientTb'> ";
       
            foreach ($array as $row) {                
                $str = $str . 
                   "<tr>" .
                      "<td> " . $row[0] . "</td> " .
                   "</tr>";

 
            }
            $str = $str . "</table>";
        }
        
        return $str;
    }
    
    public static function editClient($client) {
        
        $visit = new Visit();
        $lastVisitDate = $visit->lastVisit($client->id);
        $phpdate = strtotime( $lastVisitDate );
        $phpdateStr = date('D M d Y', $phpdate);
               
         $gender1 = '';
         $gender2 = '';
         $gender3 = '';
         $gender4 = '';
         switch ($client->gender) {
             case '': $gender1 = ' selected ';
                 break;
             case 'M': $gender2 = ' selected ';
                 break;
             case 'F': $gender3 = ' selected ';
                 break;
             case 'O': $gender4 = ' selected ';
                 break;
         }
         
         $type1 = '';
         $type2 = '';
         $type3 = '';
         $type4 = '';
         switch ($client->type) {
             case 'C': $type1 = ' selected ';
                 break;
             case 'L': $type2 = ' selected ';
                 break;
             case 'V': $type3 = ' selected ';
                 break;
             case 'S': $type4 = ' selected ';
                 break;
         }
         
         // echo "<br> {".$client->type . "} type1[".$type1. "] " ." type2[" . $type2 ."] type3[" . $type3 ."]";
             
         $churchMember1 = '';
         $churchMember2 = '';
         switch ($client->churchMember) {
             case 'N': $churchMember1 = ' selected ';
                 break;
             case 'Y': $churchMember2 = ' selected ';
                 break;
         }
         

         $layawaySponsor1 = '';
         $layawaySponsor2 = '';
         switch ($client->layawaySponsor) {
             case 'N': $layawaySponsor1 = ' selected ';
                 break;
             case 'Y': $layawaySponsor2 = ' selected ';
                 break;
         }
         
         $active1 = '';
         $active2 = '';
         switch ($client->active) {
             case 'N': $active1 = ' selected ';
                 break;
             case 'Y': $active2 = ' selected ';
                 break;
         }
         
         $lifescan1 = '';
         $lifescan2 = '';
         switch ($client->lifescan) {
             case 'N': $lifescan1 = ' selected ';
                 break;
             case 'Y': $lifescan2 = ' selected ';
                 break;
         }
         
         
        $str =
           "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value='210'>" .
              "<input type='hidden' name='clientID' value='" . $client->id . "'>" .
              
              "Last name: " .
                    "<input type='text' name='lastName' size = '50'" .
                    "value='". $client->lastName . "' >" .
            
              "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Visit: <b>" . $phpdateStr . "</b><br><br>" .
                
              "First name: " .
                    "<input type='text' name='firstName' size='50' " .
                     "value='". $client->firstName . "' ><br><br> " .
              "Birthdate: &nbsp&nbsp " . 
                    "<input name='birthDate'  id='birthDate'  class='datepicker'" .
                    "value='". $client->birthDate . "' > " .
              " &nbsp Gender: " .
                "<select name='gender' >" .
                    " <option " . $gender1 . " value=''></option>".
                    " <option " . $gender2 . " value='M'>M</option>".
                    " <option " . $gender3 . " value='F'>F</option>".
                    " <option " . $gender4 . " value='O'>O</option>".
                "</select> <br><br>".
                     
                
              "Adults (18 and above): <sp> " .
                    "<input type='text' name='nbrOver18' size = '2'" .
                    "value='". $client->nbrOver18 . "' >" .
              " Children (6 to 17): <sp> " .
                    "<input type='text' name='nbr6To17' size = '2'  " .
                    "value='". $client->nbr6To17 . "' > " .
              " Children (5 and under): <sp> " .
                    "<input type='text' name='nbrUnder5' size = '2'  " .  
                "value='". $client->nbrUnder5 . "' ><br><br> " .
                

              "Street: <sp> " .
                    "<input type='text' name='street' size = '50'   " . 
                "value='". $client->street . "' >" .
              " Apartment: <sp> " .
                    "<input type='text' name='apartment' size = '10'   " .
                "value='". $client->apartment . "' ><br><br> " .
              "City: &nbsp&nbsp " .
                    "<input type='text' name='city' size = '50'   " . 
                "value='". $client->city . "' > " .
              " State: <sp> " .
                    "<input type='text' name='state' size = '2'   " .   
                "value='". $client->state . "' > " .
              " Zip: <sp> " .
                    "<input type='text' name='zip' size = '10'   " .
                "value='". $client->zip . "' ><br><br> " .
                
              "Phone: <sp> " .
                    "<input type='text' name='phone' size = '15'   " .
                "value='". $client->phone . "' > " .
              "Email: <sp> " .
                    "<input type='text' name='email' size = '60'   " .
                "value='". $client->email . "' ><br><br> " .
              
              "Church member " .
                "<select name='churchMember' value= '" . $client->churchMember . "'> ".
                    " <option " . $churchMember1 . " value='N'>NO</option>".
                    " <option " . $churchMember2 . " value='Y'>YES</option>".
                "</select> ".
                    
              "&nbsp;&nbsp;Type " .
                "<select name='type' value= '" . $client->type . "'> ".
                    " <option " . $type1 . " value='C'>Client</option>".
                    " <option " . $type2 . " value='L'>Layaway</option>".
                    " <option " . $type4 . " value='S'>Staff</option>".
                    " <option " . $type3 . " value='V'>Volunteer</option>".
                "</select> ".
                
                "&nbsp;&nbsp;Lifescan " .
                "<select name='lifescan' > ".
                    " <option " . $lifescan1 . " value='N'>NO</option>".
                    " <option " . $lifescan2 . " value='Y'>YES</option>".
                "</select>" .
                
                "&nbsp;&nbsp;LayawaySponsor " .
                "<select name='layawaySponsor' > ".
                    " <option " . $layawaySponsor1 . " value='N'>NO</option>".
                    " <option " . $layawaySponsor2 . " value='Y'>YES</option>".
                "</select> <br><br>" .
                
                "Active " .
                "<select name='active' > ".
                    " <option " . $active1 . " value='N'>NO</option>".
                    " <option " . $active2 . " value='Y'>YES</option>".
                "</select> " .
                        
                "&nbsp;&nbsp;Sponsor Name " .
                "<select name='sponsorID' > ";
                
                $sponsorID = $client->sponsorID;
                if ($sponsorID == 0) {
                    $str = $str . 
                      "<option value='0' selected> NONE </option>";
                } else {
                    $str = $str .
                      "<option value='0' > NONE </option>";
                }
                
                $nclient = new Client();
                $arr = $nclient->sponsorList();
                
                foreach ($arr as $row) {   
                    // echo "row " . $row[0] . " -- id " . $row[1] ."<br>";
                    if ($sponsorID == $row[1]) {
                        $selected = " selected ";
                    } else {
                        $selected = "";
                    }
                    $str = $str . 
                    " <option  value='" . $row[1] . "'" . $selected . ">" . $row[0] . "</option>";
                }
                
                
              $str = $str . "</select> " .
                     
              "<br><br>" .
              " <input type='submit' class='button' value='Update Client' style='float:right' > " .               
              "</form> ";
        
            $str = $str . "<form action='/Mustard/View/webcam1.html'>" .
            "<input type=\"hidden\" name=\"clientID\" value='" . $client->id . "'>" .
            "<input type=\"hidden\" name=\"lastName\" value='" . $client->lastName . "'>" .
            "&nbsp<input type = 'submit' class='button' value='Take Photo' >" .
        "</form>" ;
              
              
        return $str;
                
    }
    
    
    public static function findInPage() {
       
                
        $str = 
                "Find on this page: <br>"
                ."<input type='text' id='txt' >"
                ."<input type='button' value=' Find '  onclick='window.find(txt.value, false)' />  ";
              
        return $str;
    }
    
    public static function allCheckinView($array, $forDate, $personType) {
        $aString =
            "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center>".$personType."</center></th> " .
                    "<th class=\"row-Number\"><center>Time</center></th>" .
                    "<th class=\"row-3\"><center>Pool</center></th>" .
                    "<th class=\"row-3\"><center>Number</center></th>" .
                    "<th class=\"row-Small\"><center>Action</center></th>" .
                "</tr>" ;
                    
            
            foreach ($array as $row) {

               $clientID = $row['clientID'];
               $name = $row['name'];
               $time = $row['time'];
               if ($personType == 'CLIENT')
                    $pool = $row['poolName'];
               else
                   $pool = "";
               $number = $row['number'];
             
               
               $gtime = date('g:i A', strtotime($time));
                           
               $aString = $aString .
               "<tr>" .
                   "<td><a href='/Mustard/index.php?cmd=215&clientID=" . $clientID . "'>" 
                          . $name . "</a></td>" . 
                   "<td><center>" . $gtime . "<center></td>" .
                   "<td><center>" . $pool . "<center></td>" .
                   "<td><center>" . $number . "<center></td>" .
                   "<td><center>" . 
                       "<form action='/Mustard/index.php'>" 
                            . "<input type='hidden' name='cmd' value='334'>" 
                            . "<input type='hidden' name='clientID' value='" . $clientID . "'>" 
                            . "<input type='hidden' name='forDate' value='" . $forDate . "'>" 
                            . "<input type='hidden' name='number' value='" . $number . "'>" 
                            . "<input type = 'submit' value='Remove' >" .
                        "</form>" 
                    ."<center></td>" .
               "</tr>";
             
            }
            $aString = $aString . "</table>";
            
            return $aString;
            
    }
    
    
    public static function MoveToFront($array, $forDate) {
        $aString =
            "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Name\"><center> Client </center></th> " .
                    "<th class=\"row-Number\"><center>Time</center></th>" .
                    "<th class=\"row-3\"><center>Pool</center></th>" .
                    "<th class=\"row-3\"><center>Number</center></th>" .
                    "<th class=\"row-Small\"><center>Action</center></th>" .
                "</tr>" ;
                    
            
            foreach ($array as $row) {

               $clientID = $row['clientID'];
               $name = $row['name'];
               $time = $row['time'];
               $pool = $row['poolName'];
               $number = $row['number'];
               $rank = $row['rank'];
             
               $gtime = date('g:i A', strtotime($time));
                           
               $aString = $aString .
               "<tr>" .
                   "<td><a href='/Mustard/index.php?cmd=215&clientID=" . $clientID . "'>" 
                          . $name . "</a></td>" . 
                   "<td><center>" . $gtime . "<center></td>" .
                   "<td><center>" . $pool . "<center></td>" .
                   "<td><center>" . $number . "<center></td>" .
                   "<td><center>" ;
                   if ($rank != 0) {
                       $aString = $aString .
                       "<form action='/Mustard/index.php'>" 
                            . "<input type='hidden' name='cmd' value='551'>" 
                            . "<input type='hidden' name='clientID' value='" . $clientID . "'>" 
                            . "<input type='hidden' name='forDate' value='" . $forDate . "'>" 
                            . "<input type='hidden' name='number' value='" . $number . "'>" 
                            . "<input type = 'submit' value='MoveFront' >" .
                        "</form>" ;
                   }
                   $aString = $aString 
                    ."<center></td>" .
               "</tr>";
             
            }
            $aString = $aString . "</table>";
            
            return $aString;
            
    }
    
    
    
    
    public static function checkinList($array) {
        
        $aString =
            "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Small\"><center>Tag#</center></th> " .
                    "<th class=\"row-Name\"><center>Person</center></th> " .
                    "<th class=\"row-Number\"><center>Time</center></th>" .
                    "<th class=\"row-Small\"><center>Pool</center></th>" .
                    "<th class=\"row-Small\"><center>House#</center></th>" .
                "</tr>" ;
                    
            $count = 0;
            
            foreach ($array as $row) {

               $clientID = $row[0];
               $name = $row[1];
               $time = $row[2];
               $household = $row[3];
               $number = $row[4];
               $poolName = $row[5];
               
               $gtime = date('g:i A', strtotime($time));
               
               /**
               if ($poolID > 0) {
                   $pool = new Pool();
                   $poolName = $pool->poolName($poolID);
               }
               **/
             
               $aString = $aString .
               "<tr>" .
                   "<td>" . $number . "</td>" .
                   "<td><a href='/Mustard/index.php?cmd=215&clientID=" . $clientID . "'>" 
                          . $name . "</a></td>" . 
                   "<td>" . $gtime . "</td>" .
                   "<td>" . $poolName . "</td>" .
                   "<td>" . $household . "</td>" .
               "</tr>";
               $count = $count + 1;
            }
            $aString = $aString . "</table>";
            
            return array($aString, $count);
        
    }
    
       public static function clientCmds($client) {
        
        $ss = 
                "<table class=\"clientTb\" >" .
                "<tr>" .
                
                "<td class='row-Action' style='text-align:center'>".
                 "<form action='/Mustard/index.php'>" .
                        "<input type='hidden' name='cmd' value='225'>" .
                         "<input type='hidden' name='clientID' value='" . $client->id . "'>" .
                            "<input type = 'submit' class='button' value='Visits' >" .
                     "</form>" .
                "</td> " .
                "<td class='row-Action' style='text-align:center'>" .
                 "<form action='/Mustard/index.php'>" .
                        "<input type='hidden' name='cmd' value='230'>" .
                         "<input type='hidden' name='clientID' value='" . $client->id . "'>" .
                            "<input type = 'submit' class='button' value='House' >" .
                     "</form>" .
                 "</td> " .
                "<td class='row-Action' style='text-align:center'>" .
                 "<form action='/Mustard/index.php'>" .
                        "<input type='hidden' name='cmd' value='220'>" .
                         "<input type=\"hidden\" name=\"clientID\" value='" . $client->id . "'>" .
                            "<input type = \"submit\" class='button' value=\"Edit\"/ >" .
                     "</form>" .
                 "</td> " .
                "<td class='row-Action' style='text-align:center'>" .
                 "<form action='/Mustard/index.php'>" .
                        "<input type='hidden' name='cmd' value='260'>" .
                         "<input type=\"hidden\" name=\"clientID\" value='" . $client->id . "'>" .
                            "<input type = \"submit\" class='button' value=\"Notes\"/ >" .
                     "</form>" .
                 "</td> " ;
 
        $currentDate = Any::currentDate(); // for today
        $visit = new Visit();
        $isCheckin = Today::isCheckin($client->id);
        
                // $visit->isCheckin($client->id, $currentDate);
        
        $special = "";
        $skip = FALSE;
        if ($client->type == "V") {
            $special = "Volunteer";
            $skip = TRUE;
        }
        if ($client->type == "L") {
            $special = "Layway";
            $skip = TRUE;
        }
        if ($client->type == "S") {
            $special = "Staff";
            $skip = TRUE;
        }
                
        $state = new State();
        
        if ($skip == FALSE) {
            if ($isCheckin) {
                $ss = $ss .
                "<td class='row-Action' style='text-align:center'>" .
                  "CHECKED IN" .
                 "</td> ";      
                if (!$state->isFreeze()) {
                    $ss = $ss .
                    "<td class='row-Action' style='text-align:center'>" .
                       "<form action='/Mustard/index.php'>" .
                        "<input type='hidden' name='cmd' value='322'>" .

                        "<input type=\"hidden\" name=\"clientID\" value='" . $client->id . "'>" .
                        "<input type=\"hidden\" name=\"lastName\" value='" . $client->lastName . "'>" .
                        "<input type=\"hidden\" name=\"firstName\" value='" . $client->firstName . "'>" .
                        "<input type=\"hidden\" name=\"forDate\" value='" . $currentDate . "'>" .
                        "<input type = \"submit\" class='buttonRed' value=\"Pool\"/ >" .
                       "</form>" .
                     "</td> ";     
                }
            } else {
                $ss = $ss .
                "<td class='row-Action' style='text-align:center'>" .
                   "<form action='/Mustard/index.php'>" .
                    "<input type='hidden' name='cmd' value='320'>" .
              
                    "<input type=\"hidden\" name=\"clientID\" value='" . $client->id . "'>" .
                    "<input type=\"hidden\" name=\"lastName\" value='" . $client->lastName . "'>" .
                    "<input type=\"hidden\" name=\"firstName\" value='" . $client->firstName . "'>" .
                    "<input type = \"submit\" class='buttonRed' value=\"CheckIn\"/ >" .
                   "</form>" .
                "</td> ";
            }
        } else {
            $ss = $ss .
                "<td class='row-Action' style='text-align:center'>" . $special .
                 "</td> ";     
        }
        
        $ss = $ss .
                "</tr>" .
                "</table>";
        return $ss;
    }
    
    public static function volunteerCmds($clientID) {
        
        $ss =                
                "<form action='/Mustard/index.php'>" .
                 "<input type='hidden' name='cmd' value='325'>" .
                         "<input type=\"hidden\" name='clientID' value='" . $clientID . "'>" .
                            "<input type = \"submit\" class='button' value=\"Volunteer CheckIn\"/ " .
                            "style=\"float: right;\" width=\"60\" height=\"60\" >" .
                     "</form>" ;
                
        return $ss;
    }
    
    public static function showPool($array) {
                     
        $str = "<table class='clientTb'> " .
            "<tr>" .
                "<th class='row-3'></th> " .
                "<th class='row-Name'></th>" .
            "</tr>" ;
        foreach ($array as $row) {         
            $nameStr = self::catName($row);
            $str = $str .
                "<tr>" .
                    "<td> " . $row['poolName'] . "</td> " .
                    "<td> " . $nameStr .  "</td>" .
                "</tr>" ;
        }
                  
        $str = $str . "</table><br><br>";
                
        return $str;
    }
    
    public static function showSelectedPoolForEdit($poolID) {
        
        $pool = new Pool();
        $pool->get($poolID);
        // echo "<br> " . $pool->display();
        
        $str = "<b>Pool - " . $pool->poolName . "</b><br>"
            ."<table class='clientTb'> " 
                ."<tr>" 
                    ."<th class='row-Small'>Name</th>" 
                    ."<th class='row-3'>Remove</th>"
                ."</tr>" ;
             
            $str = $str . self::nameInPool($poolID, $pool->name1);
            $str = $str . self::nameInPool($poolID, $pool->name2);
            $str = $str . self::nameInPool($poolID, $pool->name3);
            $str = $str . self::nameInPool($poolID, $pool->name4);
            $str = $str . self::nameInPool($poolID, $pool->name5);
            $str = $str . self::nameInPool($poolID, $pool->name6);
            $str = $str . self::nameInPool($poolID, $pool->name7);
             
        $str = $str . "</table><br><br>";
                
        return $str;
    }
    
    
    public static function nameInPool($poolID, $name) {
        $str = 
                "<tr>" 
                    ."<td> " . $name.  "</td>" 
                    . "<td><span><center>"
                      . "<form action = '/Mustard/index.php'>" 
                            ."<input type='hidden' name='cmd' value='602' >"                           
                            ."<input type='hidden' name='poolID' value='" . $poolID ."' >"  
                            ."<input type='hidden' name='name' value='" . $name ."' >"  
                            . "<input type='submit' value='remove' style='color:red;'> "
                      ."</form>"
                    . "</center></span></td>"
                ."</tr>" ;
        
        return $str;
    }
    
    public static function showPoolForRemoval($array) {
                     
        $str = "<table class='clientTb'> " .
            "<tr>" 
                ."<th class='row-3'></th> " 
                ."<th class='row-Name'></th>" 
                ."<th class='row-3'></th>"
            ."</tr>" ;
        foreach ($array as $row) {         
            $nameStr = self::catName($row);
            $str = $str .
                "<tr>" 
                    ."<td> " . $row['poolName'] . "</td> " 
                    ."<td> " . $nameStr .  "</td>" 
                    . "<td><span><center>"
                      . "<form action = '/Mustard/index.php'>" 
                            ."<input type='hidden' name='cmd' value='601' >"                           
                            ."<input type='hidden' name='poolID' value='" . $row['id'] ."' >"  
                            . "<input type='submit' value='select' style='color:red;'> "
                      ."</form>"
                    . "</center></span></td>"
                ."</tr>" ;
        }
                  
        $str = $str . "</table><br><br>";
                
        return $str;
    }
    
    
    public static function selectThisPool($clientID, $clientRank, $lastName, $firstName, $array) {
                     
        $str = "<table class='clientTb'> " .
            "<tr>" .
                "<th class='row-3'></th> " .
                "<th class='row-Name'></th>"
                . "<th class='row-3'> </th>" .
            "</tr>" ;
        foreach ($array as $row) {         
            $nameStr = self::catName($row);
            $str = $str .
                "<tr>" 
                    . "<td> " . $row['poolName'] . "</td> " 
                    . "<td> " . $nameStr .  "</td>" 
                    . "<td><span><center>"
                      . "<form action = '/Mustard/index.php'>" 
                            ."<input type='hidden' name='cmd' value='345' >" 
                            ."<input type='hidden' name='clientID' value='" . $clientID ."' >" 
                            ."<input type='hidden' name='clientRank' value='" . $clientRank ."' >" 
                            ."<input type='hidden' name='name' value='" . $firstName." ".$lastName ."' >"   
                            ."<input type='hidden' name='poolID' value='" . $row['id'] ."' >"  
                            . "<input type='submit' value='select' style='color:red;'> "
                      ."</form>"
                    . "</center></span></td>"
                ."</tr>" ;
        } 
                  
        $str = $str . "</table><br><br>";
                
        return $str;
    }
    
    
    
     public static function catName($row) {
        $str = "";
        $str = self::cname($str, $row['name1']);
        $str = self::cname($str, $row['name2']);
        $str = self::cname($str, $row['name3']);
        $str = self::cname($str, $row['name4']);
        $str = self::cname($str, $row['name5']);
        $str = self::cname($str, $row['name6']);
        $str = self::cname($str, $row['name7']);
            
        return $str;
    }
    
    public static function catNamesInPool($pool) {
        $str = "";
        $str = self::cname($str, $pool->name1);
        $str = self::cname($str, $pool->name2);
        $str = self::cname($str, $pool->name3);
        $str = self::cname($str, $pool->name4);
        $str = self::cname($str, $pool->name5);
            
        return $str;
    }
    
    public static function cname($str, $name) {
        if (strlen($name)>0) {
            $str = $str . $name . ", " ;
        } 
        return $str;
    }
   
    
    public static function resetPool() {
        $str = "<br><br>" .
              "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value='340' >" . 
              " <input type='submit' class='button' value='Empty Pool'> " .               
          "</form> " .
                "<br><br>";
        
        return $str;
    }
    
    
    public static function utilityList() {
         
         $str = 
          "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-1 row-Name\">Description</th> ".
                    "<th class=\"row-2 row-Action\"></th> " .
                "</tr>" .
            "<tr>" .
                 "<td>Report on number of families, individuals and bags </td>".
                 "<td>" .
                    "<form action = '/Mustard/index.php'>" . 
                    "<input type='hidden' name='cmd' value='700' >" . 
                    "<input type='submit' class='button' value='select'> " .               
                    "</form> " .
                 "</td>" .
            "</tr>" .
            "<tr> " .
                 "<td>Show the pool</td>" .
                 "<td>" .
                    "<form action = '/Mustard/index.php'>" . 
                    "<input type='hidden' name='cmd' value='350' >" . 
                    "<input type='submit' class='button' value='select'> " .               
                    "</form> " .
                 "</td>" .
            "</tr>" .
            "<tr> " .
                 "<td>Reset the pool</td>" .
                 "<td>" .
                    "<form action = '/Mustard/index.php'>" . 
                    "<input type='hidden' name='cmd' value='340' >" . 
                    "<input type='submit' class='button' value='select'> " .               
                    "</form> " .
                 "</td>" .
            "</tr>" .
            "<tr>" .
                 "<td>Reset the Freeze</td>" .
                 "<td>" .
                    "<form action = '/Mustard/index.php'>" . 
                    "<input type='hidden' name='cmd' value='315' >" . 
                    "<input type='submit' class='button' value='select'> " .               
                    "</form> " .
                 "</td>" .
            "</tr>" .
                 
            "</table>";
         
         return $str;
     }
     
     
    public static function notes($clientID, $array) {
                
        $str1 = 
                
            "<form action='/Mustard/index.php'>" .
                        "<input type=\"hidden\" name=\"cmd\" value='215'>" .
                         "<input type=\"hidden\" name=\"clientID\" value='" . $clientID . "'>" .
                         "<input type = \"submit\" value=\"Back to Client\"/ class='button' >" .
            "</form><br>" .      
                
          "<table class=\"clientTb\" >" .
                "<tr>" .
                "<th class=\"row-1 row-Field\">Date</th> ".
                "<th class=\"row-1 row-Action\">Author</th> " .
                "<th class=\"row-2 row-Value\">Note</th> " .
                "</tr>" ;
        
        foreach ($array as $row) {
    
            $phpdate = strtotime( $row[0] );
            $phpdateStr = date('Y-m-d g:i A', $phpdate); // date('D M d Y g:i A', $phpdate);
            $str1 = $str1 . 
                 "<tr>" .
                    "<td>" . $phpdateStr ." </td>".
                    "<td>" . $row[1] ."</td> ".
                    "<td>" . $row[2] ."</td>".
                 "</tr>" ;
        }
                
        $str1 = $str1 . "</table>";
         
         $str2 = View::noteForm($clientID);
         
         return array($str1, $str2);
     }
     
     
    public static function noteForm($clientID) {

        $str = 
           "<form action = '/Mustard/index.php'>" .   
              "<input type='hidden' name='cmd' value='265'>" .
              "<input type='hidden' name='clientID' value='" . $clientID . "'>" .
              "<textarea name='note' cols='35' rows='20'> Enter note </textarea> <br><br> " .
              "Written By: <input type=text name='author' size=8 value='me'>" .
              " <right><input type='submit' class='button' value='Add Note' ></right> " .               
              "</form> ";
         
         return $str;
     }

     
     public static function displayVolunteerLifescan($arrayW, $arrayWO) {
         
        $jScript = "<Script>"     
            . "var ca = document.getElementById('content_area');"
            . "ca.style.width='500px';"   
            . "ca = document.getElementById('sidebar');"
            . "ca.style.width='500px';"
                . "</Script>";
            //. "document.getElementById('footerLine').innerHTML=' ';" 
            
        $str2 =    
        " <table class='clientTb'> "
            ."<tr>"
                ."<th>Volunteers without Lifescan = " . sizeof($arrayWO) . "</th>"
            ."</tr>";
             
        foreach ($arrayWO as $row) {

            $str2 = $str2
            ."<tr>"
            .   "<td><a href='/Mustard/index.php?cmd=215&clientID=". $row[0]. "'>" . $row[1] .", ".$row[2] ."</a></td>"
            ."</tr>";
        }
        $str2 = $str2 ."</table>";
        
             
        $str1 =  $jScript . 
         " <table class='clientTb'> "
            ."<tr>"
                ."<th>Volunteers with Lifescan = " . sizeof($arrayW) . "</th>"
            ."</tr>";
        
        foreach ($arrayW as $row) {
            $str1 = $str1
            ."<tr>"
            .   "<td><a href='/Mustard/index.php?cmd=215&clientID=". $row[0]. "'>"  . $row[1] .", ".$row[2] ."</a></td>"
            ."</tr>";
        }
        $str1 = $str1 ."</table>";
         
        return array($str1, $str2);
     }
    
    public static function existList($lastName, $firstName, $active) {
               
        $str = "<table class=\"clientTb\" >" .
                "<tr>" .
                "<th class='row-3'><center>Zip</center> </th>" .
                "<th class='row-3'><center>Household#</center> </th>" .
                "<th class='row-3'><center>Type</center> </th>" .
                "<th class='row-Action'><center>Name (last, first)</center></th> " .
                "</tr>";
        
        $client = new Client();
        $array = $client->getExistList($lastName, $firstName, $active);
                
        foreach ($array as $row) {
            $type = "C";
            $type = $row[5];
             
                        // can somebody be both a volunteer and a layaway
            $str = $str . 
                "<tr>" .            
                    "<td><center>" . $row[3] . "</center></td>" . 
                    "<td><center>" . $row[4] . "</center></td>" . 
                    "<td><center>" . $type . "</center></td>" . 
                    "<td><a href='/Mustard/index.php?cmd=215&clientID=" . $row[0]."'>" . $row[1] . " " . $row[2] . "</a></td>" .
                "</tr>";
        }

        
        $str = $str . "</table>";
        return $str;
    }
    
    
    public static function randomizeParam($forDate, $buttonName) {
        
        
        $str = "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value='305' >" . 
              "<input type='hidden' name='forDate' value='" . $forDate ."' ><br>" .          
              "Number of persons per group: <sp><sp> " .
                    "<input type='text' name='nbrPerGroup' size = '2' value='5' ><br><br>" .
              " <input type='submit' class='buttonRed' value='" .$buttonName . "'> " .               
          "</form><br><br> " ;
               
        
        return $str;
        
    }
    
    public static function rankList($array, $nbrPerGroup) {
        
        //$time_start = microtime(true);
        
        $aString =
            "<table id='freezeList' border='1' >" . // class='clientTb'
                "<tr>" .
                    "<th class='row-Name'>Name</th> " .
                    "<th class='row-Number'>Tag #</th>" .
                    "<th class='row-Number'>Rank</th>" .
                    "<th class='row-Number'>HH #</th>" .
                    "<th class='row-Number'>Pool</th>" .
                "</tr>" ;
                    
            $count = 0;
            $groupOrder = 1;
            $prevPool = '';
           
            $poolFound = FALSE;
            $newPool = FALSE;
            foreach ($array as $row) {
               $name = $row['name'];
               $rank = $row['rank'];
               $poolName = $row['poolName'];
               $number = $row['number'];
               $htotal = $row['houseTotal'];
               
              /**
                print "<br> name[".$name."] rank[".$rank."] poolName[".$poolName."] ";
                print "<br> state0: count[".$count."] poolFound[".(int)$poolFound
                        ."] newPool[".(int)$newPool."] prevPool[".$prevPool."]";
             **/

               if ($rank == 0) 
                   $rank = 1;
              
               
               if ($poolFound) {
                   if ($poolName == '') {
                       $newPool = FALSE;
                       $prevPool = ''; 
                       $poolFound = FALSE;
                       // print "<br> state1: count[".$count."] poolFound[".(int)$poolFound."] newPool[".(int)$newPool."] prevPool[".$prevPool."]";
                   } else {
                       $poolFound = TRUE;    
                       if ($prevPool == '') {
                          $newPool = TRUE;
                       } else {
                            if ($prevPool == $poolName) {
                                $newPool = FALSE;
                            } else {
                                $newPool = TRUE;
                            }
                       }  
                       $prevPool = $poolName;
                       // print "<br> state2: count[".$count."] poolFound[".(int)$poolFound
                       //  ."] newPool[".(int)$newPool."] prevPool[".$prevPool."]";
                   }
               } else {
                   if (strlen($poolName)>0) {
                       $poolFound = TRUE;
                       if ($prevPool == '') {
                           $newPool = TRUE;
                       }
                       $prevPool = $poolName;
                       // print "<br> state3: count[".$count."] poolFound[".(int)$poolFound
                       // ."] newPool[".(int)$newPool."] prevPool[".$prevPool."]";
                   }
               }
               
               // print "<br> state5: count[".$count."] poolFound[".(int)$poolFound
               //         ."] newPool[".(int)$newPool."] prevPool[".$prevPool."]";

               if (!$poolFound || $newPool) {
                    if ($count >= $nbrPerGroup) {
                        // echo "<br> count >= nbrPerGroup red line <br>";
                        $aString = $aString .
                            "<tr>" .
                                "<td bgcolor=\"#FF0000\">**********************</td>" .
                                "<td bgcolor=\"#FF0000\">*****</td>" .
                                "<td bgcolor=\"#FF0000\">*****</td>" .
                                "<td bgcolor=\"#FF0000\">*****</td>" .
                                "<td bgcolor=\"#FF0000\">*****</td>" .
                            "</tr>";
                        $count = 0;
                        $groupOrder++;
                    } 
               }
                  
               
               // $pool = new Pool();
               // $poolName = "";
               // if ($poolID > 0)
               //    $poolName = $pool->poolName($poolID);
               
               $aString = $aString .
               "<tr>" .
                   "<td>" . $name . "</td>" .
                   "<td><center>" . $number . "</center></td>" .
                   "<td><center>" . $groupOrder . "</center></td>" .
                   "<td><center>" . $htotal  . "</center></td>" .
                   "<td><center>" . $poolName . "</center></td>" .
               "</tr>";

               $count++;
               
            }
            $aString = $aString . "</table>";
        
        $aString = $aString .
                
                "<script>
            
            function selectedRow(){
                
                var index,
                    table = document.getElementById('freezeList');
            
                // store this index in database field state under name freezeIndex
                // index = 4;
                // table.rows[index].classList.toggle('selected');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                        if(typeof index !== 'undefined'){
                           table.rows[index].classList.toggle('selected');
                        }
                        // console.log(typeof index);
                        // get the selected row index
                        index = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle('selected');
                        // console.log(typeof index);
                     };
                }
            }
            selectedRow();
        </script>";
                
                
        // $time_end = microtime(true);
        // $time = $time_end - $time_start;
        // echo "<br>View::rankList in $time seconds\n";
        
        return $aString;
    }
    
    
    public static function volunteerSignup($arrayVolunteer, $forDate) {
        $arr = Any::nextFoodDay(3);
        

        $str = "<div class='header-cont'>"
             .  "<table class='clientTb'>"
             .  "<tr>" 
             .  "<th class='row-Number'>Name</th> " 
             . "<th class='row-3'>Today</th>"
             .  "<th class='row-Small'><span><center>" . $arr[0] . "</center></span></th> " 
             .  "<th class='row-Small'><span><center>" . $arr[1] . "</center></span></th> " 
             .  "<th class='row-Small'><span><center><b>" . $arr[2] . "</b></center></span></th> " 
             . "<th class='row-3'><span><center> </center></span></th> " 
             .  "</tr>"
             . "</table>"
             ."</div>";
        
        $str = $str .
                
             "<table class='clientTb'>"
             //. "<thead>"
             . "<tr>" 
             . "<th class='row-Number'>Name</th> " 
             . "<th class='row-3'>Today</th>"
             .  "<th class='row-Small'><span><center>" . $arr[0] . "</center></span></th> " 
             .  "<th class='row-Small'><span><center>" . $arr[1] . "</center></span></th> " 
             .  "<th class='row-Small'><span><center><b>" . $arr[2] . "</b></center></span></th> " 
             . "<th class='row-3'><span><center> </center></span></th> " 
             .  "</tr>";
             //. "</thead>";
                
        foreach ($arrayVolunteer as $volunteer) {
            
            $clientID = $volunteer[0];
            $lastName = $volunteer[1];
            $firstName = $volunteer[2];
        
            $anchor = "anchor" . $clientID;
            
            $str = $str 
                
                . "<tr> "
                .   " <td> " 
                .     $firstName . " " . $lastName 
                .     "</td> " 
                . "<td></td>";
        
            $str = $str . "<Form action='/Mustard/index.php' method='GET'>"
                        . "<input type='hidden' name='cmd' value='431'>" 
                        . "<input type='hidden' name=\"clientID\" value='". $volunteer[0] ."'>"
                        . "<input type='hidden' name='marker' value='" . $anchor . "'>" ;
        
            for ($i = 0; $i < 3; $i++) {
                
                $vdate = VDate::retrieve($clientID, $arr[$i]);
                $checked1 = "";
                $checked2 = "";
                $checked3 = "";
                if ($vdate->shift1 == 1) $checked1 = "checked";
                if ($vdate->shift2 == 1) $checked2 = "checked";
                if ($vdate->shift3 == 1) $checked3 = "checked";
                
                $str = $str 
                .    "<td> " 
                .        "<table class='clientTb'> "
                .          "<tr> "
                .          "  <td>" . SHIFT_1 . "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='shift[]' value='1-". $arr[$i] ."'". $checked1 . "></td> " 
                . "           </tr> "
                . "         <tr> "
                . "            <td>" . SHIFT_2 . "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='shift[]' value='2-". $arr[$i] ."'". $checked2 . " > </td> "
                . "         </tr> "
                . "         <tr> "
                . "            <td>" . SHIFT_3 . "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='shift[]' value='3-". $arr[$i] ."'". $checked3 . " > </td> "
                . "         </tr> "
                .           "</table>"
                . "     </td> ";
            }
                
            $str = $str 
                . "<td id='".$anchor."'> <input type = 'submit' value='update'</td>"
                . "</Form>"
                . "</tr>";
        }
        
        $str = $str . "</table>";  
        
        return $str;
    }
    
    public static function SummaryTodaySignup($forDate) {
        $shiftName = array(SHIFT_1, SHIFT_2, SHIFT_3);
        $str = "";
        $str = $str . "<b>Expected TODAY [ ". $forDate . " ]</b><br>";
        $shiftArray = VDate::summaryForDate($forDate);
        
        for ($i=0; $i<3; $i++) {
            
            $str = $str 
                 . "<br>" . $shiftName[$i] . " = " . $shiftArray[$i];
        }
       
        return $str;
    }
    
    
    public static function summarySignup() {
         $arr = Any::nextFoodDay(3);
         $shiftName = array(SHIFT_1, SHIFT_2, SHIFT_3);
         $str = "";
         foreach ($arr as $thisDate) {
             $str = $str . "<br><br><b>Date = " . $thisDate . "</b>";
             $shiftArray = VDate::summaryForDate($thisDate);
             for ($i=0; $i<3; $i++) {
                $str = $str 
                     . "<br>" . $shiftName[$i] . " = " . $shiftArray[$i];
             }  
         }
         return $str;
    }
    
    public static function volunteerList($arrayResult, $forDate) {
        
        // $arr = Any::nextThreeFoodDays($forDate);
        $str =  "<table class=\"clientTb\" >" .              
                "<tr>" .
                "<th class='row-15'>Name</th> " .
                "<th class='row-Number'><span><center>Zip</center></span></th>" .
                "<th class='row-Action'><span><center>Sign up</center></span></th>" .
                "<th class='row-Number'><span><center>" . $forDate . " </center></span></th> " .
                "</tr>";
                
       $count = 0;
       $visit = new Visit();
       
       $vstr = array ( "", "", "" );
       foreach ($arrayResult as $row) {
           $checkIn = "Checkin";
            $isCheckin = $visit->isCheckin($row[0], $forDate);
            
            $anchor = "anchor" . $row[0];
            $vdate = VDate::retrieve($row[0], $forDate);
            $shiftStr = "";
            if ($vdate->shift1 == 1)
                $shiftStr = $shiftStr . SHIFT_1;
            if ($vdate->shift2 == 1)
                $shiftStr = $shiftStr . " " .SHIFT_2;
            if ($vdate->shift3 == 1)
                $shiftStr = $shiftStr . " " .SHIFT_3;
             $str = $str . 
                     "<tr>" .
                     "<td><a id='".$anchor."' href='/Mustard/index.php?cmd=215&clientID=" . $row[0] . "'>" . 
                     $row[2] . " " . $row[1] . "</a></td>" 
                         . "<td>" . $row[3] . "</td>"
                         . "<td>". $shiftStr . " </td>";
                    
             if ($isCheckin) {
                 $count++;
                 $str = $str . 
                         "<td><center> IN </center></td> </tr>";
             } else {                             
                 $str = $str .                                   
                     "<td>"
                         . "<form action='/Mustard/index.php' style='text-align:center' >" .
                         "<input type='hidden' name='cmd' value='325'>" .
                         "<input type='hidden' name='clientID' value='" . $row[0] . "'>" .
                         "<input type='hidden' name='marker' value='" . $anchor . "'>" .
                         "<input type = 'submit' value='" . $checkIn ."'  >" .
                     "</form>" .
                     "</td>" .
                     "</tr>";
             }
        }
        
        $str = $str . "</table>";
        $array = array($str, $count);
        
        return $array;
    }
    
    
    public static function staffList($arrayResult, $forDate) {
        
        // $arr = Any::nextThreeFoodDays($forDate);
        $str =  "<table class=\"clientTb\" >" .              
                "<tr>" .
                "<th class='row-15'>Name</th> " .
                "<th class='row-Number'><span><center>Zip</center></span></th>" .
                
                "<th class='row-Number'><span><center>" . $forDate . " </center></span></th> " .
                "</tr>";
                
       $count = 0;
       $visit = new Visit();
       
       $vstr = array ( "", "", "" );
       foreach ($arrayResult as $row) {
           $checkIn = "Checkin";
            $isCheckin = $visit->isCheckin($row[0], $forDate);
            
            $anchor = "anchor" . $row[0];
            
             $str = $str . 
                     "<tr>" .
                     "<td><a id='".$anchor."' href='/Mustard/index.php?cmd=215&clientID=" . $row[0] . "'>" . 
                     $row[2] . " " . $row[1] . "</a></td>" 
                         . "<td>" . $row[3] . "</td>";
                         
                    
             if ($isCheckin) {
                 $count++;
                 $str = $str . 
                         "<td><center> IN </center></td> </tr>";
             } else {                             
                 $str = $str .                                   
                     "<td>"
                         . "<form action='/Mustard/index.php' style='text-align:center' >" .
                         "<input type='hidden' name='cmd' value='327'>" .
                         "<input type='hidden' name='clientID' value='" . $row[0] . "'>" .
                         "<input type='hidden' name='marker' value='" . $anchor . "'>" .
                         "<input type = 'submit' value='" . $checkIn ."'  >" .
                     "</form>" .
                     "</td>" .
                     "</tr>";
             }
        }
        
        $str = $str . "</table>";
        $array = array($str, $count);
        
        return $array;
    }
   
    public static function layawayList($arrayResult, $forDate) {
        

        $str = "<table class=\"clientTb\" >" .
                "<tr>" .
                "<th class='row-Name'>Layaway</th> " .
                "<th class='row-Name'>Sponsor</th> " .
                "<th class='row-Action'>" . $forDate . " </th> " .
                "</tr>";
       $count = 0;
       $visit = new Visit();
       $nclient = new Client();
       
       foreach ($arrayResult as $row) {
            $nameSponsor = $nclient->name($row[3]);
            $isCheckin = $visit->isCheckin($row[0], $forDate);
            $str = $str . 
                     "<tr>" .
                     "<td><a href='/Mustard/index.php?cmd=215&clientID=" . $row[0] . "'>" . 
                     $row[2] . ", " . $row[1] . "</td>" .
                    "<td>" . $nameSponsor .  "</td>" ;
            if ($isCheckin) {
                 $count++;
                 $str = $str . 
                         "<td><center> IN <center></td> </tr>";
            } else {
                 $str = $str .   
                                // style='text-align:center'
                     "<td> <form action='/Mustard/index.php' style='text-align:center' >" .
                         "<input type='hidden' name='cmd' value='330'>" .
                         "<input type=\"hidden\" name=\"clientID\" value='" . $row[0] . "'>" .
                         "<input type = 'submit' value='checkin'   >" .
                     "</form>" .
                     "</td>" .
                     "</tr>";
            }
        }
        
        $str = $str . "</table>";
        $array = array($str, $count);
        
        return $array;
    }
   
    
    public static function displayFrozen($buttonName) {
        
        // echo "<br>displayFrozen - nbrPerGroup = " . $nbrPerGroup;
        //                "<input type='hidden' name='forDate' value = '" . $forDate ."' >" .
        //     "<input type='hidden' name='nbrPerGroup' value = '" . $nbrPerGroup ."' >" .
        
        $str =  
           "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value = '309' >" .
              " <input type='submit' class='button' value='" . $buttonName . "' > " .               
              "</form> ";
        
        return $str;
    }
    
    public static function existParameters() {
        
        $str =  
           "<form action = '/Mustard/index.php'>" . 
              "<input type='hidden' name='cmd' value = '100' >" .
              "First name &nbsp " .
                    "<input type='text' name='firstName' size = '20' autofocus><br><br> " .
              "Last name &nbsp; " .
                    "<input type='text' name='lastName' size = '20' ><br><br>" .
              "Active? " .
                "<select name='active'> ".
                    " <option value='Y'>YES</option>".
                    " <option value='N'>NO</option>".
                "</select> ".
              " <input type='submit' class='button' value='Search' > " .               
              "</form> ";
        
        return $str;
    }
    
    /**
    public static function buildExistList($array) {
        
        $str = "";
        foreach ($array as $row) {
             $str = $str . 
                     "<tr>" .
                     
                     "<td><center>" . $row[3] . "</center></td>" . 
                     "<td><center>" . $row[4] . "</center></td>" . 
                     "<td><a href='/Mustard/index.php?cmd=215&clientID=" . $row[0]."'>" . $row[2] . ", " . $row[1] . "</a></td>" .
    
                     "</tr>";
        }
        
        return $str;
    }
     * 
     * 
     */
    
    public static function visitList($array) {
        
        $str = "<table class=\"clientTb\" >" .
                "<tr>" .
                "<th class=\"row-Field\">Date Time</th> ".
                "</tr>" ;
                
        foreach ($array as $row) {      
            $phpdate = strtotime( $row[0] );
            $phpdateStr = date('D M d Y : g:i A', $phpdate);
            $str = $str . "<tr><td>" . $phpdateStr . "</td></tr>";
        }
        $str = $str . "</table>";
        
        return $str;
    }
    
    public static function addHousehold($clientID) {
        $str = "<form action = '/Mustard/index.php'>" . 
                "<input type=\"hidden\" name=\"cmd\" value='250'>" .
                "<input type=\"hidden\" name=\"clientID\" value='" . $clientID . "'>" .
              "Name: <sp> " .
                    "<input type='text' name='name' size = '70'><br><br> " .
               "Birthdate: <sp> " . 
                    "<input name='birthDate'  id='birthDate'  class='datepicker' value='1990-06-20' > <br><br>" .
 
              "Relationship : <sp> " .
                    "<input type='text' name='relationship' size = 40 ><br><br> " .
                     
              "<br>" .
              " <input type='submit' class='button' value='Add Person' > " .               
              "</form> ";
        
        return $str;
    }
    
    public static function householdPerson($household) {
        $str = "<form action = '/Mustard/index.php'>" . 
                "<input type=\"hidden\" name=\"cmd\" value='240'>" .
                "<input type=\"hidden\" name=\"householdID\" value='" . $household->id . "'>" .
                "<input type=\"hidden\" name=\"clientID\" value='" . $household->clientID . "'>" .
              "Name: <sp> " .
                    "<input type='text' name='name' size = '70' value='" . $household->name .
                       "'><br><br> " .
               "Birthdate: <sp> " . 
                    "<input name='birthdate'  id='birthdate'  class='datepicker' value= '".
                   $household->birthdate ."'> <br><br>" .
 
              "Relationship : <sp> " .
                    "<input type='text' name='relationship' size = 40 " .
                  "value = '" . $household->relationship . "'><br><br> " .
                     
              "<br>" .
              " <input type='submit' class='button' value='Update'> " .               
              "</form> ";
        return $str;
    }
    
    
    public static function householdList($clientID, $array) {
        
        $str = "<table class='clientTb > " .
                "<tr> ".
                "<th class='row-phone'></th> ".
                "<th class='row-phone'></th> ". 
                "</tr>" .
                "<tr>".
                "<td style='text-align:center'>" .
                   "<form action='/Mustard/index.php'>" .
                        "<input type=\"hidden\" name=\"cmd\" value='245'>" .
                         "<input type=\"hidden\" name=\"clientID\" value='" . $clientID  . "'>" .
                         "<input type = \"submit\" value=\"Add Person\"/ class = 'button'>" .
                          "</form>" .
                "</td>" .
                "<td style='text-align:center'>" .
                "<form action='/Mustard/index.php'>" .
                        "<input type=\"hidden\" name=\"cmd\" value='215'>" .
                         "<input type=\"hidden\" name=\"clientID\" value='" . $clientID . "'>" .
                         "<input type=\"hidden\" name=\"volunteer\" value='" . 0 . "'>" .
                         "<input type = \"submit\" value=\"Back to Client\"/ class='button' >" .
                     "</form>" .
                "</td>" .
                "</tr>" .
                "</table>";
                
        
        $str = $str .
                "<table class=\"clientTb\" >" .
                "<tr>" .
                "<th class=\"row-Name\">Name</th> " .
                "<th class=\"row-Phone\">Birthdate</th>" .
                "<th class=\"row-Phone\">Relationship </th> " .
                "<th class=\"row-Action\"> </th> " .
                "</tr>";
       
        foreach ($array as $row) {
         
             $str = $str . 
                     "<tr>" .                    
                     "<td>" . $row[1] . "</td>" .
                     "<td>" . $row[2] . "</td>" .
                     "<td>" . $row[3] . "</td>" .
                     "<td> <form action='/Mustard/index.php'>" .
                        "<input type=\"hidden\" name=\"cmd\" value='235'>" .
                         "<input type=\"hidden\" name=\"id\" value='" . $row[0] . "'>" .
                         "<input type = \"submit\" value=\"edit\"/ >" .
                          "</form>" .
                     "</td>" .
                     "</tr>";
        }
        
        $str = $str . "</table>";
        
        return $str;
    }
    
    public static function newClient() {
        
        #  "<input type='text' name='nbrOver18' size = '2' value='2'> " .
        
        $str = 
           "<form action = '/Mustard/index.php'>" . 
                "<input type='hidden' name='cmd' value = '205'> " .
              
              "<font color='red'>Last name: </font><sp><sp> " .
                 "<input type='text' name='lastName' size = '60' autofocus><br><br>" .
              "<font color='red'>First name: </font><sp> " .
                    "<input type='text' name='firstName' size = '60'><br><br> " .
              "<font color='red'>Birthdate: </font>&nbsp; " . 
                    "<input name='birthDate'  id='birthDate'  class='datepicker' value='1960-01-01' > <sp><sp>" .
                 
              "<font color='red'>Gender: </font><sp> " .
                "<select name='gender'> ".
                    " <option value='F'>F</option>".
                    " <option value='M'>M</option>".
                    " <option value='O'>O</option>".
                "</select> <br><br>".
                     
                
              "<font color='red'>Adults (18 and above): </font><sp> " 
                ."<select name='nbrOver18'> ".
                    " <option value='1'>1</option>".
                    " <option value='2'>2</option>".
                    " <option value='3'>3</option>".
                    " <option value='4'>4</option>".
                    " <option value='5'>5</option>".
                    " <option value='6'>6</option>".
                    " <option value='7'>7</option>".
                    " <option value='8'>8</option>". 
                     " <option value='9'>9</option>".
                    " <option value='10'>10</option>".
                    " <option value='11'>11</option>".
                    " <option value='12'>12</option>".               
                "</select> ".
                
              "<font color='red'>Children (6 to 17): </font><sp> " 
                ."<select name='nbr6To17'> ".
                    " <option value='0'>0</option>".
                    " <option value='1'>1</option>".
                    " <option value='2'>2</option>".
                    " <option value='3'>3</option>".
                    " <option value='4'>4</option>".
                    " <option value='5'>5</option>".
                    " <option value='6'>6</option>".
                    " <option value='7'>7</option>".
                    " <option value='8'>8</option>". 
                     " <option value='9'>9</option>".
                    " <option value='10'>10</option>".
                    " <option value='11'>11</option>".
                    " <option value='12'>12</option>".               
                "</select> ".
                
              "<font color='red'>Children (5 and under): </font><sp> " 
                ."<select name='nbrUnder5'> ".
                    " <option value='0'>0</option>".
                    " <option value='1'>1</option>".
                    " <option value='2'>2</option>".
                    " <option value='3'>3</option>".
                    " <option value='4'>4</option>".
                    " <option value='5'>5</option>".
                    " <option value='6'>6</option>".
                    " <option value='7'>7</option>".
                    " <option value='8'>8</option>". 
                     " <option value='9'>9</option>".
                    " <option value='10'>10</option>".
                    " <option value='11'>11</option>".
                    " <option value='12'>12</option>".               
                "</select> <br><br>".
                  
              "Street: <sp> " .
                    "<input type='text' name='street' size = '60' value=''> " . 
              "Apartment: <sp> " .
                    "<input type='text' name='apartment' size = '10' value=''><br><br> " .
              "City: &nbsp&nbsp " .
                    "<input type='text' name='city' size = '60' value='Roseville'> " . 
              "State: <sp> " .
                    "<input type='text' name='state' size = '2' value='CA'> " .   
              "<font color='red'>Zip: </font><sp> " .
                    "<input type='text' name='zip' size = '8' value='95'><br><br> " .
                
              "Phone: <sp> " .
                    "<input type='text' name='phone' size = '15' value='916 '> " .
              "Email: <sp> " .
                    "<input type='text' name='email' size = '60' value=''><br><br> " .
              
              "Church member " .
                "<select name='churchMember'> ".
                    " <option value='N'>NO</option>".
                    " <option value='Y'>YES</option>".
                "</select> ".
                    
              "Type " .
                "<select name='type'> ".
                    " <option value='C'>Client</option>".
                    " <option value='L'>Layaway</option>".  
                    " <option value='S'>Staff</option>".
                    " <option value='V'>Volunteer</option>".
                "</select> ".
                
                "Lifescan " .
                "<select name='lifescan'> ".
                    " <option value='N'>NO</option>".
                    " <option value='Y'>YES</option>".
                "</select> <br><br>".
                
                "LayawaySponsor " .
                "<select name='layawaySponsor'> ".
                    " <option value='N'>NO</option>".
                    " <option value='Y'>YES</option>".
                "</select> &nbsp;&nbsp;&nbsp;".
                
                "Sponsor Name " .
                "<select name='sponsorID' > ".
                     "<option value='0' selected> NONE </option>";
                
                $nclient = new Client();
                $arr = $nclient->sponsorList();
                
                foreach ($arr as $row) {   
                    $str = $str . 
                    " <option  value='" . $row[1] . "'>" . $row[0] . "</option>";
                }
                
              $str = $str . "</select> ".
                
              "<br>" .
              " <input type='submit' class='button' value='Submit' style='float:right'> " .               
              "</form> <br>";
        
        return $str;
    }
    
    public static function removeCheckinPrompt() {
        
        $str = 
                "<h4>This is a dangerous function - removing all checkin for the date. </h4><br><br>" .
        "<form action = '/Mustard/index.php'>" . 
              "Checkin Date: <sp><sp> " .
                 "<input type='hidden' name='cmd' value='319' >" .  
                "<input name='checkinDate' id='checkinDate' class='datepicker'>" .
                "<input type='password' name='pin' size = '10'> " .
              " <input type='submit' class='button' value='Remove checkin'> " .               
         "</form> ";
        
        return $str;
    }
}
