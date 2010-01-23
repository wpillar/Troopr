<?php
$pid = $_GET['pid'];

include("../includes/db_connect.php");

//SET ALL SCOUTS TO assigned = no
$sresult = mysql_query("SELECT sid FROM patrols_scouts WHERE pid =".$pid) or die(mysql_error());
while($srow = mysql_fetch_array($sresult)){
    mysql_query("UPDATE scouts SET assigned = 'no' WHERE sid =".$srow['sid']) or die(mysql_error());
}

//DELETE ALL ROWS FROM patrols_scouts WHERE pid = $pid
mysql_query("DELETE FROM patrols_scouts WHERE pid =".$pid) or die(mysql_error());

//DELETE FROM patrols WHERE pid = $pid
mysql_query("DELETE FROM patrols WHERE pid =".$pid) or die(mysql_error());

header("Location: ../patrols.php?del=true");

?>
