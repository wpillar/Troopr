<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Logs</title>
        <?php include("includes/meta.php") ?>
    </head>
    <body>
        <div class="container">
            <?php
                include("includes/header.php"); //include header div
                include("includes/nav.php"); //include nav div
                include("includes/sidebar.php"); //include sidebar

                function PageURL() {
                    $pageURL = 'http';
                    //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
                    $pageURL .= "://";
                    if ($_SERVER["SERVER_PORT"] != "80") {
                        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
                    } else {
                        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                    }
                    return $pageURL;
                }

                include("includes/db_connect.php");
                
                if($_GET['action'] == "activity"){
                        $result = mysql_query("SELECT * FROM activity_logs ORDER BY datetime DESC");
                        $field = "action";
                        $heading = "Action";
                }
                else if($_GET['action'] == "access"){
                        $result = mysql_query("SELECT * FROM access_logs ORDER BY datetime DESC");
                        $field = "type";
                        $heading = "Type";
                }
            ?>
            <div class="content">
                <h2>Logs</h2>
                <div class="submenu">
                    <img src="images/icons/page_white_gear.png" alt="page gear" /> <a href="logs.php?action=activity">Activity Logs</a> |
                     <img src="images/icons/page_white_key.png" alt="page key" /> <a href="logs.php?action=access">Access Logs</a>
                </div>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Action</th>
                        <th>Date/Time</th>
                    </tr>
                <?php
                    while($row = mysql_fetch_array($result))
                    {
                        echo '<tr><td>'.$row['username'].'</td><td>'.$row[''.$field.''].'</td><td>'.$row['datetime'].'</td>';
                        echo '</tr>';
                    }
                    mysql_close($conn);
                ?>
                </table>
            </div>
        </div>
    </body>
</html>
