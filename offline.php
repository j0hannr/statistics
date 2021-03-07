<?php
session_start();
require_once 'config.php';
mysql_set_charset("utf8");
if ($_SESSION['login']==1) {
    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time()); ?>



    <!doctype html>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Statistics v5</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src='inc/js/jquery-1.9.1.js'></script>

        <!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4"></script> -->

        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/pickadate.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">
        <!--font-->
        <!--<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>-->
        <!--<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>-->


        <link rel="stylesheet" href="inc/css/icon-font.css">

    </head>

    <body>


        <!--Logged out reminder-->
        <!-- <div id="screencover">
<div id="loginreminder">
    <p id="loginreminder"><span id="sorry">sorry,</span><br><span class="highlight">you are not logged in anymore.</span><br><span class="highlight">just click here to login</span><br><span class="highlight">again...</span></p>
</div>
</div> -->


        <!-- site -->
        <!-- selelect date -->

        <!-- https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4&center=-33.9,151.14999999999998&zoom=12&format=png&maptype=roadmap&style=element:geometry%7Ccolor:0xf5f5f5&style=element:labels.icon%7Cvisibility:off&style=element:labels.text.fill%7Ccolor:0x616161&style=element:labels.text.stroke%7Ccolor:0xf5f5f5&style=feature:administrative.land_parcel%7Celement:labels.text.fill%7Ccolor:0xbdbdbd&style=feature:poi%7Celement:geometry%7Ccolor:0xeeeeee&style=feature:poi%7Celement:labels.text.fill%7Ccolor:0x757575&style=feature:poi.park%7Celement:geometry%7Ccolor:0xe5e5e5&style=feature:poi.park%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&style=feature:road%7Celement:geometry%7Ccolor:0xffffff&style=feature:road.arterial%7Celement:labels.text.fill%7Ccolor:0x757575&style=feature:road.highway%7Celement:geometry%7Ccolor:0xdadada&style=feature:road.highway%7Celement:labels.text.fill%7Ccolor:0x616161&style=feature:road.local%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&style=feature:transit.line%7Celement:geometry%7Ccolor:0xe5e5e5&style=feature:transit.station%7Celement:geometry%7Ccolor:0xeeeeee&style=feature:water%7Ccolor:0xffffff&style=feature:water%7Celement:geometry%7Ccolor:0xffffff&style=feature:water%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&size=480x360 -->



        <div class="container">


            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">TODAY</div>
                    <div class="number">24</div>
                    <div class="description">Dezember</div>





                </div>
                <!-- menu / weather -->
                <?php 
                
                    include 'menu.php';
    
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
                <!--
<div class="one column">
    <a class="icon" href="todo.php">
        <div data-icon="o" class="icon stats_size"></div>
    </a>
</div>
-->
                <div class="eleven columns">
                    <div id="tagbox">
                        <div id="tags">
                            <!-- tags go in here -->
                            <span contenteditable="true" id="write" class="tag"></span>
                        </div>
                    </div>
                </div>
                <div class="one column">
                    <!--
                    <a class="icon" href="timeline.php">
                        <div data-icon="f" id="rightalign" class="icon stats_size"></div>
                    </a>
-->

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


                        <!-- sample: -->
                        <!-- <div id="run" class="field 7583">
					<img class="buttons plus" src="inc/img/plus_2.png">
					<img class="buttons minus" src="inc/img/minus_2.png">
					<p class="number 1" id="run">
						<span class="value">2</span>
						<span class="lable">km</span></p>
					<p class="name">run</p>
				</div> -->


                    </div>

                    <!-- <div>
				<div class="number">5.23<span class="unit">km</span></div>
				<div class="field_name">Run</div>
				<div data-icon="g" class="icon"></div>
			</div>

			<div>
				<div class="number">18<span class="unit">km</span></div>
				<div class="field_name">Bike</div>
				<div data-icon="h" class="icon"></div>
			</div>

			<div>
				<div class="number">3<span class="unit">h</span> 39<span class="unit">min</span></div>
				<div class="field_name">Work</div>
				<div data-icon="i" class="icon"></div>
			</div>

			<div>
				<div class="number">7.29<span class="unit">km</span></div>
				<div class="field_name">Walk</div>
				<div data-icon="j" class="icon"></div>
			</div>

			<div>
				<div class="number">29<span class="unit">€</span></div>
				<div class="field_name">Outflow</div>
				<div data-icon="k" class="icon"></div>
			</div> -->


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
                $result = mysql_query("SELECT `id`,`name` FROM `location` WHERE user='$id_user' ORDER BY NAME ASC");
    while ($day = mysql_fetch_object($result)) {
        $name = $day->name;
        $id = $day->id;
        echo "<option value='$id'>$name</option>";
    } ?>

			</select>

                    <a class="icon" href="map.php">
                        <div data-icon="e" id="map_link" class="icon stats_size"></div>
                    </a>
                </div>

            </div>

        </div>



        <!-- pick a date -->
        <fieldset>
            <input id="input_date" class="datepicker" type="text">
        </fieldset>





        <!-- scripts -->
        <script src="inc/js/pickadate.js"></script>
        <script src="inc/js/offline.js"></script>
        <script src="inc/js/moment.js"></script>




    </body>

    </html>

    <?php

} else {
    header('Location: http://'.$host.'/login.php');
}

?>
