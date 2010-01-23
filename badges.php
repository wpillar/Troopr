<?php
    $url = PageURL()."?type=All";
    include("includes/check_login.php");

    if(isset($_GET['action']) != "choose"){
        if(isset($_GET['sid'])){$sid = $_GET['sid'];}
        if(isset($_GET['sid'])){$bid = $_GET['bid'];}
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Badges</title>
        <?php include("includes/meta.php") ?>
    </head>
    <body>
        <div class="container">
            <?php
                include("includes/header.php");
                include("includes/nav.php");
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
                <h2>Badges</h2>
                <?php if(isset($_GET['action']) != "choose"){ ?>
                <span class="intro">Below are the badges in our database, click the badge image to see details about the badge.</span>
                <?php }else{ ?>
                <span class="intro" style="font-size: 14pt;">Choose a badge for the Scout to start by clicking on its image.</span>
                <?php } ?>
                <?php if(isset($_GET['action']) != "choose"){ ?>
                <div class="submenu">
                    <img src="<?php echo URL; ?>images/icons/asterisk_yellow.png" alt="all badges" /><a href="badges.php?type=All">All Badges</a> |
                    <img src="<?php echo URL; ?>images/icons/sport_soccer.png" alt="activity badges" /><a href="badges.php?type=Activity">Activity Badges</a> |
                    <img src="<?php echo URL; ?>images/icons/shield.png" alt="challenge badges" /><a href="badges.php?type=Challenge">Challenge Badges</a>
                </div>
                <?php } ?>
                <table id="badges">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Grant</th>
                        <?php if($_SESSION['type'] == 'superadmin'){ echo '<th>Edit</th>';}?>
                        <?php if($_SESSION['type'] == 'superadmin'){ echo '<th>Delete</th>';}?>
                    </tr>
                <?php
                    require("includes/db_connect.php");

                    $type = $_GET['type'];

                    if($type == "Activity"){
                         $result = mysql_query("SELECT * FROM badges WHERE type='".$type."' ORDER BY name ASC");
                    }
                    else if($type == "Challenge"){
                         $result = mysql_query("SELECT * FROM badges WHERE type='".$type."' ORDER BY name ASC");
                    }
                    else if($type == "All" && @$_GET['action'] != "choose"){
                         $result = mysql_query("SELECT * FROM badges ORDER BY name ASC");
                    }
                    else if($type == "All" && @$_GET['action'] == "choose"){
                         $result = mysql_query("SELECT * FROM badges ORDER BY name ASC");
                    }

                    while($row = mysql_fetch_array($result)){
                        if(isset($_GET['action'])!= "choose"){echo '<tr><td><center><a href="badgeprofile.php?bid='.$row['bid'].'">';}
                        else{echo '<tr><td><center><a href="reqs.php?bid='.$row['bid'].'&sid='.$_GET['sid'].'&action=start">';}
                        echo '<img src="'.$row['img'].'" alt="'.$row['name'].'" width="39px" /></a></center></td><td>'.$row['name'].'</td><td>'.$row['type'].'</td>';
                        echo '<td><a href="massgrant.php?bid='.$row['bid'].'">Mass Grant</a></td>';
                        if($_SESSION['type'] == 'superadmin'){echo '<td><a href="editbadge.php?bid='.$row['bid'].'&action=edit">Edit</a></td>';}
                        if($_SESSION['type'] == 'superadmin'){echo '<td><a href="functions/deletebadge.php?uid='.$row['bid'].'&username='.$row['name'].'">Delete</a></td>';}
                        echo '</tr>';
                    }

                    mysql_close($conn);
                    
                ?>
                </table>
                <br>
            </div>
        </div>
    </body>
</html>