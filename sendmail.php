<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Send Email</title>
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

            ?>
            <div class="content">
                <h2>Send Email</h2>
                <?php
                    if(isset($_GET['mail'])){
                        if($_GET['mail'] == "1"){
                            success("Mail successfully sent!");
                        }
                        else{
                            error($_GET['mail']);
                        }
                    }
                ?>
                <form id="adduser" method="post" action="functions/mailer.php" >
                    <label for="to">To: </label><input name="to" type="text" class="box" value="<?php if(isset($_GET['to'])){ echo $_GET['to']; } ?>" /><br>
                    <label for="sub">Subject: </label><input name="sub" type="text" class="box" value="<?php if(isset($_GET['sub'])){ echo $_GET['sub']; } ?>" /><br>
                    <label for="msg">Message: </label><textarea id="msg" name="msg" cols="50" rows="8"><?php if(isset($_GET['msg'])){ echo $_GET['msg']; } ?></textarea>
                    <input name="send" type="submit" value="Send" class="button" />
                </form>
            </div>
        </div>
    </body>
</html>
