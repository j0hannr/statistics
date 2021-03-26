<?php
session_start();
require "config.php";
$time = date('Y-m-d H:i:s', time());
$timestamp = date('Y-m-d H:i:s', time());
$id_user = $_SESSION['id'];

if (empty($id_user)) {
	echo "notlogged";
	exit;
}

$action = $_REQUEST['action'];

	switch($action)
	{
		//tags
		case "add":
			//$user = $_REQUEST['user'];
			$date = $_REQUEST['date'];
			$value = $_REQUEST['value'];
			//$user = $mysqli->real_escape_string($user);
			$date = $mysqli->real_escape_string($date);
			$value = $mysqli->real_escape_string($value);
			mysqli_set_charset($mysqli, "utf8");
			mysqli_query($mysqli,"INSERT INTO `tags` (`name`, `entry`, `timestamp`, `user`) VALUES ('$value','$date','$timestamp','$id_user')");
			$id = mysqli_insert_id($mysqli);
			if ($id == '0') { echo "error";} else {
			// echo "<span contenteditable='false' class='t tag id".$id."'>".$value."<img src='inc/img/delete_2.png' class='remove' id='delete'/></span>";
			echo "<span contenteditable='false' class='t tag id".$id."'>".$value."<div class='remove' id='delete'><div data-icon='q' class='icon'></div></div></span>";
			}

		break;

		case "delete":
			$id = $_REQUEST['id'];
			mysqli_query($mysqli,"DELETE FROM `tags` WHERE id=".$id);
			echo "DONE!";
		break;

		case "get":

			$day = $_REQUEST['day'];
            mysqli_set_charset($mysqli, "utf8");
			$re = mysqli_query($mysqli,"SELECT `name`,`id` FROM `tags` WHERE `entry` =".$day);
			while($tag = mysqli_fetch_object($re))
			{
			    $name = $tag->name;
			    $name = htmlentities($name, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
			    $id = $tag->id;
			    // echo "<span contenteditable='false' class='t tag id".$id."'>".$name."<img src='inc/img/delete_2.png' class='remove' id='delete'/></span>";
					echo "<span contenteditable='false' class='t tag id".$id."'>".$name."<div class='remove' id='delete'><div data-icon='q' class='icon'></div></div></span>";
			}

		break;
		//fields
		case "changevalue":

			$id = $_REQUEST['id'];
			$id = $mysqli->real_escape_string($id);
			$value = $_REQUEST['value'];
			$value = $mysqli->real_escape_string($value);
			$entry = $_REQUEST['entry'];
			$entry = $mysqli->real_escape_string($entry);

		$sql="UPDATE `field` SET value='$value', timestamp='$timestamp' WHERE id = '$id'";

		$result=mysqli_query($mysqli,$sql);
		mysqli_query($mysqli,$result);
		echo $value;
		echo "<br>";
		echo $id;

		break;

		case "addfield":

			$id = $_REQUEST['id'];
			$id = $mysqli->real_escape_string($id);
			$value = $_REQUEST['value'];
			$value = $mysqli->real_escape_string($value);
			$entry = $_REQUEST['entry'];
			$entry = $mysqli->real_escape_string($entry);

			mysqli_query($mysqli,"INSERT INTO `field` (`field`, `value`, `entry` ,`user`, `timestamp`) VALUES ('$id','$value','$entry','$id_user', '$timestamp')");
			$id = mysqli_insert_id($mysqli);
			echo $id;

		break;
		//change location
		case "changelocation":


			$id = $_REQUEST['id'];
			$id = $mysqli->real_escape_string($id);
			$entry = $_REQUEST['entry'];
			$entry = $mysqli->real_escape_string($entry);
			$date = $_REQUEST['date'];
			$date = $mysqli->real_escape_string($date);

			$sql="UPDATE `entry` SET location='$id' WHERE entry = '$entry'";

			$result=mysqli_query($mysqli,$sql);
			mysqli_query($mysqli,$result);
			//echo $value;


			//get weather...
			$result = mysqli_query($mysqli,"SELECT `latitude`,`longitude` FROM `location` WHERE `id`='$id' LIMIT 0,1");
			$row = mysql_fetch_row($result);

			$lat = $row[0];
			$lng = $row[1];

			//echo $lat;
			//echo "////";
			//echo $lng;

			$timestamps = strtotime($date);

			$response = file_get_contents("https://api.forecast.io/forecast/6eb4fa0c45ddd060b1fed610f3efc173/".$lat.",".$lng.",".$timestamps."");
			$json = json_decode($response);

			$summary = $json->daily->data[0]->summary;
			$status = $json->daily->data[0]->icon;
			$json->daily->data[0]->sunriseTime;
			$time=$json->daily->data[0]->sunriseTime;
			$rise = gmdate("H:i:s", $time);
			$json->daily->data[0]->sunsetTime;
			$time=$json->daily->data[0]->sunsetTime;
			$fall = gmdate("H:i:s", $time);
			$phase = $json->daily->data[0]->moonPhase;
			$fahr = $json->daily->data[0]->temperatureMin;
			$temperature = $fahr - 32;
			$temperatureMin = $temperature / 1.8;
			$tempMin = round($temperatureMin,2);
			$fahr = $json->daily->data[0]->temperatureMax;
			$temperature = $fahr - 32;
			$temperatureMax = $temperature / 1.8;
			$tempMax = round($temperatureMax,1);
			$temave = $temperatureMax + $temperatureMin;
			$temave = $temave / 2;
			$tempAvg = round($temave,1);
			$humidity = $json->daily->data[0]->humidity;
			$wind = $json->daily->data[0]->windSpeed;
			$speed = $wind * 1.609344;
			$speed = round($speed,1);
			$cloud = $json->daily->data[0]->cloudCover;
			$precip_type = $json->daily->data[0]->precipType;

			$tempMintime = $json->daily->data[0]->temperatureMinTime;
			$tempMaxtime = $json->daily->data[0]->temperatureMaxTime;
			$dewpoint = $json->daily->data[0]->dewPoint;
			$pressure = $json->daily->data[0]->pressure;
			$ozone = $json->daily->data[0]->ozone;
			$precip_chance = $json->daily->data[0]->precipProbability;
			$precip_amount = $json->daily->data[0]->precipIntensity;
			$precipMax = $json->daily->data[0]->precipIntensityMax;
			$precipMaxTime = $json->daily->data[0]->precipIntensityMaxTime;
            if (!$precipMaxTime) {
                $precipMaxTime = 0;
            }

			$timezone = $json->timezone;

			$zone = file_get_contents("http://api.timezonedb.com/v2/get-time-zone?key=ID4BUSN1BUBV&format=json&by=zone&zone=".$timezone."");
			$zone_2 = json_decode($zone);
			$gmt = $zone_2->gmtOffset;

//			$sqlocation="UPDATE `location_day` SET location='$id', text='$summary', status='$status', sunrise='$rise', sunset='$fall', moonphase='$phase', tempMin='$tempMin', tempMax='$tempMax', tempAvg='$tempAvg', humidity='$humidity', windspeed='$speed', cloudcover='$cloud', precip='$precip_type', dewpoint='$dewpoint', pressure='$pressure', ozone='$ozone', tempMintime='$tempMaxtime', tempMaxtime='$tempMaxtime', precip_chance='$precip_chance', precip_amount='$precip_amount', precipMax='$precipMax', precipMaxtime='$precipMaxTime', timezone='$timezone', GMT_offset='$gmt' WHERE entry = '$entry'";
            
            
            
            $sqlocation="INSERT INTO `location_day` (user, entry, location, timestamp, text, status, sunrise, sunset, moonphase, tempMin, tempMax, tempAvg, humidity, windspeed, cloudcover, precip, dewpoint, pressure, ozone, tempMintime, tempMaxtime, precipMax, precipMaxtime, timezone, GMT_offset)
VALUES 
   ('$id_user','$entry','$id','$timestamp', '$summary', '$status', '$rise', '$fall', '$phase', '$tempMin', '$tempMax', '$tempAvg', '$humidity', '$speed', '$cloud', '$precip_type', '$dewpoint', '$pressure', '$ozone', '$tempMintime', '$tempMaxtime', '$precipMax', '$precipMaxTime', '$timezone', '$gmt')
ON DUPLICATE KEY UPDATE location='$id', text='$summary', status='$status', sunrise='$rise', sunset='$fall', moonphase='$phase', tempMin='$tempMin', tempMax='$tempMax', tempAvg='$tempAvg', humidity='$humidity', windspeed='$speed', cloudcover='$cloud', precip='$precip_type', dewpoint='$dewpoint', pressure='$pressure', ozone='$ozone', tempMintime='$tempMaxtime', tempMaxtime='$tempMaxtime', precip_chance='$precip_chance', precip_amount='$precip_amount', precipMax='$precipMax', precipMaxtime='$precipMaxTime', timezone='$timezone', GMT_offset='$gmt'";
            
            
            
            
            
            
//            error_reporting(E_ALL); 
//            ini_set('display_errors', 'On');
            
            
            
            

			$res=mysqli_query($mysqli,$sqlocation);
			mysqli_query($mysqli,$res);
            
			echo $sqlocation;
//            echo "https://api.forecast.io/forecast/6eb4fa0c45ddd060b1fed610f3efc173/".$lat.",".$lng.",".$timestamps."";
            
            
//            echo "data: ".$temperature." ".$rise."";
//            echo $sqlocation;
//            echo $id;
            
//            echo "UPDATE `location_day` SET location='$id', text='$summary', status='$status', sunrise='$rise', sunset='$fall', moonphase='$phase', tempMin='$tempMin', tempMax='$tempMax', tempAvg='$tempAvg', humidity='$humidity', windspeed='$speed', cloudcover='$cloud', precip='$precip_type', dewpoint='$dewpoint', pressure='$pressure', ozone='$ozone', tempMintime='$tempMaxtime', tempMaxtime='$tempMaxtime', precip_chance='$precip_chance', precip_amount='$precip_amount', precipMax='$precipMax', precipMaxtime='$precipMaxTime', timezone='$timezone', GMT_offset='$gmt' WHERE entry = '$entry'";

		break;

		//update text
		case "updatetext":

			$kind = $_REQUEST['kind'];
			$kind = $mysqli->real_escape_string($kind);
			$entry = $_REQUEST['entry'];
			$entry = $mysqli->real_escape_string($entry);
			$text = $_REQUEST['text'];
			$text = $mysqli->real_escape_string($text);
			mysqli_set_charset($mysqli, "utf8");
			$sql="UPDATE `entry` SET $kind='$text' WHERE entry = '$entry'";
			$result=mysqli_query($mysqli,$sql);
			mysqli_query($mysqli,$result);
			echo $sql;
		break;
		//add date if there is none
		case "addday":

			$date = $_REQUEST['date'];
			$date = $mysqli->real_escape_string($date);
			$location = $_REQUEST['location'];
			$location = $mysqli->real_escape_string($location);
            
//            echo $date;
//            echo $location;

			//get weather...
			// $result = mysqli_query($mysqli,"SELECT `latitude`,`longitude` FROM `location` WHERE `id`='$location' LIMIT 0,1");
			// $row = mysql_fetch_row($result);

			// $lat = $row[0];
			// $lng = $row[1];

			$timestamps = strtotime($date);
            
//            echo $timestamps;

			// $response = file_get_contents("https://api.forecast.io/forecast/6eb4fa0c45ddd060b1fed610f3efc173/".$lat.",".$lng.",".$timestamps."");
			// $json = json_decode($response);
            

			// $summary = $json->daily->data[0]->summary;
			// $status = $json->daily->data[0]->icon;
			// $json->daily->data[0]->sunriseTime;
			// $time=$json->daily->data[0]->sunriseTime;
			// $rise = gmdate("H:i:s", $time);
			// $json->daily->data[0]->sunsetTime;
			// $time=$json->daily->data[0]->sunsetTime;
			// $fall = gmdate("H:i:s", $time);
			// $phase = $json->daily->data[0]->moonPhase;
			// $fahr = $json->daily->data[0]->temperatureMin;
			// $temperature = $fahr - 32;
			// $temperatureMin = $temperature / 1.8;
			// $tempMin = round($temperatureMin,2);
			// $fahr = $json->daily->data[0]->temperatureMax;
			// $temperature = $fahr - 32;
			// $temperatureMax = $temperature / 1.8;
			// $tempMax = round($temperatureMax,1);
			// $temave = $temperatureMax + $temperatureMin;
			// $temave = $temave / 2;
			// $tempAvg = round($temave,1);
			// $humidity = $json->daily->data[0]->humidity;
			// $wind = $json->daily->data[0]->windSpeed;
			// $speed = $wind * 1.609344;
			// $speed = round($speed,1);
			// $cloud = $json->daily->data[0]->cloudCover;
			// $precip_type = $json->daily->data[0]->precipType;

			// $tempMintime = $json->daily->data[0]->temperatureMinTime;
			// $tempMaxtime = $json->daily->data[0]->temperatureMaxTime;
			// $dewpoint = $json->daily->data[0]->dewPoint;
			// $pressure = $json->daily->data[0]->pressure;
			// $ozone = $json->daily->data[0]->ozone;
			// $precip_chance = $json->daily->data[0]->precipProbability;
			// $precip_amount = $json->daily->data[0]->precipIntensity;
			// $precipMax = $json->daily->data[0]->precipIntensityMax;
			// $precipMaxTime = $json->daily->data[0]->precipIntensityMaxTime;

			// $timezone = $json->timezone;

			// $zone = file_get_contents("http://api.timezonedb.com/v2/get-time-zone?key=ID4BUSN1BUBV&format=json&by=zone&zone=".$timezone."");
			// $zone_2 = json_decode($zone);
			// $gmt = $zone_2->gmtOffset;

			// $id_user = "1";
			// $date = "2021-03-08";
			
			# when location not given -> preselect
			if (!$Location) {
				$location = "1";
			}
			// $timestamps = strtotime($date);
			mysqli_query($mysqli,"INSERT INTO `entry` (`user`, `day`, `location`, `timestamp`, `milestone`, `story`, `quote`) VALUES ('$id_user','$date','$location','$timestamp', '', '', '')");
			$id = mysqli_insert_id($mysqli);
			echo $id;

			// echo 16774;

			// $stmt = $mysqli->prepare("INSERT INTO `entry` (`user`, `day`, `location`, `timestamp`, `milestone`, `story`, `quote`) VALUES ('$id_user','$date','$location','$timestamp', '', '', '')");
			// // $stmt->bind_param("si", $_POST['name'], $_SESSION['id']);
			// $stmt->execute();
			// echo $mysqli->insert_id;
			// $stmt->close();
			

			// $sql="INSERT INTO `location_day` (user, entry, location, timestamp, text, status, sunrise, sunset, moonphase, tempMin, tempMax, tempAvg, humidity, windspeed, cloudcover, precip, dewpoint, pressure, ozone, tempMintime, tempMaxtime, precipMax, precipMaxtime, timezone, GMT_offset) VALUES ('$id_user','$id','$location','$timestamp', '$summary', '$status', '$rise', '$fall', '$phase', '$tempMin', '$tempMax', '$tempAvg', '$humidity', '$speed', '$cloud', '$precip_type', '$dewpoint', '$pressure', '$ozone', '$tempMintime', '$tempMaxtime', '$precipMax', '$precipMaxTime', '$timezone', '$gmt')";

			// $result=mysqli_query($mysqli,$sql);
			// mysqli_query($mysqli,$result);

		break;

		//visitor tracker
		case "track":

			$width = $_REQUEST['width'];
			$width = $mysqli->real_escape_string($width);
			$height = $_REQUEST['height'];
			$height = $mysqli->real_escape_string($height);
			$site = $_REQUEST['site'];
			$site = $mysqli->real_escape_string($site);

			//get information!!!
			function getBrowser()
			{
			    $u_agent = $_SERVER['HTTP_USER_AGENT'];
			    $bname = 'Unknown';
			    $platform = 'Unknown';
			    $version= "";
			    //First get the platform?
			    if (preg_match('/linux/i', $u_agent)) {
			        $platform = 'linux';
			    }
			    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			        $platform = 'mac';
			    }
			    elseif (preg_match('/windows|win32/i', $u_agent)) {
			        $platform = 'windows';
			    }
			    // Next get the name of the useragent yes seperately and for good reason
			    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
			    {
			        $bname = 'Internet Explorer';
			        $ub = "MSIE";
			    }
			    elseif(preg_match('/Firefox/i',$u_agent))
			    {
			        $bname = 'Mozilla Firefox';
			        $ub = "Firefox";
			    }
			    elseif(preg_match('/Chrome/i',$u_agent))
			    {
			        $bname = 'Google Chrome';
			        $ub = "Chrome";
			    }
			    elseif(preg_match('/Safari/i',$u_agent))
			    {
			        $bname = 'Apple Safari';
			        $ub = "Safari";
			    }
			    elseif(preg_match('/Opera/i',$u_agent))
			    {
			        $bname = 'Opera';
			        $ub = "Opera";
			    }
			    elseif(preg_match('/Netscape/i',$u_agent))
			    {
			        $bname = 'Netscape';
			        $ub = "Netscape";
			    }
			    // finally get the correct version number
			    $known = array('Version', $ub, 'other');
			    $pattern = '#(?<browser>' . join('|', $known) .
			    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			    if (!preg_match_all($pattern, $u_agent, $matches)) {
			        // we have no matching number just continue
			    }
			    // see how many we have
			    $i = count($matches['browser']);
			    if ($i != 1) {
			        //we will have two since we are not using 'other' argument yet
			        //see if version is before or after the name
			        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			            $version= $matches['version'][0];
			        }
			        else {
			            $version= $matches['version'][1];
			        }
			    }
			    else {
			        $version= $matches['version'][0];
			    }
			    // check if we have a number
			    if ($version==null || $version=="") {$version="?";}
			    return array(
			        'userAgent' => $u_agent,
			        'name'      => $bname,
			        'version'   => $version,
			        'platform'  => $platform,
			        'pattern'    => $pattern
			    );
			}
			function get_ip_address(){
			    global $ip;
			    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
			        if (array_key_exists($key, $_SERVER) === true){
			            foreach (explode(',', $_SERVER[$key]) as $ip){
			                $ip = trim($ip); // just to be safe
			                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
			                    return $ip;
			                }
			            }
			        }
			    }
			}
			// now try it
			$ua=getBrowser();
			$yourbrowser=  $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
			$os = $ua['platform'];
			$name = $ua['name'];
			$version = $ua['version'];
			$text = $ua['userAgent'];
			$time = date('Y-m-d H:i:s', time());
			get_ip_address();
			$ipa = $ip;
			$response = file_get_contents("http://ipinfo.io/".$ip."/json");
			$json = json_decode($response);
			$ip = $json->ip;
			$city = $json->city;
			$region = $json->region;
			$land = $json->country;
			$loc = $json->loc;
			$org = $json->org;
			$postal = $json->postal;
			$postal = $mysqli->real_escape_string($postal);
			$city = $mysqli->real_escape_string($city);
			echo $ip;
			echo "//";
			echo $org;
			echo "//";
			echo $postal;
			$sql="INSERT INTO `session` SET ip='$ipa', site='$site', user='$id_user', os='$os', browser='$name', version='$version', description='$text', timestamp='$time', city='$city', region='$region', country='$land', location='$loc', postcode='$postal', provider='$org', width='$width', height='$height'";
			$result=mysqli_query($mysqli,$sql);
			mysqli_query($mysqli,$query);


		break;



		//todo
		case "true":
			mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
			mysqli_query($mysqli,"UPDATE todo SET check_value='false', check_date='$time' WHERE id=".$id);
			echo "<img class='check false' src='inc/img/false.png'/>";
		break;

		case "false":
			$id = $_REQUEST['id'];
			mysqli_query($mysqli,"UPDATE todo SET check_value='true', check_date='$time' WHERE id=".$id);
			echo "<img class='check true' src='inc/img/true.png'/>";
		break;

		case "edittodo":
			
			$id = $_REQUEST['id'];
			$text = $_REQUEST['text'];
			$text = $mysqli->real_escape_string($text);
			echo $text;
            mysqli_set_charset($mysqli, "utf8");
			$kind = $_REQUEST['kind'];
			mysqli_query($mysqli,"UPDATE $kind SET text='$text' WHERE id=".$id);
