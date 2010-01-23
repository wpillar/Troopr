<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Patrols</title>
        <?php include("includes/meta.php") ?>

        <style type="text/css">

</style>

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
                <?php include("includes/messages.php") ?>
                <h2>Patrols</h2>
                <div class="submenu">
                    <img src="<?php echo URL; ?>images/icons/group_add.png" alt="add patrol" /> <a href="addpatrol.php" class="info">Add Patrol<span>Add a new Patrol</span></a> |
                    <img src="<?php echo URL; ?>images/icons/group_link.png" alt="assign scouts" /> <a href="assignscouts.php" class="info">Assign Scouts<span>Assign Scouts to Patrols</span></a></div>
                    <br>
                    <?php
                        if(isset($_GET['del']) == "true")
                            success("Patrol successfully delete, Scouts need to be re-assigned!")
                    ?>
                    <div id="patrolspage">
                        <ul class="patrols">
                        <?php
                            include("includes/db_connect.php");

                            //$assigns = mysql_query("SELECT * FROM patrols_scouts");
                            $patrols = mysql_query("SELECT * FROM patrols");


                                while($prow = mysql_fetch_array($patrols)){
                                    echo "<li><span class=\"pname\">".ucwords($prow['name'])."</span> 
                                        <span style=\"font-size:11pt;\"><a href=\"functions/deletepatrol.php?pid=".$prow['pid']."\" style=\"text-decoration:none;\" class=\"info\"><img src=\"images/icons/delete.png\" alt=\"Delete Patrol\" /><span>Delete this Patrol</span></a></span><br>";
                                    $assigns = mysql_query("SELECT * FROM patrols_scouts WHERE pid=".$prow['pid']);
                                    while($arow = mysql_fetch_array($assigns)){
                                        $scout = mysql_query("SELECT firstname, lastname FROM scouts WHERE sid =".$arow['sid']);
                                        while($srow = mysql_fetch_array($scout)){
                                            echo "<a href=\"functions/deletescout.php?sid=".$arow['sid']."&tbl=patrols_scouts\" class=\"info\">
                                                    <img src=\"images/icons/delete.png\" alt=\"Delete Patrol\" width=\"10px\" /></a> ";
                                            echo "<a href=\"scoutprofile.php?sid=".$arow['sid']."\" class=\"info\">";
                                            echo $srow['firstname']." ".$srow['lastname'];
                                            echo "<span>Goto Scout's profile</span></a>";
                                            if($arow['rank'] == "PL" || $arow['rank'] == "APL"){
                                                echo "<span style=\"color:#888\"> ".$arow['rank']."</span>";
                                            }
                                            echo "<br>";
                                            
                                        }
                                    }
                                }
                                echo "</li>";    
                        ?>
                        </ul>
                    </div>
            </div>
        </div>
    </body>
</html>
