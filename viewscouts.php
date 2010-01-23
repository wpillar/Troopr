<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    $bid = $_GET['bid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Scouts Who Have This Badge</title>
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

                $getbname = mysql_query("SELECT name FROM badges WHERE bid=".$bid);
                $badgename = mysql_fetch_array($getbname);
            ?>
            <div id="viewscouts" class="content">
                <h2>Scouts Associated with: <?php echo $badgename['name']; ?></h2>
                <br>
                <h3>Scouts Completed</h3>
                <?php
                    //use sids to get names
                    $getscouts = mysql_query("SELECT sid FROM badge_tracker WHERE bid=".$bid." AND percent=100");
                    $rownum = mysql_num_rows($getscouts);
                    if($rownum != 0){
                        while($scouts = mysql_fetch_array($getscouts)){
                            $getnames = mysql_query("SELECT sid, CONCAT(firstname,' ', lastname) AS name FROM scouts WHERE sid=".$scouts['sid']);
                            $names = mysql_fetch_array($getnames);
                            echo "<a href=\"scoutprofile.php?sid=".$names['sid']."\">".$names['name']."</a><br>";
                        }
                    }
                    else{
                        echo "<span class=\"hint\">No Scouts have completed this badge</span>";
                    }
                ?>
                <br><br>
                <h3>Scouts Working Towards</h3>
                <?php
                    //use sids to get names
                    $getscouts = mysql_query("SELECT sid FROM badge_tracker WHERE bid=".$bid." AND percent!=100");
                    $rownum = mysql_num_rows($getscouts);
                    if($rownum != 0){
                        while($scouts = mysql_fetch_array($getscouts)){
                            $getnames = mysql_query("SELECT sid, CONCAT(firstname,' ', lastname) AS name FROM scouts WHERE sid=".$scouts['sid']);
                            $names = mysql_fetch_array($getnames);
                            echo "<a href=\"scoutprofile.php?sid=".$names['sid']."\">".$names['name']."</a><br>";
                        }
                    }
                    else{
                        echo "<span class=\"hint\">No Scouts are working towards this badge</span>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>
