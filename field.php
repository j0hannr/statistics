<?php
session_start();
require_once 'config.php';
mysqli_set_charset($mysqli, "utf8");
if ($_SESSION['login']==1){
//$mysql_timestamp = date('Y-m-d H:i:s', time());
//$feedtime = date('Y-m-d', time());
$id_user = $_SESSION['id'];

$id = $_GET['id'];
$id = $mysqli->real_escape_string($id);
//echo $id_user;
//echo $id;

$json = array();
			
$re = mysqli_query($mysqli, "SELECT field_settings.id, field.id AS fid, field_settings.name, field.value, unit.symbol FROM field_settings LEFT JOIN field ON field_settings.id = field.field AND field.entry='$id' JOIN unit ON field_settings.unit = unit.id  WHERE field_settings.user='$id_user' ");
while($row = mysqli_fetch_array($re))
{
				
    //if ($fid->value == '') { $val = '0'; } else { $val = $fid->value; }
    //if (empty($fid->value)) { $fid->value = '0'; }
				
    $bus = array (
	"id" => $row['id'],
	"fid" => $row['fid'],
	"name" => $row['name'],
	"value" => $row['value'],
	"symbol" => $row['symbol']
    );
    array_push($json, $bus);
}

//array_push($json, $day);

$jsonstring = json_encode($json);
echo $jsonstring;


}
else{
header('Location: http://'.$host.'/login.php');
}
?>
