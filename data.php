<?php
session_start();
require_once 'config.php';
mysqli_set_charset($mysqli, "utf8");

if ($_SESSION['login']==1) {

    $id_user = $_SESSION['id'];

    $id = $_GET['id'];
    $id = $mysqli->real_escape_string($id);

    $view = mysqli_query($mysqli, "select 
        `entry`.`user` AS `user`,
        `entry`.`entry` AS `entry`,
        `entry`.`day` AS `day`,
        `entry`.`milestone` AS `milestone`,
        `entry`.`story` AS `story`,
        `entry`.`quote` AS `quote`,
        `entry`.`location` AS `location`,
        `location_day`.`id` AS `location_id`,
        `location_day`.`status` AS `status`,
        `location_day`.`tempAvg` AS `tempAvg`,
        `location`.`name` AS `name`,
        `location`.`latitude` AS `latitude`,
        `location`.`longitude` AS `longitude`

        from entry 
        left join location_day on entry.entry = location_day.entry
        left join location on entry.location = location.id
        where entry.user = '$id_user' and entry.day='$id'
        order by entry asc limit 0,1" );
        

    $day = mysqli_fetch_array($view) or die(mysqli_error($mysqli));
    echo json_encode($day);

}
else {
    header('Location: http://'.$host.'/login.php');
}

?>
