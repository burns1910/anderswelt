<?php
session_start();
define('USER', 'root');
define('PASSWORD', '');
define('HOST', 'localhost');
define('DATABASE', 'burns');
$logged_in_admin = false;

$mail_absender = array('deine@anderswe.lt', 'rene@anderswe.lt', 'louis@anderswe.lt', 'max@anderswe.lt', 'freya@anderswe.lt', 'maxS@anderswe.lt', 'bjoern@anderswe.lt', 'vanessa@anderswe.lt');
 
try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

if(isset($_SESSION['user_id'])){
	$logged_in_admin = true;
}

?>
