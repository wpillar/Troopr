<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    $uid = $_GET['uid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Edit User</title>
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

                include("includes/db_connect.php");

                $getuser = mysql_query("SELECT * FROM users WHERE uid=".$uid);
                $user = mysql_fetch_array($getuser);

                $username = $user['username'];
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $email = $user['email'];             

            ?>
            <div class="content">
                <h2>Edit User</h2>
                <?php
                    if(isset($_POST['save'])){
                        //CHECK FOR NULLS
                        if($_POST['username'] != null && $_POST['firstname'] != null && $_POST['lastname'] != null && $_POST['email'] != null){
                            //RUN UPDATE
                            mysql_query("UPDATE users SET username='".$_POST['username']."', firstname='".$_POST['firstname']."',
                                lastname='".$_POST['lastname']."', email='".$_POST['email']."' WHERE uid=".$uid) or die(mysql_error());
                            //RE-DIRECT TO users.php
                            //header("Location: users.php");
                            echo "<script type=\"text/javascript\">document.location.href='users.php'</script>";
                        }
                        else{
                            error("You did not complete all the required fields");
                        }

                    }
                ?>
                <br>
                <form id="adduser" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?uid=<?php echo $uid; ?>">
                    <label for="username">Username:</label><input name="username" type="text" class="box" value="<?php echo $username; ?>" /><span class="required">*</span><span class="hint">Enter desired Username</span><br>
                    <label for="firstname">First Name:</label><input name="firstname" type="text" class="box" value="<?php echo $firstname; ?>" /><span class="required">*</span><span class="hint">Enter the user's First Name</span><br>
                    <label for="lastname">Last Name:</label><input name="lastname" type="text" class="box" value="<?php echo $lastname; ?>" /><span class="required">*</span><span class="hint">Enter the user's Last Name</span><br>
                    <label for="email">Email:</label><input name="email" type="text" class="box" value="<?php echo $email; ?>" /><span class="required">*</span><span class="hint">Enter the user's Email address</span><br>
                    <input name="save" type="submit" class="button" value="Save"/>
                </form>
            </div>
        </div>
    </body>
</html>
