<?php

if (!file_exists('config_mysql.php')) {
    header('Location: setup.php');
}

include 'config_mysql.php';

// path
$host = "localhost/statistics";

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

?>
