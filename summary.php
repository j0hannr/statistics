<?php
session_start();
require_once 'config.php';
mysqli_set_charset($mysqli, "utf8");
header('Content-Type: text/html; charset=ISO-8859-1');
if ($_SESSION['login']==1) {
    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time()); ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Statistics v5 - Summary</title>

        <script src="inc/js/jquery-1.9.1.js"></script>
        <!-- <script src="inc/js/masonry.pkgd.min.js"></script> -->

        <link rel="stylesheet" href="inc/css/summary.css" type="text/css" />
        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">
        <link rel="stylesheet" href="inc/css/icon-font.css">

        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    </head>

    <body>

        <div class="container">


            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">Summary</div>
                    <div class="number">
                        <?php echo date("F", strtotime("this month")); ?>
                    </div>
                    <div class="description">vs
                        <?php echo date("F", strtotime("last month")); ?>
                    </div>

                </div>
                <!-- menu  -->
                <?php 
                
                    include 'menu.php';
    
                ?>
            </div>

        </div>


        <section id="summary">

            <div id="summary"></div>

        </section>

        <!-- scripts -->
        <script src="inc/js/summary.js"></script>
        <script src="inc/js/moment.js"></script>

    </body>

    </html>

    <?php

} else {
    header('Location: http://'.$host.'/login.php');
}

?>
