<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";

$str ="";
/**
require MODEL."State.php";

$title = "About Food Closet";
$state = new State();
                $counter = $state->counter;
                $isFrozen = "OFF";
                if ($state->isFreeze())
                    $isFrozen = "ON";
                $str = "Checkin Counter = " . $counter . "<br>" .
                            "Frozen = " . $isFrozen . "<br>";
 * 
 */
$title = "Home Page";
$sideContent = '<b><a href="/Mustard/view/help.php">Help</a></b><br><br>' 
    . 'To connect from another laptop or mobile device, use this address <br>' 
        . "<h3>"    
        . getHostByName(getHostName())
        . "</h3>"
        . $str
        . "<br>"
        . "Do a reset if you are starting a new day of checkin.";
        
$content = '
        <img src="/Mustard/Images/coffee1.png" class="imgLeft" />
        <h3>MISSION</h3>
        <ul>
            <li>To provide food to the needy</li>
            <li>To provide other assistance</li>
            <li>To provide a safe place to talk and share</li>
            <li>To provide a place to pray together</li>
        </ul>
    
        <img src="/Mustard/Images/coffee2.png" class="imgRight" />
        <h3>VISION</h3>
         
        The clients are our mission field. <br>
        
        We want to treat each of them coming to the Food Closet with dignity and compassion.
        <br>
        We want to serve them with a sense of servitude and grace. <br>
            
        Our wish for each of them is to get to know Christ and His saving grace. <br>
            
            <br>
            We wish to engage them in conversation to know more about them and see what ways we can assist. <br>
            We wish to help them in their current situation. 
            <br>
            We strive to provide or refer services as much as we are able. 
            <br><br>
            Here are some suggested action items
            <ul>
                <li>Provide some ice water and cookies in the front and waiting room</li>
                <li>Rearrange the waiting room to be a causual sitting area</li>
                <li>Call for volunteers who can interact with clients</li>
                <li>Connect with external services whom we can refer clients</li>
                <li>Declare the clients as a mission field</li
            </ul>
        
         <h3>AREAS OF SERVICE</h3>
        
        <ul>
         <li>Set up the tables (8.30 am)</li>
         <li>Get the food from Food Bank (9.30 am - 11.00 am)</li>
         <li>Check in clients at the front desk (12.00 - 1.00 pm)</li>
 
       </ul> 

        
         
         <h3>RULES for Volunteers</h3>
         
         <ul>
         <li><b>Forms to sign </b>
              <ul>
                  <li>Every volunteer must sign a waiver form on injury</li>
                  <li>Every volunteer must fill out the volunteer form </li>
              </ul>
         </li>
         <li><b>Working Hours </b>
            <ul>
               <li>Arrive at least 10 mins before designated time</li>
               <li>Work the full designated period.</li>
               <li>Do not leave until the supervisor indicates the operation is completed. </li>
               <ul> <i>Example:
                 <li>Setup includes unloading and setting up the food. It also includes removing bad food. </li>
                 <li>Setup is not completed until supervisor says it is completed</li></i>
               </ul>
            </ul>
         </li>
         
        <li><b>Days of service </b>
            <ul>
                <li>Let the supervisor know the next few Fridays you can serve</li>
                <li>If you cannot come on designated day, please inform supervisor ASAP</li>
            </ul>
        </li>
             
         <li><b>Food Distribution</b>
           <ul>
               <li>Be aware of the food handling requirements</li>
               <li>Inform clients poliltely on the correct procedures of picking fresh produce esp fruits and vegetables</li>
               <li>Listen for the food quota announcements</li>
               <li>Politely limit each client on the amount of food per their household total</li>
            </ul>
         </li>
         <li><b>Client Management</b>
           <ul>
              <li>Make sure client exits at the designated door and no re-entry</li>
              <li>Make sure that a client does not come for a 2nd time until all clients have at least one time</li>
              <li>No client is allowed to leave bags on the distribution area</li>
              <li>No client is allowed to go against the flow </li>
              
           </ul>
        </li>
        <li><b>Layaway and Sponsors </b>
              <ul>
                  <li>A Layaway is a client who cannot physically come to the Food Closet.</li>
                  <li>Food is packed and lay aside for layaway.</li>
                  <li>A Sponsor is a volunteer associated with layaway(s).
                  <li>A Sponsor packs the food for layaway(s). The food is either delivered or picked up.</li>
                  <li>When the sponsor is not present, food for layaway(s) are not packed </li>
                  <li>Only Sponsors are allowed to deliver or put away food to a layaway client</li>
                  <li>Normal clients are not permitted to be Sponsors. </li>
                  <li>Normal clients are not permitted to pack food for another client</li>
              </ul>
         </li>
         
         <li><b>Exceptions to the rules</b>
            <ul>
                <li>Rules are written to provide a consistent treatment for volunteers and clients.</li>
                <li>Rules remove ambuiguity and confusion on known situations</li>
                <li>When an unknown situation comes up, it must be discussed and agreed on the path of action.
                   <ul><li>A rule may be derived from the agreed course of action.</li></ul>
                 </li>
                <li>Exceptions are considered as "breaking the rules for known situations"</li>
                <li>Exceptions are to be agreed by a quorum of volunteers present. </li>
                <li>When an exception is allowed, it will set a precedent. It may produce inconsistent treatment for future similar situations.</li>
            </ul>
         </li>
       
         </ul>
         
          

         <img src="/Mustard/Images/coffee3.png" class="imgLeft" />
         <h3>OPERATIONS</h3>
         
            <ul>
                <li>Every Friday, a food distribution center is setup in the café area of the church</li>
                <li>Food is distributed to clients between the hours of 4.30 pm to 6.00 pm. </li>
                <li>Our main food source is Placer County Food Bank. </li>
                <li>Every Friday before noon, some volunteers go to the Food Bank and get a certain amount of food.</li>
                <li>The Food Bank charges us a certain amount for the food. </li>
                <li>On arrival back to Food Closet, the food is unloaded and set up for distribution.</li>
                <li>The setup volunteers unload the food, and set it up on the tables. The bad food is separated and thrown away. </li>
                <li> At the front desk
                <ul>
                 <li> The front door opens at 4.00 pm. </li>
                 <li> Each client is checked in, assigned a tag showing their household number </li>
                 <li> The priority is not first time first served, but rather each client is given a randomize ranking</li>
                 <li> There is a waiting room for clients to hang around </li>
                 <li> At 4.30 pm, the front leader will lead the group in prayer </li>
                 <li> The front leader will announce the names of each group to get their food </li>
                </ul>
                <li>Reports
                  <ul>
                    <li>A monthly report is sent to Placer County Food Bank on the number of people served and the number of bags provided </li>
                    <li>Same report is also sent to the church committee</li>
                  </ul>
            </ul>
         ';

include_once CONFIG."parameters.php";
include TEMPLATE."mTemplate.php";

?>