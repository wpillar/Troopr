<?php
    $url = PageURL();
    include("includes/check_login.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Add Patrol</title>
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
                <h2>Add Patrol</h2>
                <span class="required">*required field</span>
                <br><br>
                <?php
                    function error($msg){
                        echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                    }

                    function success($msg){
                        echo '<p class="success" style="text-align:center;"><img src="images/icons/accept.png" alt="error"/> '.$msg.'</p>';
                    }

                    if(isset($_POST['save'])){

                        include("includes/db_connect.php");
                        //GET DATA
                        $pname = mysql_real_escape_string($_POST['patrolname']);
                        
                        //CHECK FOR NULL ENTRIES
                        if($pname != null){                           

                            mysql_query("INSERT INTO patrols (name) VALUES ('".$pname."')") or die(error(mysql_error()));
                            mysql_query("INSERT INTO activity_logs (username, action, datetime) VALUES ('".$_SESSION['username']."', 'Added Patrol (".$pname.")', '".date("Y-m-d - H:i:s")."')") or die (error(mysql_error()));

                            success("Patrol successfully added");
                        }
                        else {
                            error("You did not complete the required fields");
                        }
                    }

                ?>
                    <form id="changepass" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <label for="patrolname">Patrol Name:</label><input class="box" type="text" name="patrolname"/><span class="required">*</span><span class="hint">Enter the Patrol's name</span><br>
                        <input type="submit" class="button" name="save" value="Save" />
                    </form>
            </div>
        </div>
    </body>
</html>