//          $text = htmlentities($text, ENT_QUOTES);
//			echo $text;
//            mysqli_set_charset($mysqli, "utf8");
			//echo $id;
			//echo $kind;
		break;


		case "archivecategory":
			mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
			$status = $_REQUEST['status'];
			$status = $mysqli->real_escape_string($status);
			//$text = $_REQUEST['text'];
			//$text = $mysqli->real_escape_string($text);
			mysqli_query($mysqli,"UPDATE category SET archive='$status' WHERE id=".$id);
			echo "UPDATE category SET archive='$status' WHERE id=".$id;
			//echo $text;
			//echo $id;
			//echo $kind;
		break;
            
        case "deletecategory":
			mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
//			$status = $_REQUEST['status'];
//			$status = $mysqli->real_escape_string($status);
			//$text = $_REQUEST['text'];
			//$text = $mysqli->real_escape_string($text);
			mysqli_query($mysqli,"Delete from category WHERE id=".$id);
//			echo "UPDATE category SET archive='$status' WHERE id=".$id;
			//echo $text;
			//echo $id;
			//echo $kind;
		break;

		case "changecategorycolor":
			mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
			$color = $_REQUEST['color'];
			$color = $mysqli->real_escape_string($color);
			//$text = $_REQUEST['text'];
			//$text = $mysqli->real_escape_string($text);
			mysqli_query($mysqli,"UPDATE category SET color='$color' WHERE id=".$id);
			echo "UPDATE category SET archive='$color' WHERE id=".$id;
			//echo $color;
			//echo $id;
			//echo $kind;
		break;

		case "addtodo":
			$id = $_REQUEST['id'];

			$position = mysqli_query($mysqli, "select max(position) from todo where category='$id'")->fetch_row()[0] ?? false;
			$position++;
			//$kind = $_REQUEST['kind'];
			// echo "INSERT INTO todo SET user='$id_user', category='$id', text='...' , timestamp='$timestamp'";
			mysqli_query($mysqli,"INSERT INTO todo SET user='$id_user', category='$id', text='...' , timestamp='$timestamp', position='$position'");
			$tid = mysqli_insert_id($mysqli);
			echo "<li class='todo' id='$tid'><div id='$tid' class='check'><img class='check false' src='inc/img/false.png'/></div><div id='$tid' class='text'>...</div><div class='options'><img class='edde edit' src='inc/img/edit.png'/><img class='edde delete' src='inc/img/delete.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";
		break;

		case "addtimeline":
			// $id = $_REQUEST['id'];
			$width = $_REQUEST['width'];
			$top = $_REQUEST['top'];
			$left = $_REQUEST['left'];
			//$kind = $_REQUEST['kind'];
			mysqli_query($mysqli,"INSERT INTO timeline SET user='$id_user' , `top`='$top' , `width`='$width' , `left`='$left', `name`='Timeline', `timestamp`='$time'");


			$tid = mysqli_insert_id($mysqli);
			// echo "<li class='todo' id='$tid'><div id='$tid' class='check'><img class='check false' src='inc/img/false.png'/></div><div id='$tid' class='text'>...</div><div class='options'><img class='edde edit' src='inc/img/edit.png'/><img class='edde delete' src='inc/img/delete.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";
			echo $tid;
		break;
		
		case "addmilestone":
			// $id = $_REQUEST['id'];
			$width = $_REQUEST['width'];
			$top = $_REQUEST['top'];
			$left = $_REQUEST['left'];
			//$kind = $_REQUEST['kind'];
			mysqli_query($mysqli,"INSERT INTO milestone SET user='$id_user' , `top`='$top' , `width`='$width' , `left`='$left', `name`='Timeline', `timestamp`='$time'");


			$tid = mysqli_insert_id($mysqli);
			// echo "<li class='todo' id='$tid'><div id='$tid' class='check'><img class='check false' src='inc/img/false.png'/></div><div id='$tid' class='text'>...</div><div class='options'><img class='edde edit' src='inc/img/edit.png'/><img class='edde delete' src='inc/img/delete.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";
			echo $tid;
		break;

		case "edittimeline":
			// mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
			$width = $_REQUEST['width'];
			$top = $_REQUEST['top'];
			$left = $_REQUEST['left'];

			$layer = $_REQUEST['layer'];
			$days = $_REQUEST['days'];
			$start = $_REQUEST['start'];
			$end = $_REQUEST['end'];

			$name = $_REQUEST['name'];
            $name = $mysqli->real_escape_string($name);
            
			$project = $_REQUEST['project'];

			mysqli_query($mysqli,"UPDATE timeline SET `top`='$top' , `width`='$width' , `left`='$left', `layer`='$layer', `days`='$days', `start`='$start', `end`='$end', `name`='$name', `project`='$project' WHERE id='$id' AND `user` = '$id_user'");
			// echo $text;
			//echo $id;
			//echo $kind;

			$color_result = mysqli_query($mysqli,"select color from category where user = '$id_user' and id = '$project'")->fetch_row()[0] ?? false;
			echo $color_result;

		break;
		
		case "edittmilestone":
			mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
			$width = $_REQUEST['width'];
			$top = $_REQUEST['top'];
			$left = $_REQUEST['left'];

			$layer = $_REQUEST['layer'];
			//$days = $_REQUEST['days'];
			$start = $_REQUEST['start'];
			//$end = $_REQUEST['end'];

			$name = $_REQUEST['name'];
            $name = $mysqli->real_escape_string($name);
            
			$project = $_REQUEST['project'];

			mysqli_query($mysqli,"UPDATE milestone SET `top`='$top' , `width`='$width' , `left`='$left', `layer`='$layer', `start`='$start', `name`='$name', `project`='$project' WHERE id='$id' AND `user` = '$id_user'");
			// echo $text;
			//echo $id;
			//echo $kind;

			$color_result = mysqli_query($mysqli,"select color from category where user = '$id_user' and id = '$project'")->fetch_row()[0] ?? false;
			echo $color_result;

		break;

		case "deletetimeline":
			$id = $_REQUEST['id'];
			mysqli_query($mysqli,"DELETE FROM timeline WHERE user='$id_user' AND id=".$id);
			echo "done";
		break;
		
		case "deletemilestone":
			$id = $_REQUEST['id'];
			mysqli_query($mysqli,"DELETE FROM milestone WHERE user='$id_user' AND id=".$id);
			echo "done";
		break;

		case "deletetodo":
			$id = $_REQUEST['id'];
			$kind = $_REQUEST['kind'];
			mysqli_query($mysqli,"DELETE FROM $kind WHERE id=".$id);
			echo "done";
		break;

		case "addcat":

			mysqli_query($mysqli,"INSERT INTO category SET user='$id_user', text='new' , timestamp='$time'");
			$tid = mysqli_insert_id($mysqli);
			// echo "<li class='category' id='$tid'><div id='$tid' class='text cattext'>...</div><div class='options'><img class='edde edit' src='inc/img/edit_cat.png'/><img class='edde delete' src='inc/img/delete_cat.png'/><img class='cencel writ' src='inc/img/cencel.png'/><img class='done writ' src='inc/img/done.png'/></div></li>";

			echo "<ul  class='todo $tid' id='new'>
			  <h1>new</h1>
			  <div class='catoptions'><div data-icon='F' class='icon edit'></div><div data-icon='H' class='icon archive'></div></div>
			  <li id='$tid' class='add todo'><span class='posmoile'>Add Todo</span></li>
			</ul>
			";


		break;

		case "getlocations":
            
