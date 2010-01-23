<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
    include("includes/db_connect.php");
    
    $eid = $_GET['eid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Attendance</title>
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

                if(isset($_POST['submit'])){
                    $getmaxsid = mysql_query("SELECT MAX(scouts.sid) AS msid FROM scouts WHERE scouts.sid NOT IN (SELECT sid FROM event_attend WHERE eid=".$eid.")");
                    $maxsid = mysql_fetch_array($getmaxsid);

                    //get checked scouts
                    for($i=0; $i<=$maxsid['msid']; $i++){
                        if(isset($_POST[$i])){
                            if($_POST[$i] == "on"){
                                //submit entry
                                mysql_query("INSERT INTO event_attend (eid, sid) VALUES (".$eid.",".$i.")") or die(mysql_error());
                            }
                        }
                    }
                    //header("Location: event.php?eid=".$eid);
                    echo "<script type=\"text/javascript\">document.location.href='event.php?eid=".$eid."'</script> ";
                }
            ?>
            <div class="content">
                <h2>Attendance</h2><br>
                <center>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?eid=<?php echo $eid; ?>">
                    <table style="width:300px;">
                    <?php
                        //get list of scouts already not attending
                        $getscoutsnot = mysql_query("SELECT scouts.sid FROM scouts WHERE scouts.sid NOT IN (SELECT sid FROM event_attend WHERE eid=".$eid.")");
                        while($scoutsnot = mysql_fetch_array($getscoutsnot)){
                            $getnames = mysql_query("SELECT sid, CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE sid=".$scoutsnot['sid']);
                            $names = mysql_fetch_array($getnames);

                            echo "<tr><td>".$names['name']."</td><td style=\"text-align:center;\"><input type=\"checkbox\" name=\"".$names['sid']."\" /></td></tr>";
                        }

                        //output list with checkboxes

                        //get sids of scouts who were checked and add new row to event_attend with eid and sid
                        //return to event page
                    ?>
                    </table><br>
                    <input type="submit" name="submit" value="Submit" class="button" style="margin-left:20px;" />
                </form>
                </center>
            </div>
        </div>
    </body>
</html>
