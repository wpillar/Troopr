<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    include("includes/db_connect.php");

    $sid = $_GET['sid'];

    $result = mysql_query("SELECT * FROM scouts WHERE sid = ".$sid);
    $row = mysql_fetch_array($result);

    $firstname = $row['firstname'];
    $lastname = $row['lastname'];

    $dob = explode("-", $row['dob']);
    $datejoined = explode("-", $row['datejoined']);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Scout Profile</title>
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
            <div id="scoutprofile" class="content">
                <h2><?php echo $firstname." ".$lastname; ?></h2>
                <div class="submenu">
                    <img src="images/icons/user_edit.png" alt="edit scout" /> <a href="editscout.php?sid=<?php echo $sid; ?>">Edit Scout</a>
                    | <img src="images/icons/package_go.png" alt="start badge" /> <a href="badges.php?type=All&action=choose&sid=<?php echo $sid; ?>">Start Badge</a>
                    | <img src="images/icons/email.png" alt="email" /> <a href="sendmail.php?to=<?php

                                                                            $to = mysql_query("SELECT p1email FROM scouts WHERE sid=".$sid);

                                                                            while($tto = mysql_fetch_array($to)){
                                                                                echo $tto['p1email'];
                                                                            }
                                                                          ?>">Email Parent</a>
                </div>
                <div class="scout_profile">
                        <span class="scout_label">Date of Birth: </span><?php echo $dob[2]."/".$dob[1]."/".$dob[0] ?><br>
                        <span class="scout_label">Gender: </span><?php echo ucwords($row['gender']); ?><br>
                        <span class="scout_label">Religion: </span><?php  echo ucwords($row['religion']); ?><br>
                        <span class="scout_label">School: </span><?php echo ucwords($row['school']); ?> <br>
                        <span class="scout_label">Date Joined: </span><?php echo $datejoined[2]."/".$datejoined[1]."/".$datejoined[0] ?><br>
                    <h3>Parent/Carer Details</h3>
                    <div id="person1">
                        <h4>Person 1</h4>
                        <span class="scout_label">Name: </span><?php echo ucwords($row['p1firstname']." ".ucwords($row['p1lastname'])); ?><br>
                        <span class="scout_label">Address 1: </span><?php echo ucwords($row['p1address1']); ?><br>
                        <span class="scout_label">Address 2: </span><?php echo ucwords($row['p1address2']); ?><br>
                        <?php if($row['p1address3'] != null){echo "<span class=\"scout_label\">Address 3: </span>".ucwords($row['p1address3'])."<br>";} ?>
                        <span class="scout_label">Postcode: </span><?php echo strtoupper($row['p1postcode']); ?><br>
                        <span class="scout_label">Home Tel: </span><?php echo $row['p1hometel']; ?><br>
                        <span class="scout_label">Mobile: </span><?php echo $row['p1mobile']; ?><br>
                        <span class="scout_label">Email: </span><?php echo $row['p1email']; ?><br>
                    </div>
                    <div id="person2">
                        <?php if($row['p2firstname'] != null){ ?>
                        <h4>Person 2</h4>
                        <span class="scout_label">Name: </span><?php echo ucwords($row['p2firstname']." ".ucwords($row['p2lastname'])); ?><br>
                        <span class="scout_label">Address 1: </span><?php echo ucwords($row['p2address1']); ?><br>
                        <span class="scout_label">Address 2: </span><?php echo ucwords($row['p2address2']); ?><br>
                        <?php if($row['p2address3'] != null){echo "<span class=\"scout_label\">Address 3: </span>".ucwords($row['p2address3'])."<br>";} ?>
                        <span class="scout_label">Postcode: </span><?php echo strtoupper($row['p2postcode']); ?><br>
                        <span class="scout_label">Home Tel: </span><?php echo $row['p2hometel']; ?><br>
                        <span class="scout_label">Mobile: </span><?php echo $row['p2mobile']; ?><br>
                        <span class="scout_label">Email: </span><?php echo $row['p2email']; ?><br>
                        <?php } ?>
                    </div>
                    <br>
                    <div id="altcontact" class="scout_profile">
                        <?php if($row['altcontact'] != null){ ?>
                        <h3>Alternative Contact</h3>
                        <span class="scout_label">Name: </span><?php echo ucwords($row['altcontact']); ?><br>
                        <span class="scout_label">Relationship: </span><?php echo ucwords($row['altrelation']); ?><br>
                        <span class="scout_label">Address: </span><?php echo $row['altaddress']; ?><br>
                        <span class="scout_label">Tel: </span><?php echo $row['alttel']; ?>
                        <?php } ?>
                    </div>
                    <div id="requirements" class="scout_profile">
                        <?php if($row['dietreq'] != null || $row['medreq'] != null || 
                                $row['relreq'] != null){ ?><h3>Special Requirements</h3><?php } ?>
                        <div style="margin-left: 30px;">
                        <?php if($row['dietreq'] != null){ ?><h4>Dietary</h4>
                        <?php echo $row['dietreq'] ?><br><br><?php } ?>
                        <?php if($row['medreq'] != null){ ?><h4>Medical</h4>
                        <?php echo $row['medreq'] ?><br><br><?php } ?>
                        <?php if($row['relreq'] != null){ ?><h4>Religous</h4>
                        <?php echo $row['relreq'] ?><?php } ?>
                        </div>
                    </div>
                    <div id="hobbies" class="scout_profile">
                        <?php if($row['hobbies'] != null){ ?><h3>Hobbies & Interests</h3>
                        <div style="margin-left: 30px;"><?php echo $row['hobbies']; } ?></div>
                    </div>
                    <div id="sbadges" class="scout_profile">
                        <h3>Badges</h3>
                        <div id="completed">
                             <h4>Completed Badges</h4>
                             <?php
                                $getbid = mysql_query("SELECT bid FROM badge_tracker WHERE sid=".$sid." AND complete='yes'") or die(mysql_error());
                                $rownum = mysql_num_rows($getbid);
                                if($rownum == 0){
                                    echo "<span class=\"hint\">No badges completed yet!</span>";
                                } else {
                             ?>
                             <table>
                                 <tr>
                                     <th>Image</th>
                                     <th>Badge Name</th>
                                 </tr>
                                    <?php
                                            while($row = mysql_fetch_array($getbid)){
                                                $getnames = mysql_query("SELECT name, img FROM badges WHERE bid=".$row['bid']." ORDER BY name ASC") or die(mysql_error());
                                                $nameimg = mysql_fetch_array($getnames);
                                                echo "<tr>";
                                                echo "<td><img src=\"".$nameimg['img']."\" alt=\"badge\" width=50px /></td>";
                                                echo "<td>".$nameimg['name']."<span style=\"margin-left: 15px;\">
                                                    [<a href=\"functions/rembadge_sc.php?bid=".$row['bid']."&sid=".$sid."\">remove</a>]</span></td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                             </table>
                        </div>
                        <div id="worktowards">
                            <h4>Working Towards</h4>
                            <?php
                                $getworking = mysql_query("SELECT bid, percent FROM badge_tracker WHERE sid=".$sid."
                                    AND complete='no' ORDER BY percent DESC") or die(mysql_error());
                                $rownum = mysql_num_rows($getworking);
                                if($rownum == 0){
                                    echo "<span class=\"hint\">Not working towards any badges!</span>";
                                } else {
                             ?>
                            <table>
                                <tr>
                                    <th>Image</th>
                                    <th>Badge Name</th>
                                    <th>Progress</th>
                                    <th>Update</th>
                                </tr>                            
                            <?php
                                            while($row = mysql_fetch_array($getworking)){
                                                $getnames = mysql_query("SELECT name, img FROM badges WHERE bid=".$row['bid']) or die(mysql_error());
                                                $nameimg = mysql_fetch_array($getnames);
                                                if($row['percent']>=0 && $row['percent']<33){$colour="red";}
                                                if($row['percent']>=33 && $row['percent']<66){$colour="#DAD800";}
                                                if($row['percent']>=66 && $row['percent']<=100){$colour="green";}
                                                echo "<tr>";
                                                echo "<td><img src=\"".$nameimg['img']."\" alt=\"badge\" width=50px /></td>";
                                                echo "<td>".$nameimg['name']."</td>";
                                                echo "<td><div style=\"background-color:".$colour.";-moz-border-radius:5px;height:20px;width:".$row['percent']."%\">
                                                    </div><span style=\"color:#888;padding-left:1px;\">".$row['percent']."%</td>";
                                                echo "<td style=\"text-align:center;\"><a href=\"reqs.php?bid=".$row['bid']."&sid=".$sid."\">
                                                    <img src=\"images/icons/table_go.png\" alt=\"Update\" style=\"border:none;\" /></a></td>";
                                                echo "</tr>";
                                            }
                                        }
                            ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
