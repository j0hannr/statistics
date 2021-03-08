<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    # host, user , password, database name
    $mysqli = new mysqli("localhost", "root", "root", "statistics");
    $mysqli->set_charset("utf8mb4");
} catch(Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database'); //Should be a message a typical user could understand
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
