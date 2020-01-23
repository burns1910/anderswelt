<?php
include 'config.php';
session_destroy();
unset($_SESSION['user_id']);
header("Location: index.php");
?>