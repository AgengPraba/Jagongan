<?php
session_start();
include("include/connection.php");

$user_email=$_SESSION['user_email'] ;
$update_status = mysqli_query($con, "UPDATE users SET log_in='offline' WHERE user_email='$user_email'");

$_SESSION['signin'] = false;

session_unset();
session_destroy();
header("Location:signin.php");
?>