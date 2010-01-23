<?php
    $url = PageURL();
    include("../includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Billing</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/Troopr/style.css"/>
    </head>
    <body>
        <div class="container">
            <?php
                include("../includes/header.php"); //include header div
                include("../includes/nav.php"); //include nav div
                include("../includes/sidebar.php"); //include sidebar

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
                <h2>Billing</h2>
            </div>
        </div>
    </body>
</html>
