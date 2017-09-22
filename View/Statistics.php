<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";

require_once(MODEL."Zipcode.php");
require_once(MODEL."Visit.php");
require_once(CONFIG."parameters.php");
 
/*
 * Place to put all the methods for statistics
 * 
 */

class Statistics {

    
    public static function statsParameters() {

        $str = 
           "<form action = '/Mustard/index.php'>" . 
              "From: <sp><sp> " .
                 "<input type='hidden' name='cmd' value='701' >" .  
                "<input name='fromDate' id='fromDate' class='datepicker'>" .
               "to: <sp> " .
                    "<input name='toDate' id='toDate' class='datepicker'><br><br> " .
              " <input type='submit' class='button' value='Generate Report'> " .               
              "</form> ";
         
         return $str;
    }
     
    
    public static function usageStatistics($fromDate1, $toDate1) {
        
        // convert the dates from datepicker to MySQL format
        $timestamp = strtotime($fromDate1);
        $fromDate = date("Y-m-d", $timestamp);
        $timestamp = strtotime($toDate1);
        $toDate= date("Y-m-d", $timestamp);
         
        $visit = new Visit();
        $row = $visit->visitStats($fromDate, $toDate);
       
        $nbrFamilies = $row[0];
        $adultsServed = $row[1];
        $childrenServed = $row[2] + $row[3];
        $totalPersons = $adultsServed + $childrenServed;
        $bags = ceil($totalPersons * BAG_MULTIPLIER);
        
        $visit = new Visit();
        $row = $visit->volunteerNbr($fromDate, $toDate);
        $nbrVolunteers = $row[0];
        
        $visit = new Visit();
        $row = $visit->staffNbr($fromDate, $toDate);
        $nbrStaff = $row[0];
        
        $visit = new Visit();
        $row = $visit->layawayNbr($fromDate, $toDate);
        $nbrLayaways = $row[0];
        
        $visit = new Visit();
        $row = $visit->clientNbr($fromDate, $toDate);
        $nbrClients = $row[0];
        
        $str = "<h4>Report on Number of Families served and bags of food</h4>" .
                "<br><b>" . $fromDate .
                " to &nbsp" . $toDate .
                 "</b><br><br>";

        $str = $str .
                
                "<br># clients &nbsp&nbsp&nbsp&nbsp&nbsp = " . $nbrClients  .
                "<br># volunteers = " . $nbrVolunteers  .
                "<br># staff &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp     = " . $nbrStaff  .
                "<br># layaways &nbsp  = " . $nbrLayaways . "<br><br><br>" .
                    
                "<table class=\"clientTb\" >" .
                "<tr>" .
                    "<th class=\"row-Value\"></th> " .
                    "<th class=\"row-Field\"></th>" . 
                "</tr>" . 
                "<tr> " .
                    "<td># Families Served </td>".
                    "<td>" .$nbrFamilies . "</td>".
                "</tr>" .
                "<tr> " .
                    "<td># of Adults Served </td>".
                    "<td>" .$adultsServed . "</td>" .
                "</tr>" .
                "<tr> " .
                    "<td># Children (17 & under) Served" . "</td>".
                    "<td>" . $childrenServed . "</td>" .
                "</tr> " .
                "<tr>" .
                    "<td>Total # Individuals </td>".
                    "<td>" . $totalPersons . "</td>" .
                "</tr>" .
                "<tr> " .
                    "<td> Total # Bags Provided </td>" .
                    "<td>" . $bags . "</td>" .
                "</tr>" .
                "<tr> " .
                    "<td> Total # Meals Provided </td>" .
                    "<td>" . $bags * MEAL_MULTIPLIER . "</td>" .
                "</tr>" .
                "</table>" ;
        
        // get the zipcodes of these visits
        
        // $visit = new Visit();
        // $array = $visit->visitZipStats($fromDate, $toDate);
        // $str = $str . Statistics::zipStats($array);
                  
        return $str;
     }
     
    
     public static function zipStats($array) {
         
         $total = 0;
         foreach ($array as $row) {
            $total = $total + $row[1];
         }
          
        $str = "<br>"
                . "<br><br>Number of [clients + volunteers + layaways] = " . $total . "<br><br>" 
                . "<table class=\"clientTb\" >" 
                . "<tr>" 
                .    "<th class=\"row-Number\">Zip Code</th> " 
                .    "<th class=\"row-Name\">Place</th> " 
                .    "<th class=\"row-Number\">Number</th>" 
                .    "<th class=\"row-Number\">Percent</th>" 
                . "</tr>" ;
        
                
                foreach ($array as $row) {
                    $place = Zipcode::zipCity($row[0]);
                    
                    $str = $str  .
                    "<tr> " .
                    "<td>" . $row[0] . "</td>".
                    "<td>" . $place . "</td>".
                    "<td>" .$row[1] . "</td>".
                    "<td>" . number_format($row[1]*100/$total, 1) . "</td>" .
                "</tr>";
                }
                
                $str = $str . "</table>" ;
                  
        return $str;
     }
  
    
     public static function clientQueries() {
         
         $str = "<form action = '/Mustard/index.php'>" 
            .  "<input type='hidden' name='cmd' value='901'>" 
            . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;Visits > "
            .  "<input type='text' name='number' value='5' size='3'>" 
            . "&nbsp&nbsp"
            . "<input type = 'submit' class='button' value='Find'  >" 
            . "</form>" ;
         
         $str = $str . "<br><form action = '/Mustard/index.php'>" 
            .  "<input type='hidden' name='cmd' value='902'>" 
            . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;Visits < "
            .  "<input type='text' name='number' value='5' size='3'>" 
            . "&nbsp&nbsp"
            . "<input type = 'submit' class='button' value='Find'  >" 
            . "</form>" ;
         
         $str = $str . "<br><form action = '/Mustard/index.php'>" 
            .  "<input type='hidden' name='cmd' value='903'>" 
            . "&nbsp&nbsp&nbsp&nbsp&nbspHousehold > "
            .  "<input type='text' name='number' value='5' size='3'>" 
            . "&nbsp&nbsp"
            . "<input type = 'submit' class='button' value='Find'  >" 
            . "</form>" ;
         
         $str = $str . "<br><form action = '/Mustard/index.php'>" 
            .  "<input type='hidden' name='cmd' value='904'>" 
            . "&nbsp&nbsp&nbsp&nbsp&nbspHousehold < "
            .  "<input type='text' name='number' value='5' size='3'>" 
            . "&nbsp&nbsp"
            . "<input type = 'submit' class='button' value='Find'  >" 
            . "</form>" ;
         
         $str = $str . "<br><form action = '/Mustard/index.php'>" 
            .  "<input type='hidden' name='cmd' value='905'>" 
            . "Children under 5 years &nbsp&nbsp"
            . "<input type = 'submit' class='button' value='Find'  >" 
            . "</form>" ;
         
         return $str;
     }
     
}