<?php
    $url = PageURL();
    include("includes/check_login.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Change Password</title>
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
                <h2>Change Password</h2>
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
                        $oldpass = md5($_POST['oldpass']);
                        $newpass = md5($_POST['newpass']);
                        $newpassconf = md5($_POST['newpassconf']);
                       
                        //CHECK PASSWORDS MATCH
                        if($oldpass != md5("") && $newpass != md5("") && $newpassconf != md5("")){
                            if($newpass != $newpassconf)
                                error("New passwords do not match");
                            else{
                                include("includes/db_connect.php");
                                //CHECK OLD PASSWORD IS CORRECT
                                $result = mysql_query("SELECT * FROM users WHERE username ='".$_SESSION['username']."'");
                                while($row = mysql_fetch_array($result)){
                                    if($oldpass == $row['password']){
                                        mysql_query("UPDATE users SET password='".$newpass."' WHERE username='".$_SESSION['username']."'") or die(mysql_error);
                                        mysql_query("INSERT INTO activity_logs (username, action, datetime) VALUES ('".$_SESSION['username']."', 'Changed Password', '".date("Y-m-d - H:i:s")."')") or die(error(mysql_error()));
                                        success("Password changed successfully");
                                    }
                                    else{
                                        error("Old Password is incorrect");
                                    }
                                }
                            }
                        }
                        else{
                            //CHECK FOR NULL VALUES
                            if($oldpass == md5(""))
                                error("You did not enter your old password");
                            if($newpass == md5(""))
                                error("You did not enter a new password");
                            if($newpassconf == md5(""))
                                error("You did not re-enter your new password");
                        }

                    }
                ?>
                    <form id="changepass" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <label for="oldpass">Old Password:</label><input class="box" type="password" name="oldpass"/><span class="required">*</span><span class="hint">Enter your curent password</span><br>
                        <hr>
                        <label for="newpass">New Password:</label><input class="box" type="password" name="newpass"/><span class="required">*</span><span class="hint">Enter your new password</span><br>
                        <label for="newpassconf">Re-enter Password:</label><input class="box" type="password" name="newpassconf"/><span class="required">*</span><span class="hint">Re-enter your new password</span><br>
                        <input class="button" type="submit" name="save" value="Save"/>
                    </form>
            </div>
        </div>
    </body>
</html>
