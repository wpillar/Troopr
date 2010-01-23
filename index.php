<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Dashboard</title>
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
            <div id="dash" class="content">
                <h2>Dashboard</h2>
                <?php //include("includes/adunit.php"); ?>
                <div id="dashtop">
                    <div id="toppatrols">
                        <h3>Top Patrols</h3>
                        <table id="tpatrols">
                            <tr>
                                <th>Name</th>
                                <th>Badges</th>
                            </tr>
                            <?php
                                include("includes/db_connect.php");

                                $getpbadges = mysql_query("SELECT patrols_scouts.pid, SUM(scouts.badges) AS total
                                    FROM scouts, patrols_scouts WHERE scouts.sid = patrols_scouts.sid GROUP BY pid ORDER BY total DESC") or die(mysql_error());

                                while($pbadges = mysql_fetch_array($getpbadges)){
                                    $getpnames = mysql_query("SELECT name FROM patrols WHERE pid=".$pbadges['pid']) or die(mysql_error());
                                    $pname = mysql_fetch_array($getpnames);
                                    echo "<tr>";
                                    echo "<td>".$pname['name']."</td>";
                                    echo "<td>".$pbadges['total']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <div id="topscouts">
                        <h3>Top Scouts</h3>
                        <table id="tscouts" border="1">
                            <tr>
                                <th>Name</th>
                                <th>Badges</th>
                            </tr>
                            <?php
                                $gettscouts = mysql_query("SELECT sid, CONCAT(firstname,' ', lastname) AS name, badges FROM scouts
                                    WHERE badges>0 ORDER BY badges DESC LIMIT 5") or die(mysql_error());

                                while($tscouts = mysql_fetch_array($gettscouts)){
                                    echo "<tr>";
                                    echo "<td><a href=\"scoutprofile.php?sid=".$tscouts['sid']."\" style=\"color:#307ad3;text-decoration:none;\">".$tscouts['name']."</a></td>";
                                    echo "<td>".$tscouts['badges']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <div id="dashbottom">
                    <div id="nearlybadges">
                        <h3>Badges Nearly Earned</h3>
                        <table id="nbadges" border="1">
                            <tr>
                                <th>Scout</th>
                                <th>Badge</th>
                                <th>Percent</th>
                            </tr>
                            <?php
                                $getpercent = mysql_query("SELECT bid, sid, percent FROM badge_tracker WHERE percent>=70 AND percent <=99
                                    ORDER BY percent DESC LIMIT 5") or die(mysql_error());

                                while($pcent = mysql_fetch_array($getpercent)){
                                    $getbname = mysql_query("SELECT name FROM badges WHERE bid=".$pcent['bid']);
                                    $getsname = mysql_query("SELECT sid, CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE sid=".$pcent['sid']);
                                    while($sname = mysql_fetch_array($getsname)){
                                        echo "<tr><td><a href=\"scoutprofile.php?sid=".$sname['sid']."\" style=\"color:#307ad3;text-decoration:none;\">".$sname['name']."</a></td>";
                                    }
                                    while($bname = mysql_fetch_array($getbname)){
                                        echo "<td>".$bname['name']."</td>";
                                    }
                                    echo "<td>".$pcent['percent']."%</td></tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <div id="upcomingev">
                        <h3>Upcoming Events</h3>
                        <?php
                        $getevs = mysql_query("SELECT eid, event_title, event_start FROM calendar_events WHERE event_start > now()
                            AND event_start < now() + INTERVAL 168 HOUR ORDER BY event_start ASC") or die(mysql_error());

                        while($evs = mysql_fetch_array($getevs)){
                            $dsplit = explode("-", $evs['event_start']);
                            $tsplit = explode(" ", $dsplit[2]);
                            $date = $dsplit[1]."/".$tsplit[0]."/".$dsplit[0];
                            $msplit = explode(":", $tsplit[1]);
                            $time = $msplit[0].":".$msplit[1];

                            echo "<div id=\"upevs\"><span style=\"color:#307ad3;\">
                                <a href=\"event.php?eid=".$evs['eid']."\" style=\"color:#307ad3;text-decoration:none;\">".$evs['event_title']."</a></span> -
                                <span style=\"color:#555;\">".$date." - ".$time."</span></div>";
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
