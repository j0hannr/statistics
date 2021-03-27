<?php 

// database
$host = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'statistics';

// connecting to MySQL DB
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    # host, user , password, database name
    $mysqli = new mysqli( $host, $user, $pass, $database);
    $mysqli->set_charset("utf8mb4");
} 
catch(Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database'); //Should be a message a typical user could understand
}


?>
