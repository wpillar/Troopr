<?php
    //Start session and setup variables
    session_start();
    $_SESSION['loggedin'] = 0;
    $_SESSION['username'] = "";
    $_SESSION['type'] = "";
    $_SESSION['email'] = "";
    $url = $_GET['redirect'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("includes/meta.php") ?>
        <title>Troopr - Login</title>
    </head>
    <body>
        <div class="login">
        <img src="images/troopr2.png" alt="troopr logo" style="padding-bottom: 5px;" /><br>
        <?php
            //Print error
            function error($msg){
                echo '<p class="error"><img src="images/icons/cancel.png" alt="error" /> '.$msg.'</p>';
            }
        ?>
        <?php
        
        if(isset($_POST['login'])){
            include("includes/db_connect.php"); //connect to database

            $username = mysql_real_escape_string($_POST['username']); //Fetch user input
            $password = mysql_real_escape_string(md5($_POST['password'])); //Fetch user input

            //Find users with given user/pass, count number of rows.
            $result = mysql_query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'");
            $row = mysql_fetch_array($result);
            $rownum = mysql_num_rows($result);

            //If a user was found
            if($rownum != 0){
                $_SESSION['loggedin'] = 1; //Set loggedin to true
                $_SESSION['username'] = $username; //Pass username to session variable
                $_SESSION['type'] = $row['type'];
                $_SESSION['email'] = $row['email'];

                mysql_query("INSERT INTO access_logs (username, type) VALUES ('".$username."', 'login')"); //Update lots
                mysql_close($conn);
                //header("Location: ".$url); //Re-direct to index page
                echo "<script type=\"text/javascript\">document.location.href='".$url."'</script> ";
            }
            else{
                $_SESSION['loggedin'] = 0;
                error("Incorrect Username/Password"); //If incorrect login details, print error
            }

         }

        ?>
        <form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF']."?redirect=".$url ?>">
            <label for="username">Username:</label><input type="text" name="username" class="box" value="" /><br>
            <label for="password">Password:</label><input type="password" name="password" class="box" value="" /><br>
            <input type="submit" name="login" class="button" value="Login" />
        </form>
        </div>
    </body>
</html>
