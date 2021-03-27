<?php

$host = $_POST['host'];
$user = $_POST['user'];
$database = $_POST['database'];
$pass = $_POST['pass'];


// check db connection
// connecting to MySQL DB
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    # host, user , password, database name
    $mysqli = new mysqli( $host, $user, $pass, $database);
    $mysqli->set_charset("utf8mb4");
} 
catch(Exception $e) {
    error_log($e->getMessage());
    header('Location: http://'.$host.'/today.php#wrong-password');
    exit('Error connecting to database'); // Should be a message a typical user could understand
}

echo "hello world";

echo "<br>Path: ".$_SERVER['DOCUMENT_ROOT'];

// false -> go back

// true create config_mysql.php file

// (init db tables)

// header('Location: http://'.$host.'/today.php#wrong-password');

?>
