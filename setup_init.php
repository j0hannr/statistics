<?php

$db_host = $_POST['host'];
$db_user = $_POST['user'];
$db_database = $_POST['database'];
$db_pass = $_POST['pass'];

echo "<br>".$db_host;
echo "<br>".$db_user;
echo "<br>".$db_database;
echo "<br>".$db_pass;

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$host = $host.$uri;

// check db connection
// connecting to MySQL DB
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    # host, user , password, database name
    $mysqli = new mysqli( $db_host, $db_user, $db_pass, $db_database);
    $mysqli->set_charset("utf8mb4");
} 
catch(Exception $e) {
    error_log($e->getMessage());
    header('Location: http://'.$host.'/setup.php#wrong-password');
    exit('Error connecting to database'); // Should be a message a typical user could understand
}

$file = '
<?php
// connecting to MySQL DB
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    # host, user , password, database name
    $mysqli = new mysqli( "'.$db_host.'", "'.$db_user.'", "'.$db_pass.'", "'.$db_database.'");
    $mysqli->set_charset("utf8mb4");
} 
catch(Exception $e) {
    error_log($e->getMessage());
    exit("Error connecting to database"); //Should be a message a typical user could understand
}
?>';

// true create config_mysql.php file
$myfile = fopen("config_mysql.php", "w") or die("Unable to open file!");
fwrite($myfile, $file);
fclose($myfile);

// (init db tables)

header('Location: http://'.$host.'/');

?>
