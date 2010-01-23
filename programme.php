<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Programme</title>
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
            ?>
            <div class="content">
                <h2>Programme</h2>
                <div class="calendar">
                <?php
                    if ((!isset($_POST['month'])) || (!isset($_POST['year']))) {
                            $nowArray = getdate();
                            $month = $nowArray['mon'];
                            $year = $nowArray['year'];
                    } else {
                            $month = $_POST['month'];
                            $year = $_POST['year'];
                    }
                    $start = mktime(12,0,0,$month,1,$year);
                    $firstDayArray = getdate($start);

                ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <select name="month">
                    <?php
                    $months = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

                    for ($x=1; $x<=count($months); $x++){
                            echo "<option value=\"$x\"";
                            if ($x == $month){
                                    echo " selected";
                            }
                            echo ">".$months[$x-1]."</option>";
                    }
                    ?>
                    </select>
                    <select name="year">
                    <?php
                    for ($x=1980; $x<=2010; $x++){
                            echo "<option";
                            if ($x == $year){
                                    echo " selected";
                            }
                            echo ">$x</option>";
                    }
                    ?>
                    </select>
                    <input type="submit" name="submit" value="Go!">
                </form>
                <?php
                    include("includes/db_connect.php");
                    define("ADAY", (60*60*24));
                    $days = Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
                    echo "<table border=\"1\"><tr>\n";
                    foreach ($days as $day){
                            echo "<td id=\"calheading\">$day</td>\n";
                    }
                    for ($count=0; $count < (6*7); $count++) {
                            $dayArray = getdate($start);
                            if (($count % 7) == 0) {
                                    if ($dayArray["mon"] != $month) {
                                            break;
                                    } else {
                                            echo "</tr><tr>\n";
                                    }
                            }
                            if ($count < $firstDayArray["wday"] || $dayArray["mon"] != $month) {
                                    echo "<td> </td>";
                            } else {
                                    $chkEvent_sql = "SELECT eid, event_title FROM calendar_events WHERE month(event_start) = '".$month."' AND dayofmonth(event_start) = '".$dayArray["mday"]."' AND year(event_start) = '".$year."' ORDER BY event_start";
                                    $chkEvent_res = mysql_query($chkEvent_sql) or die(mysql_error());

                                    if (mysql_num_rows($chkEvent_res) > 0) {
                                            $event_title = "";
                                            while ($ev = mysql_fetch_array($chkEvent_res)) {
                                                    $event_title .= stripslashes($ev["event_title"])."<br/>";
                                                    $eid = $ev['eid'];
                                            }
                                            mysql_free_result($chkEvent_res);
                                    } else {
                                            $event_title = "";
                                            $eid = null;
                                    }

                                    echo "<td valign=\"top\"><a class=\"num\" style=\"color: #0A6284;\" href=\"today.php?m=".$month."&d=".$dayArray["mday"]."&y=$year\">
                                    ".$dayArray["mday"]."</a><div class=\"etitle\"><a class=\"title\" href=\"event.php?eid=".$eid."&m=".$month."&d=".$dayArray["mday"]."&y=$year\">".$event_title."</a></div></td>";

                                    unset($event_title);

                                    $start += ADAY;
                            }
                    }
                    echo "</tr></table>";
                ?>
                </div>
            </div>
        </div>
    </body>
</html>
