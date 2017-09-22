<?php
$title = "How to use Mustard";
$sideContent = 'Documentation is still in progress';
$content = '  
        <h3>Some notes on the use of Mustard</h3>
 
<ul>
    <li><b>Do this before doing any checkin</b></li>
    <ul>
        <li>Go to Utility to do a resetAll</li>
    </ul>

    <li><b>Checkin</b></li>
        <ul>
            <li>Existing Clients</li>
                <ul>
                    <li>Client->Existing. Select the client by click on name</li>
                    <li>At the client display, the checkin button is located on the top right</li>
                    <li>If the client is already checked in, there will be a Pool button</li>
                </ul>
            <li>Volunteers</li>
                <ul>
                    <li>Volunteer->checkin</li>
                </ul>
            <li>Layaways</li>
                <ul>
                    <li>Do Client->Layaway</li>
                </ul>
        </ul>
        
    
    <li>Checkin List</li>
    <ul>
        <li>Checkin list provides a near real-time (5 secs delay) display of the clients checked in</li>
        <li>Each recent checkin is display at the top of the list with a time stamp</i>
        <li>This checkin list provides a list of clients checked in according to time</li>
        <li>On the left is a button to randomize. This provides a reprioritization of list in a lottery manner</li>
        <li>You can do randomize any number of times. Once you are satisfied, you can freeze the list. This means anybody after the freeze is placed at the end of the list</li>
    </ul>
    
    <li>Statistics</li>
    <ul>
        <li>Go to Statistics</li>
        <li>Only option available is to print out the statistics required by Food Bank</l>
    </ul>
    
    <li>Volunteers</li>
    <ul>
        <li>This provides a list of people who are volunteers</li>
        <li>Click on checkin against the name</li>
        <li>The other two columns are for volunteers to indicate whether they can come the next two weeks</li>
        <li>You have to print out this page for volunteer sign up and check the checkin box</li>
        <li>Remember to take this form and click on the checkin for each volunteer on the day itself.</li>
    </ul>
    
    <li>Layaway</li>
    <ul>
        <li>Layaways are clients who cannot come to the Closet</li>
        <li>Food is packed for them by a sponsor (volunteer)</li>
        <li>Food is delivered to the layaways by various means</li>
        <li>You need to checkin the layaways as it counts towards the statistics</li>
    </ul>
    
    <li>Deletion and backup</li>
    <ul>
        <li>No deletion is provided from this Mustard Interface</li>
        <li>Deletion is provided through another interface using PhpMyAdmin</li>
        <li>To use this requires a greater understanding</li>
        <li>To usee this requires you to be on the machine that is running Mustard</li>
        <li>Backup is provided by a different interface - UniController.exe</li>
    </ul>
    
    <li>For support</li>
    <ul>
        <li>Send email to muntuck@gmail.com </li>
    </ul>
</ul>

        

         

';

include $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";
include CONFIG."parameters.php";
include TEMPLATE."mTemplate.php";

?>