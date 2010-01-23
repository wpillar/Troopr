<?php
include("../includes/db_connect.php");
session_start();
mysql_query("DELETE FROM users WHERE uid=".$_GET['uid']) or die(mysql_error());
mysql_query("INSERT INTO activity_logs (username, action, datetime) VALUES ('".$_SESSION['username']."', 'Deleted user (".$_GET['username'].")', '".date("Y-m-d - H:i:s")."S')") or die(mysql_error());
header("Location: ../users.php");
?>
