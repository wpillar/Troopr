<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Badge Profile</title>
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

                require("includes/db_connect.php");

                $result = mysql_query("SELECT * FROM badges WHERE bid = ".$_GET['bid']);
                $row = mysql_fetch_array($result);

                $name = $row['name'];
                $url = URL;
            ?>
            <div id="badgeprofile" class="content">
                <h2>Badge Profile - <?php echo $name; ?></h2>
                <div class="submenu">
                    <?php if($_SESSION['type'] ==  "superadmin"){ 
                        echo '<img src="';
                        echo $url;
                        echo 'images/icons/award_star_gold_3.png" /><a href="addbadge.php?bid=';
                        echo $row['bid'];
                        echo '&action=edit">Edit Badge</a> | ';} ?>
                        <img src="<?php echo $url; ?>images/icons/user_green.png" alt="user green" /><a href="viewscouts.php?bid=<?php echo $row['bid']; ?>">View Scouts</a>
                </div>
                <center><img src="<?php echo $row['img']; ?>" alt="badge image" class="badgeimg" /></center>
                <h4>Requirements:</h4>
                <ol class="requirements">
                    <li><p><?php echo $row['req1']; ?></p></li>
                    <?php if($row['req2'] != null){echo '<li><p>'.$row['req2'].'</p></li>';} ?>
                    <?php if($row['req3'] != null){echo '<li><p>'.$row['req3'].'</p></li>';} ?>
                    <?php if($row['req4'] != null){echo '<li><p>'.$row['req4'].'</p></li>';} ?>
                    <?php if($row['req5'] != null){echo '<li><p>'.$row['req5'].'</p></li>';} ?>
                    <?php if($row['req6'] != null){echo '<li><p>'.$row['req6'].'</p></li>';} ?>
                    <?php if($row['req7'] != null){echo '<li><p>'.$row['req7'].'</p></li>';} ?>
                    <?php if($row['req8'] != null){echo '<li><p>'.$row['req8'].'</p></li>';} ?>
                    <?php if($row['req9'] != null){echo '<li><p>'.$row['req9'].'</p></li>';} ?>
                    <?php if($row['req10'] != null){echo '<li><p>'.$row['req10'].'</p></li>';} ?>
                    <?php if($row['req11'] != null){echo '<li><p>'.$row['req11'].'</p></li>';} ?>
                    <?php if($row['req12'] != null){echo '<li><p>'.$row['req12'].'</p></li>';} ?>
                    <?php if($row['req13'] != null){echo '<li><p>'.$row['req13'].'</p></li>';} ?>
                    <?php if($row['req14'] != null){echo '<li><p>'.$row['req14'].'</p></li>';} ?>
                    <?php if($row['req15'] != null){echo '<li><p>'.$row['req15'].'</p></li>';} ?>
                </ol>
            </div>
        </div>
    </body>
</html>
