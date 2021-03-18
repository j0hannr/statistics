<?php

session_start();
require_once 'config.php';
mysqli_set_charset($mysqli, "utf8");

if ($_SESSION['login']==1) {
    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time()); 
    
?>



<!doctype html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Statistics v5</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src='inc/js/jquery-1.9.1.js'></script>

        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4"></script>

        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/pickadate.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">
        <!-- icon font -->
        <link rel="stylesheet" href="inc/css/icon-font.css">
    </head>

    <body>

        <div class="container">


            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">TODAY</div>
                    <div class="number">24</div>
                    <div class="description">Dezember</div>

                </div>


                <!-- menu -->
                <?php 
                
                include 'menu.php';

                $id_user = "1";
                $date = "2021-03-29";
                $location = "2";
                $timestamp = date('Y-m-d H:i:s', time());
    
                ?>

            </div>


            <!-- day timeline -->
            <div class="day_timeline" class="row">
                <div class="twelve columns">
                    <div id="dailyactivity">
                        <!-- day timeline placed here -->
                    </div>
                </div>
            </div>

            <!-- tags and buttons to todos and timeline -->
            <div class="tags" class="row">

                <div class="eleven columns">
                    <div id="tagbox">
                        <div id="tags">
                            <!-- tags go in here -->
                            <span contenteditable="true" id="write" class="tag"></span>
                        </div>
                    </div>
                </div>
                <div class="one column">

                    <div class="weather_icon">
                        <!-- <div data-icon="a" class="icon"></div> -->
                    </div>
                    <div class="degrees">
                        <p id="temperature">11°</p>
                    </div>


                </div>
            </div>


            <!-- fields text location -->
            <div class="fields_text_location" class="row">
                <!-- fields -->
                <div class="one-third column fields">

                    <div id='fieldarea'>
                        <!-- fields go in here -->
                    </div>

                </div>

                <!-- text -->
                <div class="one-third column">
                    <div id="typewriter" data-icon="E" class="icon"></div>

                    <textarea id="story">
		    	    </textarea>

            </div>

            <!-- location -->
            <div style="background-color: #dddddd;" class="one-third column">


                <div id="gmap">
                    <!-- google map -->
                </div>


                <!--Location-->
                <select id="location">
                    <?php

                    $result = mysqli_query( $mysqli, "SELECT `id`,`name` FROM `location` WHERE user='$id_user' ORDER BY location.id = '12' DESC");
                    while ($day = mysqli_fetch_object($result)) {
                        $name = $day->name;
                        $id = $day->id;
                        echo "<option value='$id'>$name</option>";
                    } 
                    ?>
                </select>

                <a class="icon" href="map.php">
                    <div data-icon="e" id="map_link" class="icon stats_size"></div>
                </a>

            </div>

        </div>


        <!-- pick a date -->
        <fieldset>
            <input id="input_date" class="datepicker" type="text">
        </fieldset>


        <!-- scripts -->
        <script src="inc/js/pickadate.js"></script>
        <script src="inc/js/script.js"></script>
        <script src="inc/js/moment.js"></script>


    </body>

</html>

 <?php

} 
else {
    header('Location: http://'.$host.'/login.php');
}

?>
