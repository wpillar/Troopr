<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    $bid = $_GET['bid'];
    $sid = $_GET['sid'];

    if(isset($_GET['action'])=="start"){
        header("Location: functions/assignbadge.php?bid=".$bid."&sid=".$sid);
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Update Completed Requirements</title>
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
            ?>
            <div class="content">
                <h2>Update Completed Requirements</h2>
                <?php
                    include("includes/db_connect.php");

                    if(isset($_POST['submit'])){     
                        if(@$_POST['req1']=='on'){@$req1 = "yes";}else{@$req1 = null;}
                        if(@$_POST['req2']=='on'){@$req2 = "yes";}else{@$req2 = null;}
                        if(@$_POST['req3']=='on'){@$req3 = "yes";}else{@$req3 = null;}
                        if(@$_POST['req4']=='on'){@$req4 = "yes";}else{@$req4 = null;}
                        if(@$_POST['req5']=='on'){@$req5 = "yes";}else{@$req5 = null;}
                        if(@$_POST['req6']=='on'){@$req6 = "yes";}else{@$req6 = null;}
                        if(@$_POST['req7']=='on'){@$req7 = "yes";}else{@$req7 = null;}
                        if(@$_POST['req8']=='on'){@$req8 = "yes";}else{@$req8 = null;}
                        if(@$_POST['req9']=='on'){@$req9 = "yes";}else{@$req9 = null;}
                        if(@$_POST['req10']=='on'){@$req10 = "yes";}else{@$req10 = null;}
                        if(@$_POST['req11']=='on'){@$req11 = "yes";}else{@$req11 = null;}
                        if(@$_POST['req12']=='on'){@$req12 = "yes";}else{@$req12 = null;}
                        if(@$_POST['req13']=='on'){@$req13 = "yes";}else{@$req13 = null;}
                        if(@$_POST['req14']=='on'){@$req14 = "yes";}else{@$req14 = null;}
                        if(@$_POST['req15']=='on'){@$req15 = "yes";}else{@$req15 = null;}

                        if($req1 == null && $req2 == null && $req3 == null && $req4 == null && $req5 == null && $req6 == null && $req7 == null && $req8 == null &&
                                $req9 == null && $req10 == null && $req11 == null && $req12 == null && $req13 == null && $req14 == null && $req15 == null){
                            mysql_query("DELETE FROM badge_tracker WHERE bid=".$bid." AND sid=".$sid) or die(mysql_error());
                            error("This Scout has now completed NO requirements");
                        }
                        else{

                            //UPDATE TRACKER TABLE
                            mysql_query("UPDATE badge_tracker SET req1='".$req1."', req2='".$req2."', req3='".$req3."', req4='".$req4."',
                                req5='".$req5."', req6='".$req6."', req7='".$req7."', req8='".$req8."', req9='".$req9."', req10='".$req10."',
                                    req11='".$req11."', req12='".$req12."', req13='".$req13."', req14='".$req14."', req15='".$req15."'
                                        WHERE bid=".$bid." AND sid=".$sid) or die(mysql_error());

                             //RUN count.php AND UPDATE PERCENTAGES
                            include("count.php");
                            $gettid = mysql_query("SELECT tid FROM badge_tracker WHERE bid=".$bid." AND sid=".$sid);
                            $tids = mysql_fetch_array($gettid);
                            $percent = GetPercent($tids['tid']); //Get percentage completion

                            //UPDATE PERCENTAGE
                            mysql_query("UPDATE badge_tracker SET percent=".$percent." WHERE bid=".$bid." AND sid=".$sid) or die(mysql_error());

                            //UPDATE STATS IF BADGE IS COMPLETED
                            if($percent == 100){
                                mysql_query("UPDATE scouts SET badges=badges+1 WHERE sid=".$sid) or die(mysql_error());
                                mysql_query("UPDATE badge_tracker SET complete='yes' WHERE bid=".$bid." AND sid=".$sid) or die(mysql_error());
                            }
                            else{
                                mysql_query("UPDATE badge_tracker SET complete='no' WHERE bid=".$bid." AND sid=".$sid) or die(mysql_error());
                            }

                            success("Completed Requirements updated!");
                        }
                    }
                    
                    $badge = mysql_query("SELECT * FROM badges WHERE bid =".$bid);
                    $scout = mysql_query("SELECT firstname, lastname FROM scouts WHERE sid =".$sid);

                    $rowb = mysql_fetch_array($badge);
                    $rows = mysql_fetch_array($scout);

                    $scoutname = $rows['firstname']." ".$rows['lastname'];

                    $badgename = $rowb['name'];
                    $badgetype = $rowb['type'];
                    $badgeimg = $rowb['img'];
                ?>
                <div id="scoutdetails">
                    <br><br><br><br>
                    <h3>Scout Name: </h3><span style="font-size: 16pt;"><a href="scoutprofile.php?sid=<?php echo $sid;?>"><?php echo $scoutname;?></a></span>
                </div>
                <div id="badgedetails">
                    <img src="<?php echo $badgeimg; ?>" alt="<?php echo $badgename; ?>" /><br>
                    <h3>Badge Name: </h3><span style="font-size: 14pt;"><?php echo $badgename; ?></span><br>
                    <h3>Badge Type: </h3><span style="font-size: 14pt;"><?php echo $badgetype; ?></span><br>
                </div>
                <br>
                <div id="reqsform">
                    <?php
                        $getvalues = mysql_query("SELECT * FROM badge_tracker WHERE bid=".$bid." AND sid=".$sid);
                        $reqvalues = mysql_fetch_array($getvalues);
                        $rownum = mysql_num_rows($getvalues);

                        if($rownum == 0){
                            echo "<br><h4>This Scout hasn't started this badge!
                                <a href=\"functions/assignbadge.php?bid=".$bid."&sid=".$sid."\" class=\"info\">Start Now?
                                <span>Start this badge with this Scout</span></a></h4><br><br><br><br>";
                        }
                        else{
                    ?>
                    <form id="compreqs" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?bid=<?php echo $bid;?>&sid=<?php echo $sid;?>">
                        <table>
                            <tr>
                                <th>Requirement</th>
                                <th>Complete?</th>
                            </tr>
                            <?php                                
                                    $getbadges = mysql_query("SELECT * FROM badges WHERE bid =".$bid);
                                    while($brow = mysql_fetch_array($getbadges)){

                                        echo "<tr>";
                                        if($brow['req1']!=null){
                                            echo "<td>".$brow['req1']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req1\"";
                                            if($reqvalues['req1']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req2']!=null){
                                            echo "<td>".$brow['req2']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req2\"";
                                            if($reqvalues['req2']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req3']!=null){
                                            echo "<td>".$brow['req3']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req3\"";
                                            if($reqvalues['req3']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req4']!=null){
                                            echo "<td>".$brow['req4']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req4\"";
                                            if($reqvalues['req4']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req5']!=null){
                                            echo "<td>".$brow['req5']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req5\"";
                                            if($reqvalues['req5']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req6']!=null){
                                            echo "<td>".$brow['req6']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req6\"";
                                            if($reqvalues['req6']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req7']!=null){
                                            echo "<td>".$brow['req7']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req7\"";
                                            if($reqvalues['req7']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req8']!=null){
                                            echo "<td>".$brow['req8']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req8\"";
                                            if($reqvalues['req8']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req9']!=null){
                                            echo "<td>".$brow['req9']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req9\"";
                                            if($reqvalues['req9']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req10']!=null){
                                            echo "<td>".$brow['req10']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req10\"";
                                            if($reqvalues['req10']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req11']!=null){
                                            echo "<td>".$brow['req11']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req11\"";
                                            if($reqvalues['req11']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req12']!=null){
                                            echo "<td>".$brow['req12']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req12\"";
                                            if($reqvalues['req12']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req13']!=null){
                                            echo "<td>".$brow['req13']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req13\"";
                                            if($reqvalues['req13']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req14']!=null){
                                            echo "<td>".$brow['req14']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req14\"";
                                            if($reqvalues['req14']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";

                                        echo "<tr>";
                                        if($brow['req15']!=null){
                                            echo "<td>".$brow['req15']."</td>
                                            <td style=\"text-align:center;\"><input type=\"checkbox\" name=\"req15\"";
                                            if($reqvalues['req15']=="yes"){echo"checked=\"\"";}
                                            echo "/></td>";}
                                        echo "</tr>";
                                    }
                            ?>
                        </table>
                        <br>
                        <input type="submit" name="submit" value="Submit" class="button" />
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>
