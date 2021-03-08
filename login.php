<?php
session_start();
require_once 'config.php';
if ($_SESSION['login']!=1) {

//get information!!!

// function getBrowser()
// {
//     $u_agent = $_SERVER['HTTP_USER_AGENT'];
//     $bname = 'Unknown';
//     $platform = 'Unknown';
//     $version= "";

//     //First get the platform?
//     if (preg_match('/linux/i', $u_agent)) {
//         $platform = 'linux';
//     } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
//         $platform = 'mac';
//     } elseif (preg_match('/windows|win32/i', $u_agent)) {
//         $platform = 'windows';
//     }

//     // Next get the name of the useragent yes seperately and for good reason
//     if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
//         $bname = 'Internet Explorer';
//         $ub = "MSIE";
//     } elseif (preg_match('/Firefox/i', $u_agent)) {
//         $bname = 'Mozilla Firefox';
//         $ub = "Firefox";
//     } elseif (preg_match('/Chrome/i', $u_agent)) {
//         $bname = 'Google Chrome';
//         $ub = "Chrome";
//     } elseif (preg_match('/Safari/i', $u_agent)) {
//         $bname = 'Apple Safari';
//         $ub = "Safari";
//     } elseif (preg_match('/Opera/i', $u_agent)) {
//         $bname = 'Opera';
//         $ub = "Opera";
//     } elseif (preg_match('/Netscape/i', $u_agent)) {
//         $bname = 'Netscape';
//         $ub = "Netscape";
//     }

//     // finally get the correct version number
//     $known = array('Version', $ub, 'other');
//     $pattern = '#(?<browser>' . join('|', $known) .
//     ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
//     if (!preg_match_all($pattern, $u_agent, $matches)) {
//         // we have no matching number just continue
//     }

//     // see how many we have
//     $i = count($matches['browser']);
//     if ($i != 1) {
//         //we will have two since we are not using 'other' argument yet
//         //see if version is before or after the name
//         if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
//             $version= $matches['version'][0];
//         } else {
//             $version= $matches['version'][1];
//         }
//     } else {
//         $version= $matches['version'][0];
//     }

//     // check if we have a number
//     if ($version==null || $version=="") {
//         $version="?";
//     }

//     return array(
//         'userAgent' => $u_agent,
//         'name'      => $bname,
//         'version'   => $version,
//         'platform'  => $platform,
//         'pattern'    => $pattern
//     );
// }

//     function get_ip_address()
//     {
//         global $ip;
//         foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
//             if (array_key_exists($key, $_SERVER) === true) {
//                 foreach (explode(',', $_SERVER[$key]) as $ip) {
//                     $ip = trim($ip); // just to be safe

//                 if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
//                     return $ip;
//                 }
//                 }
//             }
//         }
//     }
// // now try it
// $ua=getBrowser();
//     $yourbrowser=  $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
//     $os = $ua['platform'];
//     $name = $ua['name'];
//     $version = $ua['version'];
//     $text = $ua['userAgent'];

//     $time = date('Y-m-d H:i:s', time());

//     get_ip_address();
//     $ipa = $ip;

//     $response = file_get_contents("http://ipinfo.io/".$ip."/json");
//     $json = json_decode($response);

//     $ip = $json->ip;
// //echo $ip;

// $city = $json->city;
// //echo $city;

// $region = $json->region;
// //echo $region;

// $land = $json->country;
// //echo $land;

// $loc = $json->loc;
// //echo $loc;

// $org = $json->org;
// //echo $org;

// $postal = $json->postal;
// //echo $postal;


// // $sql="INSERT INTO `session` SET ip='$ipa', site='1', os='$os', browser='$name', version='$version', description='$text', timestamp='$time', city='$city', region='$region', country='$land', location='$loc', postcode='$postal', provider='$org'";
// $sql = mysqli_prepare($mysqli, "INSERT INTO `session` SET ip='$ipa', site='1', os='$os', browser='$name', version='$version', description='$text', timestamp='$time', city='$city', region='$region', country='$land', location='$loc', postcode='$postal', provider='$org'");
    
// $result=mysqli_query($mysqli, $sql);
// // mysqli_query($query); 

// function db_var($query) {

//     $user_arr = $mysqli->prepare($query);
//     $result=mysqli_query($mysqli, $user_arr);
//     // print_r($result);   
//     // echo $result;
//     return $result;
// }


// $user_arr = mysqli_query("SELECT * FROM user WHERE email = 'johann' ");
$user_arr = $mysqli->prepare("SELECT * FROM user WHERE email = 'johann' ");
$result=mysqli_query($mysqli, $user_arr);
print_r($result);   
echo $result;
var_export($result);

$name = 'johann';
$stmt = $mysqli->prepare("SELECT * FROM user WHERE email = '$name'");
// $stmt->bind_param("s", $_POST['name']);
$stmt->execute();
$arr = $stmt->get_result()->fetch_assoc();
// if(!$arr) exit('No rows');
var_export($arr);
$stmt->close();

echo $arr['passwd'];

echo "hello world";
?>



<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=0.7, maximum-scale=0.7" />
<title>Statistics v5</title>
<link rel="stylesheet" type="text/css" href="inc/css/style.css">
<link rel="stylesheet" href="inc/css/normalize.css">
<link rel="stylesheet" href="inc/css/skeleton.css">
<link rel="stylesheet" href="inc/css/icon-font.css">

</head>



<body>


  <div id="login" class="container">



    <div class="header" class="row">
      <div style="margin-top: 90px;" class="four columns offset-by-four">
        <div class="header">STATISTICS</div>
        <div class="version">v.5</div>
  		</div>
    </div>

    <div class="" class="row">
      <div  class="six columns offset-by-three">
      <form method="post" action="check_login.php" >
      <input id="mail" placeholder="Email" type="mail" name="name"/>
      <input id="passwd" placeholder="Password" type="password" name="pw"/>
      <input id="submit_login" TYPE="submit"  value="Go"/>
      </form>
      </div>
    </div>

    <div class="symbolics" class="row">
      <div id="symbolics" class="four columns offset-by-four">
        <div data-icon="o" class="icon"></div>
        <div data-icon="c" class="icon"></div>
        <div data-icon="f" class="icon"></div>
      </div>
    </div>

    <!-- <div class="symbolics" class="row">
      <div class="four columns offset-by-four">
        <p data-icon="o" class="icon"></p>
        <p data-icon="c" class="icon"></p>
        <p data-icon="f" class="icon"></p>
      </div>
    </div> -->


  </div>





</body>
</html>
<?php

} else {
    header('Location: http://'.$host.'/');
}

?>
