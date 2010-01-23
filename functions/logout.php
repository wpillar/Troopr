<?php
    session_start(); //Start the session
    include("../includes/db_connect.php"); //Connect to db
    $user = $_SESSION['username']; //Fetch user's username
    mysql_query("INSERT INTO access_logs (username, type) VALUES ('".$user."', 'logout')"); //Update logs
    mysql_query("UPDATE users SET lastlogin='".date("Y-m-d - H:i:s")."' WHERE username ='".$user."'") or die(mysql_error());
    mysql_close($conn);
    session_unset(); //Unset all session data
    session_destroy(); //Destroy the session
    header("Location: ../index.php"); //Return to index
?>
