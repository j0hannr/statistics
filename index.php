<?php
session_start();
require_once 'config.php';

if ($_SESSION['login']==1) {
	header('Location: http://'.$host.'/today.php');
}
else {
    header('Location: http://'.$host.'/login.php');
}

?>
