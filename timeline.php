
<?php
session_start();
require_once 'config.php';
mysqli_set_charset($mysqli, "utf8");

if ($_SESSION['login']==1) {
    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time()); ?>

<!--
- clean up
- name and projekt

- layer height = timeline heightx
- grid [a,b] a = 1; b = layer height / 2
- timeline length = 8760 (day length * 365)
- day length = 24
- timeline height = layer height * layer count
- .dateline = layer height * layer count
-->



<!doctype html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Timeline v5</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <script src='inc/js/jquery-1.9.1.js'></script> -->

        <!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4"></script> -->

        <link rel="stylesheet" href="inc/css/style.css">
        <link rel="stylesheet" href="inc/css/pickadate.css">
        <link rel="stylesheet" href="inc/css/normalize.css">
        <link rel="stylesheet" href="inc/css/skeleton.css">

        <link rel="stylesheet" href="inc/css/jquery-ui.css">

        <link rel="stylesheet" href="inc/css/icon-font.css">

        <script src="inc/js/jquery-1.12.4.js"></script>
        <script src="inc/js/jquery-ui.js"></script>

    </head>

    <body>


        <!-- Logged out reminder-->
        <!-- <div id="screencover">
<div id="loginreminder">
    <p id="loginreminder"><span id="sorry">sorry,</span><br><span class="highlight">you are not logged in anymore.</span><br><span class="highlight">just click here to login</span><br><span class="highlight">again...</span></p>
