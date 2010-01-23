<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Event</title>
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

                    // Add our new events
                    if ($_POST){
                            $m = $_POST['m'];
                            $d = $_POST['d'];
                            $y = $_POST['y'];

                            $date = $d."/".$m."/".$y;

                            // Formatting for SQL datetime (if this is edited, it will NOT work.)
                            $event_date = $y."-".$m."-".$d." ".$_POST["event_time_hh"].":".$_POST["event_time_mm"].":00";

                            $insEvent_sql = "INSERT INTO calendar_events (event_title, event_type, 
                                event_shortdesc, event_start) VALUES('".mysql_real_escape_string($_POST["event_title"])."',
                                    '".mysql_real_escape_string($_POST['event_type'])."', '".mysql_real_escape_string($_POST["event_shortdesc"])."', '$event_date')";
                            $insEvent_res = mysql_query($insEvent_sql)
                                            or die(mysql_error());
                    } else {
                            $m = $_GET['m'];
                            $d = $_GET['d'];
                            $y = $_GET['y'];

                            $date = $d."/".$m."/".$y;
                    }
            ?>
            <div class="content">
                <h2>Events - <?php echo $date; ?></h2>
                <div class="evcontent">
                <?php
                    
                    // Show the events for this day:
                    $getEvent_sql = "SELECT eid, event_title, event_type, event_shortdesc,
                                    date_format(event_start, '%l:%i %p') as fmt_date FROM
                                    calendar_events WHERE month(event_start) = '".$m."'
                                    AND dayofmonth(event_start) = '".$d."' AND
                                    year(event_start)= '".$y."' ORDER BY event_start";
                    $getEvent_res = mysql_query($getEvent_sql)
                                    or die(mysql_error());

                    if (mysql_num_rows($getEvent_res) > 0){
                            $event_txt = "<ol>";
                            while($ev = @mysql_fetch_array($getEvent_res)){
                                    $event_title = stripslashes($ev["event_title"]);
                                    $event_type = $ev['event_type'];
                                    $event_shortdesc = stripslashes($ev["event_shortdesc"]);
                                    $fmt_date = $ev["fmt_date"];
                                    $event_txt .= "<li><a href=\"functions/delete_event.php?eid=".$ev['eid']."\"><img src=\"images/icons/delete.png\" width=\"12px\" style=\"border:none;\" alt=\"del\"></a>
                                        <span style=\"color:#079307;\">".$fmt_date."</span>:
                                                  <a href=\"event.php?eid=".$ev['eid']."\">".$event_title."</a> - <span style=\"color:#888;\">".$event_type."</span><br/>
                                                      <span style=\"margin-left: 15px;\">".$event_shortdesc."</span></li>";
                            }
                            $event_txt .="</ol>";
                            mysql_free_result($getEvent_res);
                    } else {
                            $event_txt = "";
                    }

                    if ($event_txt != ""){
                            echo "<h3>Today's Events:</h3>
                            $event_txt
                            <hr/>";
                    }

                    // Show form for adding the event:

                    echo "
                    <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
                    <h3>Add Event:</h3>
                    <span class=\"hint\">Complete the form below then press the submit button when you are done</span><br><br>
                    <label class=\"scout_label\">Event Title:</label><input type=\"text\" class=\"box\" name=\"event_title\" size=\"25\" maxlength=\"25\"/></p>
                    <label>Event Type:</label>
                    <select name=\"event_type\" class=\"box\">
                    <option value=\"Meeting\">Meeting</option>
                    <option value=\"Camp\">Camp</option>
                    <option value=\"Activity\">Activity</option>
                    <option value=\"Parade\">Parade</option>
                    </select></p>
                    <label>Event Description:</label><textarea rows=\"8\" cols=\"36\" name=\"event_shortdesc\" style=\"font-size:medium;font-family:Arial;\"></textarea></p>
                    <label>Event Time (hh:mm):</label>
                    <select name=\"event_time_hh\">";
                    for ($x=1; $x<=24; $x++){
                            echo "<option value=\"$x\">$x</option>";
                    }
                    echo "</select> :
                    <select name=\"event_time_mm\">
                    <option value=\"00\">00</option>
                    <option value=\"15\">15</option>
                    <option value=\"30\">30</option>
                    <option value=\"45\">45</option>
                    </select>
                    <input type=\"hidden\" name=\"m\" value=\"".$m."\">
                    <input type=\"hidden\" name=\"d\" value=\"".$d."\">
                    <input type=\"hidden\" name=\"y\" value=\"".$y."\">
                    <br/><br/>
                    <input type=\"submit\" name=\"submit\" class=\"button\" value=\"Add\">
                    </form>";
                ?>
                </div>
            </div>
        </div>
    </body>
</html>
