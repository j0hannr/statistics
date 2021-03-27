<?php



// path
// $host = "localhost/statistics";
// $dir = str_replace("config.php", "", $_SERVER['PHP_SELF']);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$host = $host.$uri;
// echo $_SERVER['HTTP_HOST'].$dir;

// error_reporting(E_ALL);
// ini_set('display_errors', '1');


if (!file_exists('config_mysql.php')) {
    // header('Location: setup.php');
    header('Location: http://'.$host.'/setup.php');
    exit;
}

include 'config_mysql.php';

?>
