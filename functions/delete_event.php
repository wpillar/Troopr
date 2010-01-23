<?php
    include("../includes/db_connect.php");
    $eid = $_GET['eid'];

    mysql_query("DELETE FROM calendar_events WHERE eid =".$eid) or die(mysql_error());
    header("Location: ../programme.php");
?>
