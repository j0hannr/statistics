<?php

//session_save_path('/statistics');
//ini_set('session.gc_maxlifetime', 3*60*60*8*2); // 2 days hours
//ini_set('session.gc_probability', 1);
//ini_set('session.gc_divisor', 100);
//ini_set('session.cookie_secure', FALSE);
//ini_set('session.use_only_cookies', TRUE);

$session_expiration = time() + 60; // +2 days --  3600 * 24 * 2
session_set_cookie_params($session_expiration);

session_start();


require_once 'config.php';
$name = $_POST['name'];
$pw = $_POST['pw'];
$name = mysql_real_escape_string($name);
$pw = md5(mysql_real_escape_string($pw));
// echo ($email."<br>".$pw);

$user_arr = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE email = '".$name."'"));

if (!$user_arr) { // add this check.
    
    header('Location: http://'.$host.'/today.php#wrong-user');
    die('Invalid query: ' . mysql_error());
}

//if (!$user_arr){ header('Location: http://brasserie.bplaced.de/login.php'); }
elseif ($pw == $user_arr['passwd']) {
// echo "yey!";
$_SESSION['login'] = 1;
$_SESSION['id'] = $user_arr['id'];
$id_user = $_SESSION['id'];


//$value = 'fhlj84kbaace53vp05ggt2sdr5';

//setcookie("PHPSESSID", $value, 1412174272);

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
$sql="INSERT INTO `session` SET ip='$ipa', site='4', user='$id_user', os='$os', browser='$name', version='$version', description='$text', timestamp='$time', city='$city', region='$region', country='$land', location='$loc', postcode='$postal'";
$result=mysql_query($sql);
mysql_query($query);



// $_SESSION['user'] = $username;
// $_SESSION['user_id'] = $user_arr['user_id'];
// $_SESSION['admin-login'] = 1;
// $_SESSION['first_name'] = $user_arr['user_first_name'];
// $_SESSION['last_name'] = $user_arr['user_last_name']; 

if ($id_user = 1) {
	header('Location: http://'.$host.'/today.php');
}
else {
	header('Location:  http://'.$host.''); 
}


}

else { 
    
    
    
//    echo "hello world";
// echo ("Wrong PW!<br>");
// echo ("Name: ".$name);
// echo ("<br>PW: ".$pw);
// echo ("<br> correct: ");
// print_r ($user_arr);
    
    header('Location: http://'.$host.'/today.php#wrong-password');
    
    
//header('Location: http://'.$host.'/abhora/login.php?m=1');
}

// $user_arr = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_login = '$username'"));
// if (!$user_arr){
// // header('Location: http://'.$host.'/iopl/admin/index.php');
// }
// elseif ($user_arr['user_pass'] == $pw && $user_arr['status']==0){
// // echo "yey!";
// $_SESSION['admin-login'] = 1;
// $_SESSION['user'] = $suername;
// $_SESSION['user_id'] = $user_arr['user_id'];
// $_SESSION['admin-login'] = 1;
// $_SESSION['first_name'] = $user_arr['user_first_name'];
// $_SESSION['last_name'] = $user_arr['user_last_name'];
// // header('Location: http://'.$host.'/iopl/admin/index.php');
// }
// // else header('Location: http://'.$host.'/iopl/admin/index.php');
// // echo $username."<br>";
// // echo $pw;
// // print_r ($user_arr);
?>
