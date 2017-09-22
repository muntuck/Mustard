<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="/Mustard/Styles/mstyle.css" /> 
    <link rel="stylesheet" type="text/css" href= "/Mustard/Styles/datepicker.css" /> 
    <script type="text/javascript" src="/Mustard/External/DatePicker/datepicker.js" ></script>
    <script type="text/javascript" src= "/Mustard/External/DatePicker/timepicker.js" ></script>

</head>

<body>
    <div id="wrapper">
        <div id="banner">    
            <center><h1> <?php echo AGENCY; ?> </h1></center>
            <center><b>Community Client Management</b></center>
        </div>
        <nav>
            <ul>
                <li><a href="/Mustard/view/home.php">Home</a></li>
                <li><a href="#">Person &#9662;</a>
                    <ul class="dropdown">                 
                        <li><a href="/Mustard/index.php?cmd=200">New</a></li>
                        <li><a href="/Mustard/index.php?cmd=100">Existing</a></li>
                    </ul>
                </li>
                <li><a href="#">Checkin &#9662;</a>
                    <ul class="dropdown">                 
                        <li><a href="/Mustard/index.php?cmd=400">Volunteer</a></li>
                        <li><a href="/Mustard/index.php?cmd=430">Volunteer Signup</a></li>
                        <li><a href="/Mustard/index.php?cmd=440">Staff</a></li>
                        <li><a href="/Mustard/index.php?cmd=500">Layaway</a></li>
                        <li><a href="/Mustard/index.php?cmd=304">Freeze Checkin</a></li>
                    </ul>
                </li> 
                <li><a href="#">Display &#9662;</a>
                    <ul class="dropdown">        
                        <li><a href="/Mustard/index.php?cmd=300">Checkin</a></li>
                        <li><a href="/Mustard/index.php?cmd=309">Frozen</a></li>
                        <li><a href="/Mustard/index.php?cmd=350">Pool</a></li>
                    </ul>
                </li>

                <li><a href="#">Reports &#9662;</a>
                    <ul class="dropdown">
                        <li><a href="/Mustard/index.php?cmd=700">Bags&Meals</a></li>
                        <li><a href="/Mustard/index.php?cmd=710">ZipCode</a></li>
                        <li><a href="/Mustard/index.php?cmd=720">Lifescan</a></li>
                         <li><a href="/Mustard/index.php?cmd=730">Volunteers NextWeek</a></li>
                    </ul>
                </li>
                <li><a href="#">Status &#9662;</a>
                    <ul class="dropdown">
                        <li><a href="/Mustard/index.php?cmd=311">Status</a></li>
                        <li><a href="/Mustard/index.php?cmd=317">resetAll</a></li>
                        <li><a href="/Mustard/index.php?cmd=315">unFreeze</a></li>
                        
                    </ul>
                </li>
                <li><a href="#">CleanUp &#9662;</a>
                    <ul class="dropdown">
                        <li><a href="/Mustard/index.php?cmd=550">move Client to front</a></li>
                        <li><a href="/Mustard/index.php?cmd=333">remove Client Checkin</a></li>
                        <li><a href="/Mustard/index.php?cmd=338">remove Volunteer Checkin</a></li>
                        <li><a href="/Mustard/index.php?cmd=318">removeLayaway</a></li>
                        <li><a href="/Mustard/index.php?cmd=600">editPool</a></li>
                    </ul>
                </li>
                
                <li><a href="#">Query &#9662;</a>
                    <ul class="dropdown">
                        <li><a href="/Mustard/index.php?cmd=900">Clients</a></li>
                        <li><a href="/Mustard/index.php?cmd=950">Volunteers</a></li>
                    </ul>
                </li>
                <li><a href="#">Mail &#9662;</a>
                    <ul class="dropdown">
                        <li><a href="/Mustard/index.php?cmd=800">Reminders</a></li>
                        <li><a href="/Mustard/index.php?cmd=805">Special</a></li>
                        <li><a href="/Mustard/index.php?cmd=810">Clients</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div id="content_area">
            <?php echo $content; ?>
        </div>
            
        <div id="sidebar">
            <?php echo $sideContent; ?>
        </div>
    
        <footer>
            <p id="footerLine"><b>All rights reserved by Manigrid @2016-2017</b></p>
        </footer>
        
    </div>
    
</body>
</html>                                		