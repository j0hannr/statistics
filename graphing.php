<?php

require "config.php";
$time = date('Y-m-d H:i:s', time());
$timestamp = date('Y-m-d H:i:s', time());
session_start();
$id_user = $_SESSION['id'];

if (empty($id_user)) {
	echo "notlogged";
	exit;
}

$action = $_REQUEST['action'];


$month = "MONTH";
$year = "YEAR";



$todo = mysql_query("# mysql queries for graphing
   
# count todos finished   
SELECT IFNULL(count(text),0) as Todo FROM todo
WHERE ".$month."(check_date) = ".$month."(CURDATE()) 
	AND year(check_date) = year(CURDATE())
	AND user = '1'
	
UNION

	
# count days created in month	
select IFNULL(count(day),0) from entry
WHERE ".$month."(day) = ".$month."(CURDATE()) 
	AND year(day) = year(CURDATE())
	AND user = '1'
	
	
UNION
	
# count words written	
#SELECT IFNULL(SUM( LENGTH( story ) -  LENGTH( REPLACE( story, ' ', '' ) ) +1 ),0)
#FROM entry
#WHERE ".$month."(day) = ".$month."(CURDATE()) 
#	AND year(day) = year(CURDATE())
#	AND user = '1'
	
#UNION
	
# count run
select IFNULL(sum(field.value),0) from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='1'
WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'
	
UNION

# count bike
select IFNULL(sum(field.value),0) from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='2'
WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'
	
UNION
	
# count walk
select IFNULL(sum(field.value),0) from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='10'
WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'
	
UNION
	
# count hours worked
select IFNULL(hour(SEC_TO_TIME( SUM( TIME_TO_SEC( `duration` ) ) )),0) AS timeSum from work
WHERE ".$month."(date) = ".$month."(CURDATE()) 
	AND year(date) = year(CURDATE())
	AND user = '1'
	
	");

$columnValues = Array();

while ( $row = mysql_fetch_assoc($todo) ) {
  $columnValues[] = $row['Todo'];   
}

$prev = mysql_query("# mysql queries for graphing
   
# count todos finished   
SELECT IFNULL(count(text),0) as Todo FROM todo
WHERE ".$month."(check_date) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
	AND year(check_date) = year(CURDATE())
	AND user = '1'
	
UNION

	
# count days created in month	
select IFNULL(count(day),0) from entry
WHERE ".$month."(day) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
	AND year(day) = year(CURDATE())
	AND user = '1'
	
	
UNION
	
# count words written	
#SELECT IFNULL(SUM( LENGTH( story ) -  LENGTH( REPLACE( story, ' ', '' ) ) +1 ),0)
#FROM entry
#WHERE ".$month."(day) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
#	AND year(day) = year(CURDATE())
#	AND user = '1'
	
#UNION
	
# count run
select IFNULL(sum(field.value),0) from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='1'
WHERE ".$month."(entry.day) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'
	
UNION

# count bike
select IFNULL(sum(field.value),0) from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='2'
WHERE ".$month."(entry.day) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'
	
UNION
	
# count walk
select IFNULL(sum(field.value),0) from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='10'
WHERE ".$month."(entry.day) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'
	
UNION
	
# count hours worked
select IFNULL(hour(SEC_TO_TIME( SUM( TIME_TO_SEC( `duration` ) ) )),0) AS timeSum from work
WHERE ".$month."(date) = ".$month."(CURDATE()- INTERVAL 1 ".$month.") 
	AND year(date) = year(CURDATE())
	AND user = '1'
	
	");

$prev_a = Array();

while ( $row = mysql_fetch_assoc($prev) ) {
  $prev_a[] = $row['Todo'];    
}

$arr = array('Todos', 'Days', 'Run' , 'Bike', 'Walk', 'Work');

$places = mysql_query("Select location.name as Location, count(*) as Num from entry
left join location on entry.location = location.id

WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'

Group by entry.location
order by count(*) DESC");

$Location = Array();

while ( $row = mysql_fetch_assoc($places) ) {
    $Location[] = utf8_encode($row['Location']);
}

$places_dur = mysql_query("Select count(*) as Num from entry
left join location on entry.location = location.id

WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'

Group by entry.location
order by Num DESC");

$Location_dur = Array();

while ( $row = mysql_fetch_assoc($places_dur) ) {
  $Location_dur[] = $row['Num'];   
}

$run = mysql_query("select IFNULL(field.value, 0) as daily from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='1'

WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'

Order by entry.day ASC");

$run_dur = Array();

while ( $row = mysql_fetch_assoc($run) ) {
  $run_dur[] = $row['daily'];   
}

$bike = mysql_query("select IFNULL(field.value, 0) as daily from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='2'

WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'

Order by entry.day ASC");

$bike_dur = Array();

while ( $row = mysql_fetch_assoc($bike) ) {
  $bike_dur[] = $row['daily'];    
}

$walk = mysql_query("select IFNULL(field.value, 0) as daily from entry 
LEFT JOIN field ON entry.entry = field.entry AND field.field='10'

WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'

Order by entry.day ASC");

$walk_dur = Array();

while ( $row = mysql_fetch_assoc($walk) ) {
  $walk_dur[] = $row['daily'];    
}

$temp = mysql_query("select tempMax as daily from entry 
RIGHT JOIN location_day ON entry.entry = location_day.entry

WHERE ".$month."(entry.day) = ".$month."(CURDATE()) 
	AND year(entry.day) = year(CURDATE())
	AND entry.user = '1'

Order by entry.day ASC");

$temp_dur = Array();

while ( $row = mysql_fetch_assoc($temp) ) {
  $temp_dur[] = $row['daily'];    
}

$d=cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y"));
$dates = Array();
$i = 1;
while ($i <= $d ) {

  $dates[] = $i;
    $i++;
    
}

//    $test = array( 'bla' => 'äöü' );
//    $test['bla'] = htmlentities( $test['bla'] );
//    echo json_encode( $test );

    
        $graphing[] = json_decode($columnValues, true);
        $graphing[] = json_decode($prev_a, true);
        $graphing[] = json_decode($arr, true);
        $graphing[] = json_decode($Location, true);
        $graphing[] = json_decode($Location_dur, true);
        $graphing[] = json_decode($run_dur, true);
        $graphing[] = json_decode($bike_dur, true);
        $graphing[] = json_decode($walk_dur, true);
        $graphing[] = json_decode($temp_dur, true);
        $graphing[] = json_encode($dates, true);


$json_merge = json_encode($graphing);

$combine = array(
    'current'=>$columnValues,
    'previous'=>$prev_a,
    'ledgend_activity'=>$arr,
    'ledgend_location'=>$Location,
    'location_duration'=>$Location_dur,
    'month_run'=>$run_dur,
    'month_bike'=>$bike_dur,
    'month_walk'=>$walk_dur,
    'month_temp'=>$temp_dur,
    'ledgend_date'=>$dates
);


echo json_encode($combine);

//echo "hello";

?>