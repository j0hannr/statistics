<?php

$session_expiration = time() + 60; // +2 days --  3600 * 24 * 2
session_set_cookie_params($session_expiration);
session_start();


require_once 'config.php';
$name = $_POST['name'];
$pw = $_POST['pw'];

$name = $mysqli->real_escape_string($name);
$pw = md5($mysqli->real_escape_string($pw));

$user_arr = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM user WHERE email = '".$name."'"));

if (!$user_arr) {
    header('Location: http://'.$host.'/today.php#wrong-user');
    die('Invalid query: ' . mysqli_error());
}

// wow a relict!
//if (!$user_arr){ header('Location: http://brasserie.bplaced.de/login.php'); }

else if ($pw == $user_arr['passwd']) {
    // echo "yey!";
    $_SESSION['login'] = 1;
    $_SESSION['id'] = $user_arr['id'];
    $id_user = $_SESSION['id'];


    header('Location:  http://'.$host.'/'); 

}

else { 
    header('Location: http://'.$host.'/today.php#wrong-password');
    
    // wow another relict!
    //header('Location: http://'.$host.'/abhora/login.php?m=1');
}

?>
