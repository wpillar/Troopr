<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
    include("includes/db_connect.php");

    $result = mysql_query("SELECT * FROM calendar_events WHERE eid=".$_GET['eid']);
    $row = mysql_fetch_array($result);

    $eid = $_GET['eid'];

    $etitle = $row['event_title'];
    $edesc = $row['event_shortdesc'];
    $etype = $row['event_type'];
    
    $split = explode("-", $row['event_start']);

    $split2 = explode(" ", $split[2]);

    $edate = $split2[0]."/".$split[1]."/".$split[0];


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - <?php echo $etitle; ?></title>
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
                <h2><?php echo $etitle; ?></h2>
                <div class="submenu">
                    <img src="images/icons/calendar_delete.png" alt="delete event" /> <a href="functions/delete_event.php?eid=<?php echo $eid;?>">Delete Event</a>
                    | <img src="images/icons/calendar_edit.png" alt="edit" /> <a href="editevent.php?eid=<?php echo $eid; ?>&m=<?php echo $_GET['m'];?>&d=<?php echo $_GET['d'];?>&y=<?php echo $_GET['y'];?>">Edit Event</a>
                    | <img src="images/icons/email.png" alt="email" /> <a href="sendmail.php?to=<?php
                                                                            include("includes/db_connect.php");

                                                                            $result = mysql_query("SELECT p1email FROM scouts");

                                                                            while($row = mysql_fetch_array($result)){
                                                                                echo $row['p1email'];
                                                                                echo ", ";
                                                                            }

                                                                            mysql_close($conn);
                                                                          ?>&sub=<?php echo $etitle." ".$edate;?>&msg=Reminder to all parents about <?php echo $etitle; ?>">Email All Parents</a>
                    | <img src="images/icons/email.png" alt="email" /> <a href="sendmail.php?to=<?php
                                                                            include("includes/db_connect.php");

                                                                            $result = mysql_query("SELECT email FROM users WHERE type != 'superadmin'");

                                                                            while($row = mysql_fetch_array($result)){
                                                                                echo $row['email'];
                                                                                echo ", ";
                                                                            }

                                                                            mysql_close($conn);
                                                                          ?>">Email All Leaders</a>
                </div>
                <div class="eventpro">
                    <h3>Date/Time</h3>
                    <?php echo $edate; ?>
                    <h3>Type</h3>
                    <?php echo $etype; ?>
                    <h3>Description</h3>
                    <?php echo $edesc; ?>
                    <?php if($etype != "Meeting"){ ?>
                    <h3>Attendees</h3>
                    <div style="margin-left:10px;" >
                    <a href="attendance.php?eid=<?php echo $eid;?>">Update Attendance</a>
                    <br><br>
                    <?php
                        include("includes/db_connect.php");

                        $getattend = mysql_query("SELECT sid FROM event_attend WHERE eid=".$eid);
                        $numattend = mysql_num_rows($getattend);

                        if($numattend != 0){
                            while($listattend = mysql_fetch_array($getattend)){
                                $getnames = mysql_query("SELECT sid, CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE sid=".$listattend['sid']);
                                $names = mysql_fetch_array($getnames);

                                echo "<a href=\"functions/remove_attend.php?sid=".$names['sid']."&eid=".$eid."\"><img src=\"images/icons/delete.png\" width=\"12px\" style=\"border:none;\" alt=\"remove\" /></a>
                                    <a href=\"scoutprofile.php?sid=".$names['sid']."\">".$names['name']."</a><br>";
                            }
                            echo "<br><span style=\"color:#666;\">Total Scouts: ".$numattend."</span>";
                        }
                        else{
                    ?>
                    <span style="color:red;font-size:14pt;">Currently there are no Scouts attending! <a href="attendance.php?eid=<?php echo $eid;?>">Update Attendance?</a></span>
                    <?php
                        }
                    } 
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
