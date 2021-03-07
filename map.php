<?php
session_start();
require_once 'config.php';
mysql_set_charset("utf8");
if ($_SESSION['login']==1){
$id_user = $_SESSION['id'];
$today = date('Y-m-d', time());
?>


    <!DOCTYPE html>
    <html>

    <head>
        
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

        
        <title>Map v5</title>
        <meta charset="utf-8">
        
        <script type="text/javascript" src="inc/js/jquery-1.9.1.js"></script>
        
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4"></script>





        <!-- <link rel="stylesheet" href="inc/css/map.css"> -->
        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/pickadate.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">
        <!--font-->
        <!--<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>-->
        <!--<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>-->


        <link rel="stylesheet" href="inc/css/icon-font.css">
        
        
        <script src="inc/js/moment.js"></script>
        <script src="inc/js/map.js"></script>



    </head>

    <body>








        <!--<h1 class="heading">My Google Map</h1>-->
        <!--<div align="center">Right Click to Drop a New Marker</div>-->
        <div onload="map_initialize()" id="google_map"></div>

        <input placeholder="search for places..." type="text" class="map-input" id="address" />
        <!--<input style="position: absolute; top: 60px;" type="button" class="ap-input" id="getlocation" value="Show Location on Map" onclick="codeAddress();" />-->


        <div id="map_menu" class="container">


            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">Map</div>
                    <div class="number">

                        <?php
        $re = mysql_query("Select Count(id) as places from location Where user = $id_user");
        while($tag = mysql_fetch_object($re))
        {
            echo  $tag->places;
        }
        ?>


                    </div>
                    <div class="description">Places</div>





                </div>
                <!-- menu / weather -->
                <?php 
                
                    include 'menu.php';
    
                ?>
            </div>

        </div>




    </body>

    </html>

    <?php

}
else{
header('Location: http://'.$host.'/login.php');
}

?>
