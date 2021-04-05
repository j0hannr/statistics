<?php

// host path
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$host  = $host.$uri;

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

if (!file_exists('config_mysql.php')) {
    header('Location: http://'.$host.'/setup.php');
    exit;
}

include_once 'config_mysql.php';

?>
