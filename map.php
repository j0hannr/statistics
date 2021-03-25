<?php

session_start();
require_once 'config.php';
mysqli_set_charset($mysqli, "utf8");

if ($_SESSION['login']==1){
    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time());

?>


<!DOCTYPE html>
<html>

    <head>
        
        <title>Map v5</title>
        <meta charset="utf-8">
        
        <script type="text/javascript" src="inc/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4"></script>

        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/pickadate.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">
        <link rel="stylesheet" href="inc/css/icon-font.css">
            
        <script src="inc/js/moment.js"></script>
        <script src="inc/js/map.js"></script>

    </head>

    <body>

        <div onload="map_initialize()" id="google_map"></div>

        <input placeholder="search for places..." type="text" class="map-input" id="address" />

        <div id="map_menu" class="container">

            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">Map</div>
                    <div class="number">

                        <?php
                            $re = mysqli_query($mysqli, "Select Count(id) as places from location Where user = $id_user");
                            while($tag = mysqli_fetch_object($re))
                            {
                                echo  $tag->places;
                            }
                        ?>

                    </div>
                    <div class="description">Places</div>

                </div>

                <?php include 'menu.php';?>

            </div>

        </div>

    </body>

</html>

<?php

}
else {
    header('Location: http://'.$host.'/login.php');
}

?>
