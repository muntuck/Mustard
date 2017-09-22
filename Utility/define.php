<?php

define("BASEDIR", $_SERVER["DOCUMENT_ROOT"]."/Mustard");
define("VIEW", BASEDIR."/view/");
define("MODEL", BASEDIR."/Model/");
define("CONTROLLER", BASEDIR."/Controller/");
define("TEMPLATE", BASEDIR."/Template/");
define("PHOTOS", BASEDIR."/Photos/");
define("CONFIG", BASEDIR."/Config/");
define("EXTERNAL", BASEDIR."/External/");
define("MAIL", BASEDIR."/Mail/");

// Help instructions

define ("DATE_FORMAT", "<h4>Acceptable Date Formats</h4> " . 
            " <ul> " .
            "    <li>YYYY-MM-DD</li> " .
            "    <li>May-10-1945</li> " .
            "    <li>12-Dec-1965</li> " .
            "</ul>");

define ("EXISTING_HELP", "<h4>Search for a client</h4>"
        . "Key the first one, two or three characters of the last name or first name<br>" 
            . "If you leave both blank, the whole client list is displayed<br><br>"
            . "You can hit ENTER key instead of click<br><br>" 
                . "The display shows the last name first in alphabetical order");

define ("LAYAWAY_HELP", "<h4>Layaway and Sponsor</h4>"
        . "A layaway is a client who cannot come to Food Closet. Food is packed "
        . " and put aside for him/her. A volunteer called a Sponsor, brings it to him/her. <br><br> "
        . "To be a layaway Sponsor, this person has to be a volunteer first. <br><br>"
        . "Associate this client with a Sponsor. <br>"
        
        
        );


