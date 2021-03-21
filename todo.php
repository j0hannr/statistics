<?php

session_start();
require_once 'config.php';

mysqli_set_charset($mysqli, "utf8");

// header('Content-Type: text/html; charset=ISO-8859-1');

if ($_SESSION['login']==1) {

    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time()); 
    
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Todo v5</title>
        <!-- <script src="http://code.jquery.com/jquery-1.9.0.js"></script> -->
        <!--<script src="jquery.min.js"></script>-->
        <!--<script src="respond.min.js"></script>-->
        <script src="inc/js/jquery-1.9.1.js"></script>
        <!-- <script src="inc/js/jquery.grid-a-licious.js"></script> -->
        <script src="inc/js/masonry.pkgd.min.js"></script>



        <!-- <link rel="stylesheet" href="inc/css/todo.css" type="text/css" /> -->
        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">
        <link rel="stylesheet" href="inc/css/icon-font.css">

        <script src="inc/js/todo.js"></script>
        <!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" /> -->

    </head>

    <body>

        <!--header-->
        <!--<section id="header">-->
        <!--<div id="date"><p id="day">Monday</p><p id="date">27. of August</p></div>-->
        <!--<div class="button" id="day"><p class="buttontext">Day</p><img src="inc/img/todo.png" class="button" id="todo"/></div>-->
        <!--<div class="button" id="edit"><p class="buttontext">Edit</p><img src="inc/img/pencil.png" class="button" id="edit"/></div>-->
        <!--<div class="button" id="map"><p class="buttontext">Map</p><img class="button" id="map"/></div>-->
        <!--<div class="button" id="settings"><p class="buttontext">Settings</p><img src="inc/img/settings.png" class="button" id="settings"/></div>-->
        <!--</section>-->

        <!-- <div id="dayview"></div> -->


        <div class="container">


            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">Todo</div>
                    <div class="number">

                        <?php
                        $re = mysqli_query($mysqli,"SELECT Count(`check_value`) as todoleft FROM `todo`
                            left join category on category.id = todo.category
                            WHERE todo.user = $id_user AND category.archive = 'false' AND todo.check_value = 'false'");

                        while ($tag = mysqli_fetch_object($re)) {
                            echo  $tag->todoleft;
                        } 
                        ?>

                    </div>
                    <div class="description">Todo's left</div>



                </div>


                <!-- menu  -->
                <?php 
                
                    include 'menu.php';
    
                ?>



            </div>

        </div>


        <section id="todo">


            <!-- <select name='cat' id='cat'> -->
            <?php

  //   $result = mysql_query("SELECT `text`,`id` FROM `category` WHERE `user` = $id_user");
    // while($user = mysql_fetch_object($result))
    // {
  //           $name = $user->text;
    //     $name = htmlentities($name);
  //           $id = $user->id;
  //           echo "<option value='$id'>$name</option>";
  //       }
    ?>
                <!-- </select> -->


        <?php

        $re = mysqli_query($mysqli,"SELECT `text`,category.id, category.color FROM `category`
            LEFT JOIN project ON project.name = category.text
            WHERE category.user = '$id_user' AND archive = 'false'");
        while ($cat = mysqli_fetch_object($re)) {
        $name = $cat->text;
        $name = htmlentities($name);
        $id = $cat->id;
        $color = $cat->color;
        if (!$color) {
            $color = "";
        }

        echo "<ul style='background-color:#".$color.";' class='todo $id' id='$name'>";
        echo "<h1>$name</h1>";
        echo "<div class='catoptions'><div data-icon='F' class='icon edit'></div><div data-icon='H' class='icon archive'></div><div data-icon='I' class='icon color'></div></div>";
        echo "<div class='colors'>
          <div style='background-color:#82f9fc;'>82f9fc</div>
          <div style='background-color:#69ebda;'>69ebda</div>
          <div style='background-color:#3aadfa;'>3aadfa</div>
          <div style='background-color:#277bf9;'>277bf9</div>
          <div style='background-color:#3c5df6;'>3c5df6</div>
          <div style='background-color:#5447e9;'>5447e9</div>
          <div style='background-color:#6445df;'>6445df</div>
          <div style='background-color:#9051f4;'>9051f4</div>
          <div style='background-color:#ab56f6;'>ab56f6</div>

          <div style='background-color:#c85bf7;'>c85bf7</div>
          <div style='background-color:#dc5cea;'>dc5cea</div>
          <div style='background-color:#eb58c7;'>eb58c7</div>
          <div style='background-color:#fcd533;'>fcd533</div>
          <div style='background-color:#4daf50;'>4daf50</div>
          <div style='background-color:#287362;'>287362</div>
          <div style='background-color:#e2e2e2;'>e2e2e2</div>
          <div style='background-color:#7a7a7a;'>7a7a7a</div>
          <div style='background-color:#3e3e3e;'>3e3e3e</div>

        </div>";

        // additional colors


        // echo "<button class='edit'>edit name</button>";
        // echo "<button class='archive'>archive</button>";

        $res = mysqli_query($mysqli,"SELECT `text`,`id`,`check_value` FROM `todo` WHERE `user` = $id_user AND `category` = $id AND (`check_date` > ADDDATE(NOW(), INTERVAL -1440 MINUTE) OR `check_value` = 'false') ORDER BY `position`,`deadline`,`timestamp` ASC");
        while ($todo = mysqli_fetch_object($res)) {
            $tid = $todo->id;
            $text = $todo->text;
            // $text = htmlentities($text);
            // $text = htmlentities($text, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
            $check = $todo->check_value;

            //<input id='$tid' class='text' value='$text'/>
            echo "<li class='todo $check' id='$tid'><div id='$tid' class='check'><img class='check $check' src='inc/img/$check.png'/></div>
            <div id='$tid' style='' class='text'>$text</div>
            <div class='options'><img class='edde edit' src='inc/img/edit.png'/><img class='edde delete' src='inc/img/delete.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";
        
        }

        echo "<li id='$id' class='add todo'><span class='posmoile'>Add Todo</span></li>";
        echo "</ul>";
    } 
    ?>

                    <!-- add category dialog -->
                    <ul class="add todo">
                        <h1>Add Category</hi>
                    </ul>


                    <!-- <div id="seperate_todos"></div> -->





                    <!-- archived todos: -->


    <?php

    $re = mysqli_query($mysqli,"SELECT `text`,category.id, project.name, project.color FROM `category` LEFT JOIN project ON project.name = category.text WHERE category.user = $id_user AND archive = 'true'");
    while ($cat = mysqli_fetch_object($re)) {
        $name = $cat->text;
        $name = htmlentities($name);
        $id = $cat->id;
        $color = $cat->color;
        if (!$color) {
            $color = "";
        }
        echo "<ul class='archived todo $id' id='$name'>";
        echo "<h1>$name</h1>";
        echo "<div class='catoptions'>
        <div style='opacity:0.1;' data-icon='F' class='icon edit'></div>
        <div data-icon='H' class='icon unarchive'></div>
        <div data-icon='G' class='icon delete'></div></div>";


        // echo "<button class='edit'>edit name</button>";
        // echo "<button class='archive'>archive</button>";

        $res = mysqli_query($mysqli,"SELECT `text`,`id`,`check_value` FROM `todo` WHERE `user` = $id_user AND `category` = $id AND (`check_date` > ADDDATE(NOW(), INTERVAL -1440 MINUTE) OR `check_value` = 'false') ORDER BY `deadline`,`timestamp` ASC");
        while ($todo = mysqli_fetch_object($res)) {
            $tid = $todo->id;
            $text = $todo->text;
            // $text = htmlentities($text);
            $text = htmlentities($text, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
            $check = $todo->check_value;

            //<input id='$tid' class='text' value='$text'/>
            echo "<li class='todo $check' id='$tid'><div id='$tid' class='check'><img class='check $check' src='inc/img/$check.png'/></div>
            <div id='$tid' style='' class='text'>$text</div>
            <div class='options'><img class='edde edit' src='inc/img/edit.png'/><img class='edde delete' src='inc/img/delete.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";
        }

        echo "<li id='$id' class='add todo'><span class='posmoile'>Add Todo</span></li>";
        echo "</ul>";
    } 
    ?>

        </section>


        <!-- <ul  class='todo $id' id='$name'>
  <h1>$name</h1>
  <button class='edit'>edit name</button>
  <button class='archive'>archive</button>
  <li id='$id' class='add todo'><span class='posmoile'>Add Todo</span></li>
</ul> -->

        <!-- <li class='todo fals' id='$tid'>
  <div id='$tid' class='check'><img class='check $check' src='inc/img/$check.png'/></div>
  <div id='$tid' style='' class='text'>$text</div>
  <div class='options'>
    <img class='edde edit' src='inc/img/edit.png'/>
    <img class='edde delete' src='inc/img/delete.png'/>
    <img class='cencel writ' src='inc/img/cencel.png'/>
    <img class='done writ' src='inc/img/done.png'/>
  </div>
</li> -->





        <!--for desktops-->
        <!-- <div id="catlist">
    <img src="inc/img/add.png" height="40px" width="40px;" id="addcat"/>
    <ul id="list"> -->
        <?php

  //       $re = mysql_query("SELECT `text`,`id` FROM `category` WHERE `user` = $id_user");
    // while($cat = mysql_fetch_object($re))
    // {
    //     $text = $cat->text;
    //     $text = htmlentities($text);
  //           echo "<li class='category' id='$cat->id'><div id='$cat->id' class='text cattext'>$text</div><div class='options'><img class='edde edit' src='inc/img/edit_cat.png'/><img class='edde delete' src='inc/img/delete_cat.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";
  //       }

        ?>
            <!--<li class='addcat category'>Add ...</li>-->
            <!-- </ul>
</div> -->


    </body>

    </html>

    <?php

} else {
    header('Location: http://'.$host.'/login.php');
}

?>
