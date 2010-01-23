<?php
    //Setup db details
    $db_server = 'localhost';
    $db_name = 'troopr';
    $db_user = 'static';
    $db_pass = 'minor101.';   
    
    //Connect to server and select a db
    $conn = mysql_connect($db_server, $db_user, $db_pass);
    mysql_select_db($db_name, $conn);
?>
