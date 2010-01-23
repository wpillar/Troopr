<?php
    include("../includes/db_connect.php");

    $bid = $_GET['bid'];
    $sid = $_GET['sid'];

    $result = mysql_query("SELECT tid FROM badge_tracker WHERE bid=".$bid." AND sid=".$sid);
    $rownum = mysql_num_rows($result);

    if($rownum == 0){
        mysql_query("INSERT INTO badge_tracker (bid, sid, percent, complete) VALUES (".$bid.",".$sid.",0,'no')") or die(mysql_error());
        header("Location: ../reqs.php?bid=".$bid."&sid=".$sid);
    }
    else
        header("Location: ../reqs.php?bid=".$bid."&sid=".$sid);
?>