//            echo "Hello World";

			$results = mysqli_query($mysqli,"SELECT * FROM location WHERE user='$id_user'");
			mysqli_set_charset($mysqli, "utf8");
			//Create a new DOMDocument object
			$dom = new DOMDocument("1.0");
			$node = $dom->createElement("markers"); //Create new element node
			$parnode = $dom->appendChild($node); //make the node show up
			//set document header to text/xml
//			header("Content-type: application/xml");
			// Iterate through the rows, adding XML nodes for each
			while($obj = mysqli_fetch_object($results))
			{
			  $name = $obj->name;
			  $name = htmlentities($name, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
			  $description = $obj->description;
			  $description = htmlentities($description, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
			  //$name = htmlentities($name, ENT_QUOTES | ENT_IGNORE, "UTF-8");
                
              $description =  htmlspecialchars($description);

			  $node = $dom->createElement("marker");
			  $newnode = $parnode->appendChild($node);
			  $newnode->setAttribute("name", $name);
			  $newnode->setAttribute("id", $obj->id);
			  $newnode->setAttribute("address", $description);
			  $newnode->setAttribute("lat", $obj->latitude);
			  $newnode->setAttribute("lng", $obj->longitude);
			  $newnode->setAttribute("type", $obj->type);
			  //$newnode->setAttribute("type", $obj->type);
			}
			echo $dom->saveXML();
            
		break;

		case "deletelocation";

			mysqli_set_charset($mysqli, "utf8");
			// get marker position and split it for database
			$mLatLang	= explode(',',$_POST["latlang"]);
			$mLat 		= filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
			$mLng 		= filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);

			mysqli_query($mysqli,"DELETE FROM location where latitude='$mLat' AND longitude='$mLng' AND user='$id_user'");
			//echo "DELETE FROM location where latitude='$mLat' AND longitude='$mLng' AND user='$id_user'";
			exit("Done!");

		break;

		case "addlocation";

			mysqli_set_charset($mysqli, "utf8");
			// get marker position and split it for database
			$mLatLang	= explode(',',$_POST["latlang"]);
			$mLat 		= filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
			$mLng 		= filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);
			$mName 		= filter_var($_POST["name"], FILTER_SANITIZE_STRING);
			$description	= filter_var($_POST["description"], FILTER_SANITIZE_STRING);
			$mType		= filter_var($_POST["type"], FILTER_SANITIZE_STRING);

			mysqli_query($mysqli,"INSERT INTO location (name, description, latitude, longitude, timestamp, user, type) VALUES ('$mName','$description',$mLat, $mLng, '$timestamp', '$id_user', '$mType')");
			$id = mysqli_insert_id($mysqli);
			//$output = '<h1 class="marker-heading">'.$mName.'</h1><p>'.$mAddress.'</p>';

			$output = '<div class="mapwin id'.$id.'"><input class="pinname" placeholder="Name..." value="'.$mName.'"/><textarea class="pintext" placeholder="description...">'.$description.'</textarea><select class="pinselect"><option value="1">City/Town</option><option value="2">House</option><option value="3">Hotel</option><option value="4">Restaurant</option><option value="5">Public Place</option><option value="6">Bar</option></select><button class="pinsave">SAVE</button><button class="pindelete">DELETE</button></div>';

			exit($output);

		break;


		case "savelocation":

			mysqli_set_charset($mysqli, "utf8");
			$id = $_REQUEST['id'];
			$id = $mysqli->real_escape_string($id);
			$name = $_REQUEST['name'];
			$name = $mysqli->real_escape_string($name);
			$description = $_REQUEST['description'];
			$description = $mysqli->real_escape_string($description);
			$type = $_REQUEST['type'];
			$type = $mysqli->real_escape_string($type);

			//$name = htmlentities($name, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
			//$description = htmlentities($description, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');

			mysqli_query($mysqli,"UPDATE location SET name='$name', description='$description', type='$type' WHERE user='$id_user' AND id='$id'");

			echo "done";


		break;


		case "daily_graph":

