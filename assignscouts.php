<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Assign Scouts</title>
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
                <h2>Assign Scouts to Patrols</h2>
                <?php
                    //SUBMIT DATA HERE
                    if(isset($_POST['save'])){
                        include("includes/db_connect.php");

                        mysql_query("INSERT INTO patrols_scouts (pid, sid, rank) VALUES (".$_POST['pid'].",".$_POST['sid'].",'".$_POST['rank']."')") or die(error(mysql_error()));
                        mysql_query("UPDATE scouts SET assigned='yes' WHERE sid=".$_POST['sid']."");
                        mysql_query("UPDATE patrols SET num=num+1 WHERE pid =".$_POST['pid']);
                        success("Scout successfully assigned!");
                    }
                    function error($msg){
                        echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                    }

                    function success($msg){
                        echo '<p class="success" style="text-align:center;"><img src="images/icons/accept.png" alt="error"/> '.$msg.'</p>';
                    }
                            include("includes/db_connect.php");

                    $result = mysql_query("SELECT sid, firstname, lastname FROM scouts WHERE assigned = 'no'");
                    $rownum = mysql_num_rows($result);

                    if($rownum != 0){
                ?>
                <form id="assignscouts" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="scoutlist">
                        <h3>Scouts</h3>
                        <span class="hint">Select a Scout to assign and their rank.</span><br>
                        <span class="dropdown">
                        <select id="scouts" name="sid" >
                            <?php
                                while($row = mysql_fetch_array($result)){
                                    echo "<option value=\"".$row['sid']."\">".$row['firstname']." ".$row['lastname']."</option>";
                                }
                            ?>
                        </select>
                        <select id="rank" name="rank">
                            <option value="Scout">Scout</option>
                            <option value="PL">PL</option>
                            <option value="APL">APL</option>                            
                        </select>
                        </span>
                    </div>
                    <div class="patrollist">
                        <h3>Patrols</h3>
                        <span class="hint">Select a Patrol to assign them too.</span><br>
                        <span class="dropdown">
                        <select name="pid" id="patrols">
                            <?php
                                $result = mysql_query("SELECT pid, name FROM patrols");

                                while($row = mysql_fetch_array($result)){
                                    echo "<option value=\"".$row['pid']."\">".ucwords($row['name'])."</option>";
                                }
                            ?>
                        </select>
                        </span>
                    </div>
                    <div class="submit">
                        <input name="save" type="submit" value="Save" class="button" />
                    </div>
                </form>
                <?php
                    }
                    else {
                        error("No more Scouts to assign!");
                    }
                ?>
            </div>
        </div>
    </body>
</html>
