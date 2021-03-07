<?php
session_start();
require_once 'config.php';
mysql_set_charset("utf8");
if ($_SESSION['login']==1){
//$mysql_timestamp = date('Y-m-d H:i:s', time());
//$feedtime = date('Y-m-d', time());
$id_user = $_SESSION['id'];

$id = $_GET['id'];
$id = mysql_real_escape_string($id);

//echo $id_user;
//echo $id;


//$view = mysql_query("SELECT * FROM dayview WHERE entry.user='$id_user' AND entry.day='$id'");
    
    
    $view = mysql_query("select 

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
order by entry asc limit 0,1");
    

//$array = mysql_fetch_row($view) or die(mysql_error());
$day = mysql_fetch_array($view) or die(mysql_error());
//echo $array;

echo json_encode($day);




}
else{
header('Location: http://'.$host.'/login.php');
}
?>