//            echo "hello World";
			$date = $_REQUEST['date'];
			$width = $_REQUEST['width'];
			$mobile = $_REQUEST['mobile'];
			$mobile = $mysqli->real_escape_string($mobile);
			$date = $mysqli->real_escape_string($date);
			// $width = $mysqli->real_escape_string($width);
			// $width = 1339:
			$x = 5;
			mysqli_set_charset($mysqli, "utf8");

			if ($mobile == 'true') {

				$width_stroke = 1;

				$space = ($width - 144) / 144;
				//$width_stroke = '1';
				if ($space ==  4) {

					$width_stroke = 3;
					$space = 3;

					//$width_stroke = $space / 2;
					//$space = $space / 2;

				}

			}
			else {
				$space = '6';

			}

			$left = 0;

			$result = mysqli_query($mysqli,"

			Select `activitylevel`, `time`, kind, id, @n := @n + 1 counter
			FROM (select @n:=0) initvars, daily_activity
			WHERE user = '$id_user' AND Day = '$date'
			ORDER BY id ASC

			");

			// check if data is returned
//            echo $date;
			// if not use new version
			if (mysqli_fetch_object($result)==0) {

				// echo "NO activity level data<br>";

				$result = mysqli_query($mysqli,"

				select sleep.start as wakeup, sleep.end as sleep, entry.entry, sunrise, sunset, GMT_offset from `entry`
				join location_day on entry.entry = location_day.entry
				left join sleep on entry.day = sleep.date
				where entry.day = '$date' and entry.user = '$id_user'

				");

				$data = mysqli_fetch_object($result);

				// get data from the next day (sleep):
				$date_n = strtotime("+1 day", strtotime($date));
				$date_n = date("Y-m-d", $date_n);
				// echo $date_n;

				$results = mysqli_query($mysqli,"

				select sleep.start as wakeup, sleep.end as sleep, entry.entry, sunrise, sunset from `entry`
				join location_day on entry.entry = location_day.entry
				left join sleep on entry.day = sleep.date
				where entry.day = '$date_n' and entry.user = '$id_user'

				");

				$nextday = mysqli_fetch_object($results);

				$sleep_n = $nextday->wakeup;
				// echo "next day sleep time: ";
				// echo $sleep_n;
				// echo " - ";

				$sleep_n = date('h:i:s', $sleep_n);

				// echo $sleep_n;
				// echo " - ";

				sscanf($sleep_n, "%d:%d:%d", $hours, $minutes, $seconds);
				// $sleep_n =  $hours * 60 + $minutes;
				$sleep_n =  ($hours * 60 + $minutes)*($width/1440);

				// echo $sleep_n;
				// echo "<br>";


				// other shit
				$sunrise = $data->sunrise;
				$offset = $data->GMT_offset;

				//echo $sunrise;
				//echo "<br>";

				// 21600


				if ($offset) {
					$sunrise = date('H:i:s',strtotime($offset.'seconds',strtotime($sunrise)));
				}



				// echo $sunrise;


				sscanf($sunrise, "%d:%d:%d", $hours, $minutes, $seconds);
				// $sunrise_min =  ($hours * 60 + $minutes)*0.6;
				$sunrise_min =  ($hours * 60 + $minutes)*($width/1440);

				// echo "SHOW VARIABLES: ";
				// echo $sunrise;
				// echo " - ";
				// echo $sunrise_min;
				// echo " <br> ";

				// echo "<br>";
				// echo "<br>";

				$sunset = $data->sunset;

				// echo $sunset;
				// echo "<br>";
				if ($offset) {
					$sunset = date('H:i:s',strtotime($offset.'seconds',strtotime($sunset)));
				}

				// echo $sunset;

				sscanf($sunset, "%d:%d:%d", $hours, $minutes, $seconds);
				// $sunset_min =  ($hours * 60 + $minutes)*0.6;
				$sunset_min =  ($hours * 60 + $minutes)*($width/1440);


				// sleep data
				$wakeup = $data->sleep;


				if (!$wakeup) {
					$wakeup = "00:00";
				}
				else {
					$wakeup = date('H:i:s', $wakeup);
				}

				//$wakeup = date('H:i:s', $wakeup);
				sscanf($wakeup, "%d:%d:%d", $hours, $minutes, $seconds);
				$wakeup_min =  ($hours * 60 + $minutes)*($width/1440);
				// $wakeup_min =  ($hours * 60 + $minutes)*0.6;
				//echo $wakeup_min;

				$sleep = $data->wakeup;


				// $sleep1 = $sleep;
				$sleep_date = date("Y-m-d", $sleep);

				if (!$sleep) {
					$sleep = "00:00";
				}
				else {
					$sleep = date('H:i:s', $sleep);
				}
				$res = "";

				//echo $sleep;

				// if (date('H:i:s', $sleep) )
				sscanf($sleep, "%d:%d:%d", $hours, $minutes, $seconds);
				$sleep_min =  ($hours * 60 + $minutes)*($width/1440);

				//echo $sleep_min;
				//echo $wakeup_min;
				// $sleep_min =  $hours * 60 + $minutes;
				// //if ($sleep_min < '1000')  $sleep_min = '1440';
				// $sleep_min = $sleep_min*0.6;

				// if sleep started the day before i.e. 23:20
				if ($sleep_date < $date) {
					$res = "set to zero";
					$sleep_min = 0;
				}


				// sec * 0,6 to map on field (and hours * 60)

				// <div style='position: absolute; height: 30px; width: ".$width_2."px; left: ".$wakeup_min."px; background-color: gray; top:150px;' id='sleep'></div>

				// echo "
				// Sunrise: $sunrise - $sunrise_min<br>
				// Sunset: $sunset - $sunset_min<br>
				// Wakeup: $wakeup- $wakeup_min<br>
				// Sleep: $sleep - $sleep_min<br>$sleep_date<br>$date<br>$res";

				$width_1 = $sunset_min - $sunrise_min;
				$width_2 = $wakeup_min - $sleep_min;

				// $width_3 = $width * 0.93;

				echo "

				<div style='position: absolute; height: 3px; width: ".$width."px; left: 0px; background-color: #e2e2e2; opacity: 1; top: 217px;' id='line'></div>

				<div style='position: absolute; height: 40px; width: ".$width_1."px; left: ".$sunrise_min."px; background-color: #fcf533; opacity: 1; top: 200px;' id='sun'></div>

				<div style='position: absolute; left: ".$sleep_min."px; height: 40px; width: ".$width_2."px; background-color: #82e7fc; top:200px; opacity: 0.8;' id='sleep'><span style='color: white;'></span></div>

				";

				if ($sleep_n > 500){
					// echo "<div style='position: absolute; left: ".$sleep_n."px; height: 40px; width: 200px; background-color: #82e7fc; top:200px; opacity: 0.8;' id='sleep'><span style='color: white;'></span></div>";
				}

				// echo $width;


				$resultss = mysqli_query($mysqli,"

				select work.project, task, start, duration, project.color from work
				LEFT JOIN project ON project.name = work.project
				where work.user = '$id_user' and date = '$date'

				");

				while($data = mysqli_fetch_object($resultss))
				{


					// // convert
					// $start = $data->start;
					// //$start = date('h:i:s', $start);
					// sscanf($start, "%d:%d:%d", $hours, $minutes, $seconds);
					// $start_calc =  ($hours * 60 + $minutes)*0.6;
          //
					// $duration = $data->duration;
					// sscanf($duration, "%d:%d:%d", $hours, $minutes, $seconds);
					// $duration_calc =  ($hours * 60 + $minutes)*0.6;


					// convert
					$start = $data->start;
					//$start = date('h:i:s', $start);
					sscanf($start, "%d:%d:%d", $hours, $minutes, $seconds);
					$start_calc =  ($hours * 60 + $minutes)*($width/1440);


					$duration = $data->duration;
					sscanf($duration, "%d:%d:%d", $hours, $minutes, $seconds);
					$duration_calc =  ($hours * 60 + $minutes)*($width/1440);

					// task and project
					$task = $data->task;
					$color = $data->color;
					if (!$color) {
						$color = "eb58c7";
					}
					$project = $data->project;

					// display

					// echo "<div class='work' style='position: absolute; left: ".$start_calc."px; height: 20px; width: ".$duration_calc."px; background-color: #eb58c7; top:150px;' id=''><p style='color: #eb58c7;font-size: 11px;font-weight: bold;position: relative;top: 15px;background-color: white;'>$project</p></div>";
					echo "<div class='work' style='left: ".$start_calc."px; width: ".$duration_calc."px; background-color: #".$color.";' ><p style='color: #".$color.";' class='name'>$project</p><p style='color: #".$color.";' class='task'></p></div>";

				}


			}

			else {


			// very new version START


			// get data!
			// current day sleep (start/stop) calc duration
			// next day sleep (start/stop)
			// current day sunrise/sunset
			//
			// map all times,timestamps and duration
			//
			// get in while loop:
			// 	task name
			// 	project name
			// 	start time
			// 	duration
			// 	set color (even and odd)

			// output all in divs (postition and length)



			// maybe the whole should be in percentage to match window width!??





			// very new version END

			// old version (self build activity tracker)
			while($data = mysqli_fetch_object($result))
			{
				$level = $data->activitylevel;
				$o_level = $level;
				$kind = $data->kind;
				$counter = $data->counter;
				$time = $data->time;

				if ($mobile == 'true') {

					$left = $left + ($space * 2);

					//$level = $level * 2;

				}
				else {

					$left = $counter;
					$left = $left * 6;

					$width_stroke = '2';

				}



				if ($kind == '1') {
					$color = 'rgb(255,13,13)';
				}
				else if ($kind == '2') {
					$color = 'rgb(41,236,221)';
				}
				else if ($kind == '3') {
					$color = 'rgb(21,115,206)';
					$level = $level / 2.5;
				}
				else if ($kind == '4') {
					$color = 'rgb(41,236,221)';
				}
				else if ($kind == '5') {
					$color = 'rgb(255,246,108)';
				}



			echo "<div id='stroke' class='hourstroke'
			style='background-color: ".$color."; height:
			".$level."px; width: ".$width_stroke."px; left:
			".$left."px;'><p class='activityp'>".$o_level." - ".$kind." - ".$time."</div>";


			}

			}

		break;
            
            
            
        case "graphing":
            
            /* 
            
            variables to be declared:
            - user
            - timeframe
                month or year
                custom 
                all time (years)
            
            idea: 
            - write stats as well
                iterate through activites with jquery
            
            
            */
                
            
            
            $todo = mysqli_query($mysqli,"# mysql queries for graphing
   
            # count todos finished   
            SELECT count(text) as Todo FROM todo
            WHERE MONTH(check_date) = MONTH(CURDATE()) 
                AND year(check_date) = year(CURDATE())
                AND user = '1'

            UNION


            # count days created in month	
            select count(day) from entry
            WHERE MONTH(day) = MONTH(CURDATE()) 
                AND year(day) = year(CURDATE())
                AND user = '1'


            UNION

            # count words written	
            SELECT SUM( LENGTH( story ) -  LENGTH( REPLACE( story, ' ', '' ) ) +1 )
            FROM entry
            WHERE MONTH(day) = MONTH(CURDATE()) 
                AND year(day) = year(CURDATE())
                AND user = '1'

            UNION

            # count run
            select IFNULL(sum(field.value),0) from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='1'
            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            UNION

            # count bike
            select sum(field.value) from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='2'
            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            UNION

            # count walk
            select IFNULL(sum(field.value),0) from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='10'
            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            UNION

            # count hours worked
            select hour(SEC_TO_TIME( SUM( TIME_TO_SEC( `duration` ) ) )) AS timeSum from work
            WHERE MONTH(date) = MONTH(CURDATE()) 
                AND year(date) = year(CURDATE())
                AND user = '1'

                ");

            $columnValues = Array();

            while ( $row = mysql_fetch_assoc($todo) ) {
              $columnValues[] = $row['Todo'];   
            }

            $prev = mysqli_query($mysqli,"# mysql queries for graphing

            # count todos finished   
            SELECT count(text) as Todo FROM todo
            WHERE MONTH(check_date) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(check_date) = year(CURDATE())
                AND user = '1'

            UNION


            # count days created in month	
            select count(day) from entry
            WHERE MONTH(day) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(day) = year(CURDATE())
                AND user = '1'


            UNION

            # count words written	
            SELECT SUM( LENGTH( story ) -  LENGTH( REPLACE( story, ' ', '' ) ) +1 )
            FROM entry
            WHERE MONTH(day) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(day) = year(CURDATE())
                AND user = '1'

            UNION

            # count run
            select sum(field.value) from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='1'
            WHERE MONTH(entry.day) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            UNION

            # count bike
            select sum(field.value) from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='2'
            WHERE MONTH(entry.day) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            UNION

            # count walk
            select IFNULL(sum(field.value),0) from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='10'
            WHERE MONTH(entry.day) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            UNION

            # count hours worked
            select hour(SEC_TO_TIME( SUM( TIME_TO_SEC( `duration` ) ) )) AS timeSum from work
            WHERE MONTH(date) = MONTH(CURDATE()- INTERVAL 1 MONTH) 
                AND year(date) = year(CURDATE())
                AND user = '1'

                ");

            $prev_a = Array();

            while ( $row = mysql_fetch_assoc($prev) ) {
              $prev_a[] = $row['Todo'];    
            }

            $arr = array('Todos', 'Days', 'Words' , 'Run' , 'Bike', 'Walk', 'Work');

            $places = mysqli_query($mysqli,"Select location.name as Location, count(*) as Num from entry
            left join location on entry.location = location.id

            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            Group by entry.location
            order by count(*) DESC");

            $Location = Array();

            while ( $row = mysql_fetch_assoc($places) ) {
                $Location[] = utf8_encode($row['Location']);
            }

            $places_dur = mysqli_query($mysqli,"Select count(*) as Num from entry
            left join location on entry.location = location.id

            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            Group by entry.location
            order by Num DESC");

            $Location_dur = Array();

            while ( $row = mysql_fetch_assoc($places_dur) ) {
              $Location_dur[] = $row['Num'];   
            }

            $run = mysqli_query($mysqli,"select IFNULL(field.value, 0) as daily from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='1'

            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            Order by entry.day ASC");

            $run_dur = Array();

            while ( $row = mysql_fetch_assoc($run) ) {
              $run_dur[] = $row['daily'];   
            }

            $bike = mysqli_query($mysqli,"select IFNULL(field.value, 0) as daily from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='2'

            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            Order by entry.day ASC");

            $bike_dur = Array();

            while ( $row = mysql_fetch_assoc($bike) ) {
              $bike_dur[] = $row['daily'];    
            }

            $walk = mysqli_query($mysqli,"select IFNULL(field.value, 0) as daily from entry 
            LEFT JOIN field ON entry.entry = field.entry AND field.field='10'

            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
                AND year(entry.day) = year(CURDATE())
                AND entry.user = '1'

            Order by entry.day ASC");

            $walk_dur = Array();

            while ( $row = mysql_fetch_assoc($walk) ) {
              $walk_dur[] = $row['daily'];    
            }

            $temp = mysqli_query($mysqli,"select tempMax as daily from entry 
            RIGHT JOIN location_day ON entry.entry = location_day.entry

            WHERE MONTH(entry.day) = MONTH(CURDATE()) 
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
            
            
        break;
            
            
            
            
            
            
//            summary page query -------------------------------------------------
            
            
            
        case "summary":

			mysqli_set_charset($mysqli, "utf8");
			$start = $_REQUEST['start'];
			$start = $mysqli->real_escape_string($start);
			$end = $_REQUEST['end'];
			$end = $mysqli->real_escape_string($end);
            $prevstart = $_REQUEST['prevstart'];
			$prevstart = $mysqli->real_escape_string($prevstart);
			$prevend = $_REQUEST['prevend'];
			$prevend = $mysqli->real_escape_string($prevend);


//			echo "Summary of: ".$id_user." from: ".$start." to: ".$end."";
//            echo "<br>";
//            echo "Compare with: ".$id_user." from: ".$prevstart." to: ".$prevend."";
//            echo "<p id='date_selecttion'>".date("F", strtotime($prevstart)) ." vs ". date("F", strtotime($start))."</p>";
                        
            
            $this_month = date("F", strtotime("this month"));
            $prev_month = date("F", strtotime("last month"));
            
//            $this = date("F", strtotime($start));
//            $prev = date("F", strtotime($prevstart));
            
            
            
            
//            Fields ----------
            
            echo "<div id='one'>";
            
            echo "<div id='field'>";
            
            $fields = mysqli_query($mysqli,"
select field_settings.id, field_settings.name as name, unit.name as unit from field_settings
left join unit on field_settings.unit = unit.id
where user = '$id_user'
            ");
			while($field = mysqli_fetch_object($fields))
			{
                
                $name = $field->name;
                $unit = $field->unit;
                $id = $field->id;
                
                
//                get value for this timeframe
                $field_this = mysqli_query($mysqli,"
select sum(field.value) as amount from field_settings
left join field on field_settings.id = field.field
right join entry on field.entry = entry.entry
where field_settings.user = '$id_user' and field_settings.id = '$id' and entry.day BETWEEN '$start' and '$end'
group by field_settings.name;
                ")->fetch_row()[0] ?? false;
//			echo $field_this;
            
                
//                get value for prev timeframe
            $field_prev = mysqli_query($mysqli," 
                # display fields
select sum(field.value) as amount from field_settings
left join field on field_settings.id = field.field
right join entry on field.entry = entry.entry
where field_settings.user = '$id_user' and field_settings.id = '$id' and entry.day BETWEEN '$prevstart' and '$prevend'
group by field_settings.name;
                ")->fetch_row()[0] ?? false;
//			echo $field_prev;

                
            if(!$field_prev) $field_prev = 0;
            if(!$field_this) $field_this = 0;
                
//            if($field_this == 0 && $field_prev == 0) {
//                do nothing
//            }
//            else {
                    
                                echo "
            
            <div class='field'>
            <p class='name'>$name</p>
                <div class='prev'>
                    <p class='prev_month'>$prev_month</p>
                    <div class='prev_number'>
                        <p>$field_prev</p>
                    </div>
                </div>
                
                <div class='this'>
                    <p class='month'>$this_month</p>
                    <div class='number'>
                        <p>$field_this</p>
                    </div>
                    <p class='unit'>$unit</p>
                </div>
            </div>
                
            ";
                    
            }
                

                
                
//			}
            
        echo "</div>";
            
            echo "</div>";
            
            

//            PLACES---------------------------
            
echo "<div id='two'>";
            
echo "<div id='places'>";            
            
$resultes = mysqli_query($mysqli,"

Select location.name as places from location 
left join entry on entry.location = location.id
Where location.user = '$id_user' and entry.day BETWEEN '$start' and '$end'
group by location.name

");

            
$resulti = mysqli_query($mysqli,"

Select location.name as places from location 
left join entry on entry.location = location.id
Where location.user = '$id_user' and entry.day BETWEEN '$prevstart' and '$prevend'
group by location.name

");

        $current = mysqli_num_rows($resultes);
        $prev = mysqli_num_rows($resulti);
            
//        echo "";
        echo "<p id='places'>Places</p><div id='places_amount'><div id='prev'><p id='this'>$current</p><p id='prev'>$prev</p></div></div>";
                
// echo mysql_num_rows($resultes); // echo " PLACES "; // echo mysql_num_rows($resulti); // echo "<br>";
            
            echo "<div id='places_names'><p>";
            
            $re = mysqli_query($mysqli,"
            
            
            
# places names
Select location.name as Location, count(id) as Num from entry
left join location on entry.location = location.id

WHERE entry.day BETWEEN '$start' and '$end'
	AND entry.user = '$id_user'

Group by entry.location
order by count(*) DESC
limit 0,5


            
            ");
			while($tag = mysqli_fetch_object($re))
			{
                
                $Location = $tag->Location;
                $Num = $tag->Num;
                
                echo $Location;
//                echo " - ";
//                echo $Num;
                echo "<br>";
            }
            
            
echo "</p></div></div>";
            
            
            
//            TAGS ---------------------------------------
            
            
echo "<div id='tags'>";
            
$resulte = mysqli_query($mysqli,"

SELECT `name`, COUNT(`name`) AS NumOccurrences FROM `tags` 
INNER JOIN `entry` ON entry.entry = tags.entry
WHERE tags.user = '$id_user' AND entry.day BETWEEN '$start' and '$end'
GROUP BY `name` HAVING COUNT(*) > 0 ORDER BY NumOccurrences DESC

");

            
$resultes = mysqli_query($mysqli,"

SELECT `name`, COUNT(`name`) AS NumOccurrences FROM `tags` 
INNER JOIN `entry` ON entry.entry = tags.entry
WHERE tags.user = '$id_user' AND entry.day BETWEEN '$prevstart' and '$prevend'
GROUP BY `name` HAVING COUNT(*) > 0 ORDER BY NumOccurrences DESC

");
           
            $current = mysqli_num_rows($resulte);
            $prev = mysqli_num_rows($resultes);
            
            echo "<p id='places'>Tags</p><div id='tags_amount'><div id='prev'><p id='this'>$current</p><p id='prev'>$prev</p></div></div>";
            
//            echo mysql_num_rows($resulte);
//            echo " TAGS ";
//            echo mysql_num_rows($resultes); 
//            echo "<br>";
            
            echo "<div id='tags_names'><p>";
            
$res = mysqli_query($mysqli,"
            
SELECT `name`, COUNT(`name`) AS Num FROM `tags` 
INNER JOIN `entry` ON entry.entry = tags.entry
WHERE tags.user = '$id_user' AND entry.day BETWEEN '$start' and '$end'
GROUP BY `name` HAVING COUNT(*) > 0 ORDER BY Num DESC
limit 0,5;
            
            ");
			while($tag = mysqli_fetch_object($res))
			{
                
                $name = $tag->name;
                $Num = $tag->Num;
                
                echo $name;
// echo " - "; // echo $Num;
                echo "<br>";
            }
                
echo "</p></div></div>";
            
            
echo "</div>";
            
//todo ----------------------------------

echo "<div id='three'>";
            
echo "<div class='compare'>";
            
            
            $color_resultes = mysqli_query($mysqli,"
                
                SELECT count(text) as Todo FROM todo
WHERE check_date BETWEEN '$start' and '$end'
	AND user = '$id_user'
                
                ")->fetch_row()[0] ?? false;
			

            
            $color_resultii = mysqli_query($mysqli,"
                
SELECT count(text) as Todo FROM todo
WHERE check_date BETWEEN '$prevstart' and '$prevend'
	AND user = '$id_user'
                
                ")->fetch_row()[0] ?? false;

// echo $color_resultes; // echo " TODOS "; // echo $color_resultii; // echo "<br>";
            
            echo "<p class='name'>Todos</p><div class='amount'><p class='current'>$color_resultes</p><p class='prev'>$color_resultii</p></div>";
            
echo "</div>";
            
            
//milestone ----------------------------------

        
echo "<div class='compare'>";
            
            
            $color_resultes = mysqli_query($mysqli,"
                
SELECT count(name) as milestone FROM milestone
WHERE start  BETWEEN '$start' and '$end'
	AND user = '$id_user'
                
                ")->fetch_row()[0] ?? false;
			

            
            $color_resultii = mysqli_query($mysqli,"
                
SELECT count(name) as milestone FROM milestone
WHERE start  BETWEEN '$prevstart' and '$prevend'
	AND user = '$id_user'
                
                ")->fetch_row()[0] ?? false;

//            echo $color_resultes;
//            echo " MILESTONES ";
//            echo $color_resultii;
//            echo "<br>";
//            
            echo "<p class='name'>Milestones</p><div class='amount'><p class='current'>$color_resultes</p><p class='prev'>$color_resultii</p></div>";
            
echo "</div>";
            
            
            
//words -----------------------------
            

echo "<div class='compare'>";

                        $color_resultes = mysqli_query($mysqli,"
                
SELECT SUM( LENGTH( story ) -  LENGTH( REPLACE( story, ' ', '' ) ) +1 ) as words
FROM entry
WHERE day BETWEEN '$start' and '$end'
	AND user = '$id_user'
	
                
                ")->fetch_row()[0] ?? false;

            
            $color_resultii = mysqli_query($mysqli,"
                
SELECT SUM( LENGTH( story ) -  LENGTH( REPLACE( story, ' ', '' ) ) +1 ) as words
FROM entry
WHERE day BETWEEN '$prevstart' and '$prevend'
	AND user = '$id_user'
                
                ")->fetch_row()[0] ?? false;

// echo $color_resultes; // echo " WORDS "; // echo $color_resultii; // echo "<br>";
            
            echo "<p class='name'>Words</p><div class='amount'><p class='current'>$color_resultes</p><p class='prev'>$color_resultii</p></div>";
            
echo "</div>";
            
            
//weather ----------------------------
            

echo "<div class='compare'>";
            
               $weather_1 = mysqli_query($mysqli,"
                
SELECT ROUND(AVG(tempAvg)) FROM `location_day` 
INNER JOIN `entry` ON entry.entry = location_day.entry
WHERE entry.user = '$id_user' AND entry.day BETWEEN '$start' and '$end'
	
                
                ")->fetch_row()[0] ?? false;
			

            
            $weather_2 = mysqli_query($mysqli,"
                
SELECT ROUND(AVG(tempAvg)) FROM `location_day` 
INNER JOIN `entry` ON entry.entry = location_day.entry
WHERE entry.user = '$id_user' AND entry.day BETWEEN '$prevstart' and '$prevend'
                
                ")->fetch_row()[0] ?? false;

// echo $weather_1; // echo " WEATHER "; // echo $weather_2; // echo "<br>";
            
            echo "<p class='name'>Weather</p><div class='amount'><p class='current'>$weather_1&deg;</p><p class='prev'>$weather_2&deg;</p></div>";
            
        echo "</div>";
            
    echo "</div>";
        
            


		break;


		default:
			echo $action;
		break;

	}

?>
