<?php
    include("../includes/db_connect.php");

    $bid = $_GET['bid'];
    $sid = $_GET['sid'];

    mysql_query("DELETE FROM badge_tracker WHERE bid=".$bid." AND sid=".$sid) or die(mysql_error());
    mysql_query("UPDATE scouts SET badges=badges-1 WHERE sid=".$sid) or die(mysql_error);

    header("Location: ../scoutprofile.php?sid=".$sid);

?>
