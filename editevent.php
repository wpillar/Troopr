<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    $eid = $_GET['eid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Edit Event</title>
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

                if (isset($_POST['submit'])){
                            $m = $_POST['m'];
                            $d = $_POST['d'];
                            $y = $_POST['y'];

                            $date = $d."/".$m."/".$y;

                            // Formatting for SQL datetime (if this is edited, it will NOT work.)
                            $event_date = $y."-".$m."-".$d." ".$_POST["event_time_hh"].":".$_POST["event_time_mm"].":00";#

                            //echo $event_date;

                            $insEvent_sql = "UPDATE calendar_events SET event_title='".$_POST["event_title"]."', event_type='".$_POST['event_type']."',
                                event_shortdesc='".$_POST["event_shortdesc"]."', event_start='$event_date' WHERE eid=".$eid;
                            //echo $insEvent_sql;
                            $insEvent_res = mysql_query($insEvent_sql)
                                            or die(mysql_error());
                            //header("Location: event.php?eid=".$eid);
                            echo "<script type=\"text/javascript\">document.location.href='event.php?eid=".$eid."'</script>";
                    } else {
                            $m = @$_GET['m'];
                            $d = @$_GET['d'];
                            $y = @$_GET['y'];

                            $date = $d."/".$m."/".$y;
                    }


                $getevent = mysql_query("SELECT * FROM calendar_events WHERE eid=".$eid);
                $event = mysql_fetch_array($getevent);

                $etitle = $event['event_title'];
                $etype = $event['event_type'];
                $edesc = $event['event_shortdesc'];
                $etime = $event['event_start'];

                $split = explode(" ", $etime);
                $split2 = explode(":", $split[1]);

                if($etype == "Meeting"){ $select1 = "selected=\"\"";}
                if($etype == "Camp"){ $select2 = "selected=\"\"";}
                if($etype == "Activity"){ $select3 = "selected=\"\"";}
                if($etype == "Parade"){ $select4 = "selected=\"\"";}
            ?>
            <div class="content">
                <h2>Edit Event</h2>
                <div class="evcontent">
                    
                    <?php
                    echo "
                        <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?eid=".$eid."\">
                        <h3>Edit Event:</h3>
                        <span class=\"hint\">Complete the form below then press the submit button when you are done</span><br><br>
                        <label class=\"scout_label\">Event Title:</label><input type=\"text\" class=\"box\" name=\"event_title\" size=\"25\" maxlength=\"25\" value=\"".$etitle."\"/></p>
                        <label>Event Type:</label>
                        <select name=\"event_type\" class=\"box\">
                        <option value=\"Meeting\" ".@$select1.">Meeting</option>
                        <option value=\"Camp\" ".@$select2.">Camp</option>
                        <option value=\"Activity\" ".@$select3.">Activity</option>
                        <option value=\"Parade\" ".@$select4.">Parade</option>
                        </select></p>
                        <label>Event Description:</label><textarea rows=\"8\" cols=\"36\" name=\"event_shortdesc\" style=\"font-size:medium;font-family:Arial;\">".$edesc."</textarea></p>
                        <label>Event Time (hh:mm):</label>
                        <select name=\"event_time_hh\">";
                        for ($x=1; $x<=24; $x++){
                                if($x == $split2[0]){
                                    echo "<option value=\"$x\" selected=\"\">$x</option>";
                                }
                                else
                                    echo "<option value=\"$x\">$x</option>";
                        }
                        
                        if($split2[1] == 00){$select5="selected=\"\"";}
                        if($split2[1] == 15){$select6="selected=\"\"";}
                        if($split2[1] == 30){$select7="selected=\"\"";}
                        if($split2[1] == 45){$select8="selected=\"\"";}

                        echo "</select> :
                        <select name=\"event_time_mm\">
                        <option value=\"00\" ".@$select5.">00</option>
                        <option value=\"15\" ".@$select6.">15</option>
                        <option value=\"30\" ".@$select7.">30</option>
                        <option value=\"45\" ".@$select8.">45</option>
                        </select>
                        <input type=\"hidden\" name=\"m\" value=\"".$m."\">
                        <input type=\"hidden\" name=\"d\" value=\"".$d."\">
                        <input type=\"hidden\" name=\"y\" value=\"".$y."\">
                        <br/><br/>
                        <input type=\"submit\" name=\"submit\" class=\"button\" value=\"Save\">
                        </form>";
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
