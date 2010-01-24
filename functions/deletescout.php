<?php

if(isset($_GET['tbl'])=="patrol"){
    include("../includes/db_connect.php");
    mysql_query("DELETE FROM patrols_scouts WHERE sid=".$_GET['sid']) or die(mysql_error());
    mysql_query("UPDATE scouts SET assigned='no' WHERE sid=".$_GET['sid']);
    header("Location: ../patrols.php");
}
else{
    include("../includes/db_connect.php");
    session_start();
    mysql_query("DELETE FROM scouts WHERE sid=".$_GET['sid']) or die(mysql_error());
    mysql_query("DELETE FROM badge_tracker WHERE sid=".$_GET['sid']) or die(mysql_error());
    mysql_query("DELETE FROM patrols_scouts WHERE sid=".$_GET['sid']) or die(mysql_error());
    mysql_query("DELETE FROM event_attend WHERE sid=".$_GET['sid']) or die(mysql_error());
    mysql_query("INSERT INTO activity_logs (username, action, datetime) VALUES ('".$_SESSION['username']."', 'Deleted Scout (".str_rot13($_GET['firstname'])." ".str_rot13($_GET['lastname']).")', '".date("Y-m-d - H:i:s")."S')") or die(mysql_error());
    header("Location: ../scouts.php");
}
?>
