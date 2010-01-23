<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    $bid = $_GET['bid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Mass Grant</title>
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

                function error($msg){
                    echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                }
                function success($msg){
                    echo '<p class="success" style="text-align:center;"><img src="images/icons/accept.png" alt="error"/> '.$msg.'</p>';
                }

                include("includes/db_connect.php");

                $getmaxsid = mysql_query("SELECT MAX(scouts.sid) AS msid FROM scouts
                    WHERE scouts.sid NOT IN (SELECT sid FROM badge_tracker WHERE bid=".$bid.")");
                $maxsid = mysql_fetch_array($getmaxsid);
            ?>
            <div class="content">
                <h2>Mass Grant</h2>
                <?php
                    if(isset($_POST['submit'])){
                        //get checked scouts
                        for($i=0; $i<=$maxsid['msid']; $i++){
                            if(isset($_POST[$i])){
                                if($_POST[$i] == "on"){
                                    //submit entry
                                    mysql_query("INSERT INTO badge_tracker (bid, sid, percent, complete) VALUES (".$bid.",".$i.", 100, 'yes')") or die(mysql_error());
                                    mysql_query("UPDATE scouts SET badges=badges+1 WHERE sid=".$i) or die(mysql_error());
                                }
                            }
                        }
                        //RETURN SUCCESS AND EXPLAIN WHERE YOU CAN SEE THE GRANTED BADGE
                        //header("Location: badges.php?type=All");
                        echo "<script type=\"text/javascript\">document.location.href='badges.php?type=All'</script>";
                        //success("Badges granted to selected Scouts");
                        //echo "<span class=\"hint\">You can now see the completed badge in each of the Scouts profiles</span>";
                    }
                ?>
                <br><br>
                <center>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?bid=<?php echo $bid; ?>">
                    <table style="width:300px;">
                    <?php
                            //get list of scouts already not attending
                            $getscoutsnot = mysql_query("SELECT scouts.sid, CONCAT(scouts.firstname, ' ', scouts.lastname) AS name FROM scouts
                                WHERE scouts.sid NOT IN (SELECT sid FROM badge_tracker WHERE bid=".$bid.")");
                            while($scoutsnot = mysql_fetch_array($getscoutsnot)){
                                /*$getnames = mysql_query("SELECT sid, CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE sid=".$scoutsnot['sid']);
                                $names = mysql_fetch_array($getnames);*/

                                echo "<tr><td>".$scoutsnot['name']."</td><td style=\"text-align:center;\"><input type=\"checkbox\" name=\"".$scoutsnot['sid']."\" /></td></tr>";
                            }

                            //output list with checkboxes

                            //get sids of scouts who were checked and add new row to event_attend with eid and sid
                            //return to event page
                    ?>
                    </table><br>
                    <input type="submit" name="submit" value="Grant" class="button" style="margin-left:20px;" />
                </form>
                </center>
            </div>
        </div>
    </body>
</html>
