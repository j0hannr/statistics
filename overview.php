<?php 
session_start();
require_once 'config.php';
mysql_set_charset("utf8");
if ($_SESSION['login']==1){
$id_user = $_SESSION['id'];
//$id_user = 1;
//$today = date('Y-m-d', time());
?>

<!DOCTYPE html>
<html>
<head>
    <title>Overview</title>

	<script src="inc/js/jquery-1.9.1.js"></script>
	<script src="inc/js/overview.js"></script>

    <link rel="stylesheet" href="inc/css/overview.css" type="text/css" />
    
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

</head>

<body>
    
<!--header-->
<section id="header">
    
    <h1>- OVERVIEW -</h1>
    
</section>
    
<!--location    -->
<section id="location">
    <?php

    $result = mysql_query("SELECT location.name, COUNT(`location`) AS days FROM `entry` 
INNER JOIN `location` ON entry.location = location.id
WHERE location.user = '$id_user' AND MONTH(entry.day) = MONTH(CURRENT_DATE()) AND YEAR(entry.day) = YEAR(CURRENT_DATE())
GROUP BY `location` HAVING COUNT(*) > 0 ORDER BY days DESC");
	while($user = mysql_fetch_object($result))
	{
	    
            $name = $user->name;
	    $name = htmlentities($name);
            $days = $user->days;
	    
            echo "<div class='location' id='$name'>";
	    echo "<p class='name'>$name</p>";
	    echo "<p class='days'>$days</p>";
	    echo "</div>";
	    
        }
	echo "<p id='daysoverview'>";
	echo date("F");
	echo "</p>";
    ?>

</section>

<!--tag-->
<section id="tag">
    <?php
    $count = 0;
    $result = mysql_query("SELECT `name`, COUNT(`name`) AS NumOccurrences FROM `tags` 
INNER JOIN `entry` ON entry.entry = tags.entry
WHERE tags.user = '$id_user' AND MONTH(entry.day) = MONTH(CURRENT_DATE()) AND YEAR(entry.day) = YEAR(CURRENT_DATE())
GROUP BY `name` HAVING COUNT(*) > 0 ORDER BY NumOccurrences DESC");
	while($user = mysql_fetch_object($result))
	{
	    
            $name = $user->name;
	    $name = htmlentities($name);
	    
	    if ($count == 0) {
		echo "<p class='top'>";
	    }
	    elseif ($count > 0 && $count < 11) {
		echo "$name ";
	    }
	    
	    elseif ($count == 11) {
		echo "</p>";
	    }

	    elseif ($count == 12) {
		echo "<p class='bottom'>";
	    }
	    
	    elseif ($count > 12) {
		echo "$name ";
	    }
	    $count = $count + 1;
        }
	
	echo "</p>";
	
	$total = mysql_result(mysql_query("SELECT COUNT(*) AS total FROM tags 
WHERE user = '$id_user' AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())"),0);
	echo "<p id='totaltags'>$total TAGS</p>";
	
	
    ?>
</section>


<!--text-->
<section id="text">
    <?php
	$words = mysql_result(mysql_query("SELECT (SUM(LENGTH(story) - LENGTH(REPLACE(story, ' ', ''))+1)-DAY(CURRENT_DATE())) As words FROM entry 
WHERE user = '$id_user' AND MONTH(entry.day) = MONTH(CURRENT_DATE()) AND YEAR(entry.day) = YEAR(CURRENT_DATE())"),0);
	
	echo "<p id='word'>WORDS</p>";
	echo "<p id='number'>$words</p>";
    ?>
</section>

<!--fields-->
<section id="field">
    <?php
    $counter = 1;
    $result = mysql_query("SELECT name, SUM(value) As amount FROM field_settings
LEFT JOIN field ON field.field = field_settings.id 
INNER JOIN entry ON field.entry = entry.entry
WHERE entry.user = '1' AND MONTH(entry.day) = MONTH(CURRENT_DATE()) AND YEAR(entry.day) = YEAR(CURRENT_DATE())
GROUP BY field_settings.id;");
	while($user = mysql_fetch_object($result))
	{
	    $name = $user->name;
            $amount = $user->amount;
	    
	    echo "<div class='field";
	    if ($counter == 1) {
		echo " one'";
	    }
	    if ($counter == 2) {
		echo " two'";
	    }
	    if ($counter == 3) {
		echo " three'";
	    }
	    echo "id='$name'>";
	    echo "<p class='fieldname'>$name</p>";
	    echo "<p class='fieldamount'>$amount</p>";
	    
	    //field amount one month before - compare
	    $amount = mysql_result(mysql_query("SELECT SUM(value) As amount FROM field_settings
LEFT JOIN field ON field.field = field_settings.id 
INNER JOIN entry ON field.entry = entry.entry
WHERE entry.user = '$id_user' AND field_settings.name = '$name' AND DAY(entry.day) <= DAY(CURRENT_DATE()) AND MONTH(entry.day) = (MONTH(CURRENT_DATE())-1) AND YEAR(entry.day) = YEAR(CURRENT_DATE())
GROUP BY field_settings.id;"),0);
	    if (!$amount) $amount = 0;
	    echo "<p class='fieldamountbefore'>$amount</p>";
	    
	    echo "<p class='monthbefore'>";
	    echo date('F', strtotime('-1 month'));
	    echo "</p>";
	    
	    echo "</div>";
	    
	    
	    $counter = $counter + 1;
	    if ($counter == 4) {
		$counter = 1;
	    }
	    
	    
        }
    ?>
</section>

<!--footer-->
<section id='footer'>
    <?php
        $visits = mysql_result(mysql_query("SELECT COUNT(*) AS visits FROM session 
        WHERE user = '$id_user' AND site = '4'
	AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())"),0);
	
	$page = mysql_result(mysql_query("SELECT COUNT(*) AS visits FROM session 
	WHERE user = '$id_user' AND site = '6'
	AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())"),0);
	
	echo "<p id='visits'>$visits/$page VISITS</p>";
    ?>
</footer>

    
</body>
</html>

<?php

}
else{
header('Location: http://'.$host.'/login.php');
}

?>