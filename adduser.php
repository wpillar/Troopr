<?php
    $url = PageURL();
    include("includes/check_login.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Add User</title>
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
                <h2>Add User</h2>
                <span class="required">* required field</span><br>
                <?php
                    function error($msg){
                        echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                    }
                    function success($msg){
                        echo '<p class="success" style="text-align:center;"><img src="images/icons/accept.png" alt="error"/> '.$msg.'</p>';
                    }

                    if(isset($_POST['save'])){
                    $username = $_POST['username'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $password = md5($_POST['password']);
                    $passwordconf = md5($_POST['passwordconf']);

                    //CHECK FOR NULL ENTRIES
                    if($username != null && $firstname != null && $lastname != null && $email != null && $password != md5("") && $passwordconf != md5("")){
                        
                        include("includes/db_connect.php");

                        //CHECK USERNAME IS FREE
                        $result = mysql_query("SELECT * FROM users WHERE username = '".$username."'");
                        $numrows = mysql_num_rows($result);
                        if($numrows == 0){
                            //CHECK PASSWORDS MATCH
                            if($password == $passwordconf){
                                //SUBMIT DATA
                                mysql_query("INSERT INTO users (username, firstname, lastname, email, password, type) VALUES('".mysql_real_escape_string($username)."', '".mysql_real_escape_string($firstname)."', '".mysql_real_escape_string($lastname)."', '".mysql_real_escape_string($email)."', '".$password."', 'leader')") or die(error(mysql_error()));
                                mysql_query("INSERT INTO activity_logs (username, action, datetime) VALUES ('".$_SESSION['username']."', 'Added user (".$username.")', '".date("Y-m-d - H:i:s")."')") or die(error(mysql_error()));
                                success("User successfully added");
                                //header("Location: users.php");
                                echo "<script type=\"text/javascript\">document.location.href='users.php'</script>";
                            }
                            else{
                                error("Passwords do not match");
                            }
                        }
                        else{
                            error("Username already exists");
                        }          
                    }
                    else{
                        error("You did not complete all fields");
                    }
                }

                ?>
                <br>
                <form id="adduser" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="username">Username:</label><input name="username" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['username'];} ?>" /><span class="required">*</span><span class="hint">Enter desired Username</span><br>
                    <label for="firstname">First Name:</label><input name="firstname" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['firstname'];} ?>" /><span class="required">*</span><span class="hint">Enter the user's First Name</span><br>
                    <label for="lastname">Last Name:</label><input name="lastname" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['lastname'];} ?>" /><span class="required">*</span><span class="hint">Enter the user's Last Name</span><br>
                    <label for="email">Email:</label><input name="email" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['email'];} ?>" /><span class="required">*</span><span class="hint">Enter the user's Email address</span><br>
                    <label for="password">Password:</label><input name="password" type="password" class="box" /><span class="required">*</span><span class="hint">Enter a password</span><br>
                    <label for="passwordconf">Confirm Password:</label><input name="passwordconf" type="password" class="box" /><span class="required">*</span><span class="hint">Re-enter the above password</span><br>
                    <input name="save" type="submit" class="button" value="Save"/>
                </form>
            </div>
        </div>
    </body>
</html>
