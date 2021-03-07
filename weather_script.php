<!DOCTYPE html>

    <?php

    require "config.php";
    $time = date('Y-m-d H:i:s', time());

    $result = mysql_query("SELECT location_day.id, location.latitude, location.longitude, entry.day FROM `location_day`
JOIN location ON location_day.location = location.id
JOIN entry ON location_day.entry = entry.entry");
	while($day = mysql_fetch_object($result))
	{

	    $date = $day->day;
	    $lat = $day->latitude;
	    $lng = $day->longitude;
	    $id = $day->id;
	    echo $id;
	    echo "<br>";
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

			$sqlocation="UPDATE `location_day` SET text='$summary', status='$status', sunrise='$rise', sunset='$fall', moonphase='$phase', tempMin='$tempMin', tempMax='$tempMax', tempAvg='$tempAvg', humidity='$humidity', windspeed='$speed', cloudcover='$cloud', precip='$precip_type', dewpoint='$dewpoint', pressure='$pressure', ozone='$ozone', tempMintime='$tempMaxtime', tempMaxtime='$tempMaxtime', precip_chance='$precip_chance', precip_amount='$precip_amount', precipMax='$precipMax', precipMaxtime='$precipMaxTime' WHERE id = '$id'";

			$res=mysql_query($sqlocation);
			mysql_query($res);
        }


?>

</html>
