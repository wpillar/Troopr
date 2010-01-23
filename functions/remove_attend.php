<?php
    $eid = $_GET['eid'];
    $sid = $_GET['sid'];

    include("../includes/db_connect.php");

    mysql_query("DELETE FROM event_attend WHERE eid=".$eid." AND sid=".$sid) or die(mysql_error());

    header("Location: ../event.php?eid=".$eid);
?>