</div>
</div> -->

        <div style="position: fixed;left: 3.5%;" class="container">


            <!-- date & menu -->
            <div class="date_menu" class="row">
                <!-- today -->
                <div id="date" class="three columns">
                    <div class="sitename">Timeline</div>
                    <div class="number">
                        <?php echo date("d"); ?>
                    </div>
                    <div class="description">
                        <?php echo date("F"); ?>
                    </div>





                </div>
                <!-- menu  -->
                <?php 
                
                    include 'menu.php';
    
                ?>
            </div>


        </div>

        <div id="timeline">




            <?php

  // ni_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

    $begin = new DateTime('2021-01-01');
    $end = new DateTime('2022-01-01');

    $qu_begin = '2021-01-01';
    $qu_end = '2021-12-31';
    

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    foreach ($period as $dt) {
        // echo $dt->format( "l Y-m-d H:i:s\n" );

        $today = date("Y-m-d");
        // $today = "2018-02-14";

        // echo "<a class='date' href='http://localhost/statistics_v5/today.php#". $dt->format("Y-m-d")."'>";

        if ($dt->format("Y-m-d") == $today) {
            echo "<div class='dateline today snap'>";
        } elseif ($dt->format("d") == 01) {
            // echo $dt->format("M");
              echo "<div class='dateline month snap'>";

        } else {
            echo "<div class='dateline snap'>";
        }


        echo "<a class='date' href='today.php#". $dt->format("Y-m-d")."'>";
        echo $dt->format("j"); // d = 01
        echo "</a>";



        // echo "<a class='date' href='localhost/statistics_v5/today.php#". $dt->format("Y-m-d")."'></a>";
        // echo "<span class='date'>". $dt->format("Y-m-d")."</span>";
        // echo $dt->format("Y-m-d");

        if ($dt->format("d") == 01) {
            // echo $dt->format("M");
              echo "<div id='month'>".$dt->format("F")."</div>";
        }

        if ($dt->format("Y-m-d") == $today) {
            echo "<div id='todayline'></div>";
        }


        echo "</div>";
        
//        echo "select timeline.id, `width`, `top`, days, start, end, layer, `left`, timeline.name, `project`, category.color from `timeline` LEFT JOIN category ON category.id = timeline.project where timeline.user = '$id_user' AND timeline.start BETWEEN '$qu_begin' AND '$qu_end'";
        // echo "</a>";
    } ?>

                <!--- timelines -->

                <?php
  $re = mysqli_query($mysqli, "select timeline.id, `width`, `top`, days, start, end, layer, `left`, timeline.name, `project`, category.color from `timeline`
LEFT JOIN category ON category.id = timeline.project
where timeline.user = '$id_user' AND timeline.start BETWEEN '$qu_begin' AND '$qu_end'");

    // mysql_set_charset("utf8");
    while ($cat = mysqli_fetch_object($re)) {
        $name = $cat->name;
//        $name = htmlentities($name);
        $name =  htmlspecialchars($name, ENT_QUOTES);
        $id = $cat->id;
        $width = $cat->width;
        $top = $cat->top;
        $left = $cat->left;
        $projectid = $cat->project;
        $color = $cat->color;
        $days = $cat->days;
        $start = $cat->start;
        $end = $cat->end;
        $layer = $cat->layer;

        echo "<div style='width:".$width."px; left:".$left."px; top:".$top."px; background-color:#".$color.";' id='".$id."' class='timeline draggable'>
        <input class='name' value='".$name."' placeholder='Name'/>
        <select class='project'>";

        $pro = mysqli_query($mysqli, "select text, id, color from category where user = '$id_user' and archive = 'false'");
        while ($pros = mysqli_fetch_object($pro)) {
            $id = $pros->id;
            $name = $pros->text;

            if ($projectid == $id) {
                echo "<option selected='selected' value='".$id."'>".$name."</option>";
            } else {
                echo "<option value='".$id."'>".$name."</option>";
            }
        }

        echo "
        </select>";



//         $pro = mysql_query("Select entry, todo.text, NOT ISNULL(todo.id) AS here from entry
// left join todo on STR_TO_DATE(entry.day, '%Y-%m-%d') =  STR_TO_DATE(todo.check_date, '%Y-%m-%d')
// where entry.user = '$id_user' and day between '$start' AND '$end'");
//         while ($pros = mysql_fetch_object($pro)) {
//             $id = $pros->id;
//             $name = $pros->name;
//
//             if ($projectid == $id) {
//                 echo "<option selected='selected' value='".$id."'>".$name."</option>";
//             } else {
//                 echo "<option value='".$id."'>".$name."</option>";
//             }
//         }
//
//
//
//                 $day_s = mysql_query("select entry.day FROM entry where user = '$id_user' and day BETWEEN '$start' AND '$end'
// ORDER BY entry.day ASC");
//                 while ($dayss = mysql_fetch_object($day_s)) {
//                     $day = $dayss->day;
//
//                     echo "<div class='day'>$day<br>";
//
//
//                     $todo = mysql_query("select todo.text, todo.user, check_date, todo.category, category.text
// from todo
// left join category on todo.category = category.id
// where todo.user = '$id_user'  AND category.text = 'Things' AND check_value = 'true' AND check_date = '$day'
// ORDER BY check_date ASC");
//                     while ($todos = mysql_fetch_object($todo)) {
//                       $to = $todos->text;
//
//                       echo "$to";
//
//                     }
//
//                     echo "</div>";
//                 }

$start = date("j. F", strtotime($start));
$end = date("j. F", strtotime($end));

        echo "
        <p style='color:#".$color.";' class='start'>$start</p>
        <p style='color:#".$color.";' class='width'>$days days</p>
        <p style='color:#".$color.";' class='end'>$end</p>
        <p style='color:#".$color."; display: none;' class='layer'>$layer</p>

        <p class='position'></p>
        <p class='date'></p>
        <div data-icon='q' class='icon timelinedelete'></div>
      </div>";

      // echo "<ul  class='todo $id' id='$name'>";
      // echo "<h1>$name</h1>";
      // echo "<div class='catoptions'><div data-icon='F' class='icon edit'></div><div data-icon='H' class='icon archive'></div></div>";
    } ?>



                    <!-- milestones -->

                    <?php
  $re = mysqli_query($mysqli, "select milestone.id, `width`, `top`, start, layer, `left`, milestone.name, `project`, category.color from `milestone`
LEFT JOIN category ON category.id = milestone.project
where milestone.user = '$id_user' AND milestone.start BETWEEN '$qu_begin' AND '$qu_end'");

    while ($cat = mysqli_fetch_object($re)) {
        $name = $cat->name;
        $name = htmlentities($name, ENT_QUOTES);
        $id = $cat->id;
        $width = $cat->width;
        $top = $cat->top;
        $left = $cat->left;
        $projectid = $cat->project;
        $color = $cat->color;
        //$days = $cat->days;
        $start = $cat->start;
        //$end = $cat->end;
        $layer = $cat->layer;

        echo "<div style='left:".$left."px; top:".$top."px;' id='".$id."' class='milestone draggable'>
        
        <div class='dot' style='background-color:#".$color.";' ></div>
        
        <div class='milestone-text'>
        
        <input style='color:#".$color.";' class='name' value='".$name."' placeholder='Name'/>
        
        
        <select class='project' style='
color:#".$color.";' class='project'>";
        
        echo "<div class='text' style='color:#".$color.";'>";

        $pro = mysqli_query($mysqli, "select text, id, color from category where user = '$id_user' and archive = 'false'");
        while ($pros = mysqli_fetch_object($pro)) {
            $id = $pros->id;
            $name = $pros->text;

            if ($projectid == $id) {
                echo "<option selected='selected' value='".$id."'>".$name."</option>";
            } else {
                echo "<option value='".$id."'>".$name."</option>";
            }
        }

        echo "
        </select>";


$start = date("j. F", strtotime($start));

        echo "
        
        <p style='color:#".$color.";' class='date'>$start</p>
        </div>
        
   		<p style='color:#".$color.";' class='start'>$start</p>
		<p style='opacity: 0;' class='layer'>$layer</p>
        
        
        <div style='color:#".$color.";' data-icon='q' class='icon milestonedelete'></div>
      </div>
      ";

    } ?>






                        <!-- timeline prepared events -->

                        <?php
for ($i = 1; $i <= 10; $i++) {
    
    
    echo "<div class='timeline new'>
                            <input class='name' value='Timeline' placeholder='...' />
                            <select class='project'>";
                        

$pro = mysqli_query($mysqli, "select text, id, color from category where user = '$id_user' and archive = 'false'");
    while ($pros = mysqli_fetch_object($pro)) {
        $id = $pros->id;
        $name = $pros->text;


        echo "<option value='".$id."'>".$name."</option>";
    } 
    
    
    echo "</select>
                            <p class='start'></p>
                            <p class='width'></p>
                            <p class='end'></p>
                            <p class='layer'></p>
                            <div data-icon='q' class='icon timelinedelete'></div>
                        </div>";               
}
    
?>



                            <!--milestone prepared events-->

                            <?php
for ($i = 1; $i <= 10; $i++) {
    
    
    echo "<div style='absolute' class='milestone new'>
        
        <div class='dot' style='background-color:black;'></div>
        
        <div class='milestone-text'>
        
        <input style='color: black;' class='name' value='Milestone' placeholder='Milestone'>
        
        <select style='color: black;' class='project'>";
    
    
    $pro = mysqli_query($mysqli, "select text, id, color from category where user = '$id_user' and archive = 'false'");
        while ($pros = mysqli_fetch_object($pro)) {
            $id = $pros->id;
            $name = $pros->text;


        echo "<option value='".$id."'>".$name."</option>";
    }
    
    echo "</select>
        
        
        <p style='color: back' class='date'>Date</p>
        </div>
        
   		<p style='color:black;' class='start'></p>
		<p style='opacity: 0;' class='layer'>0</p>
        
        
        <div style='color: black;' data-icon='q' class='icon milestonedelete'></div>
      </div>";
    
    
}
    
?>


                                <!--
<div style="absolute" class="milestone new">
        
        <div class="dot" style="background-color:black;"></div>
        
        <div class="milestone-text">
        
        <input style="color: black;" class="name" value="Milestone" placeholder="Milestone">
        
        <select style="color: black;" class='project'>
<?php
$pro = mysqli_query($mysqli, "select text, id, color from category where user = '$id_user' and archive = 'false'");
    while ($pros = mysqli_fetch_object($pro)) {
        $id = $pros->id;
        $name = $pros->text;


        echo "<option value='".$id."'>".$name."</option>";
    } ?>
</select>
        
        
        <p style="color: back" class="date">Date</p>
        </div>
        
   		<p style="color:black;" class="start"></p>
		<p style="opacity: 0;" class="layer">0</p>
        
        
        <div style="color: black;" data-icon="q" class="icon milestonedelete"></div>
      </div>
-->



                                <div class="horizontal snap none"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>
                                <div class="horizontal snap"></div>



        </div>






        <!-- scripts -->
        <script src="inc/js/pickadate.js"></script>
        <script src="inc/js/timeline.js"></script>
        <script src="inc/js/moment.js"></script>




    </body>

</html>

<?php

} else {
    header('Location: http://'.$host.'/login.php');
}

?>
