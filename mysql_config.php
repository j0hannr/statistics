<?php

// LOCALHOST

    $mysqlhost="localhost"; // MySQL-Host angeben

    $mysqluser="root"; // MySQL-User angeben

    $mysqlpwd="root"; // Passwort angeben

    $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ('Verbindungsversuch fehlgeschlagen');

    $mysqldb="statistics"; // Gewuenschte Datenbank angeben

    mysql_select_db($mysqldb, $connection) or die('Konnte Datenbank nicht waehlen');



// ONE SQUARED

//    $mysqlhost="one-squared.com"; // MySQL-Host angeben
//
//    $mysqluser="statistics_2"; // MySQL-User angeben
//
//    $mysqlpwd="qAf#bAoJtt747gog"; // Passwort angeben
//
//    $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ('Verbindungsversuch fehlgeschlagen');
//
//    $mysqldb="statistics_2"; // Gewuenschte Datenbank angeben
//
//    mysql_select_db($mysqldb, $connection) or die('Konnte Datenbank nicht waehlen');

// MORITZ STRATO

//    $mysqlhost="rdbms.strato.de"; // MySQL-Host angeben
//
//    $mysqluser="U3419139"; // MySQL-User angeben
//
//    $mysqlpwd="lkrsakjnq3!x3q"; // Passwort angeben
//
//    $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ('Verbindungsversuch fehlgeschlagen');
//
//    $mysqldb="DB3419139"; // Gewuenschte Datenbank angeben
//
//    mysql_select_db($mysqldb, $connection) or die('Konnte Datenbank nicht waehlen');
//    

// ----- ONE SQUARED
    
//    $mysqlhost="one-squared.com:3306"; // MySQL-Host angeben
//
//    $mysqluser="statistics_2"; // MySQL-User angeben
//
//    $mysqlpwd="p90d@9DsQCgccrko"; // Passwort angeben
//
//    $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ('Verbindungsversuch fehlgeschlagen');
//
//    $mysqldb="statistics_2"; // Gewuenschte Datenbank angeben
//
//    mysql_select_db($mysqldb, $connection) or die('Konnte Datenbank nicht waehlen');
    
?>
