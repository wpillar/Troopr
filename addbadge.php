<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Add Badge</title>
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
                <h2>Add Badge</h2>
                <span class="required">* required field</span>
                <br>
                <?php
                    if(isset($_POST['save'])){

                        include("includes/db_connect.php");
                        //GET VALUES
                        $name = mysql_real_escape_string($_POST['name']);
                        $img = mysql_real_escape_string($_POST['img']);
                        $type = mysql_real_escape_string($_POST['type']);
                        $req1 = mysql_real_escape_string($_POST['req1']);
                        $req2 = mysql_real_escape_string($_POST['req2']);
                        $req3 = mysql_real_escape_string($_POST['req3']);
                        $req4 = mysql_real_escape_string($_POST['req4']);
                        $req5 = mysql_real_escape_string($_POST['req5']);
                        $req6 = mysql_real_escape_string($_POST['req6']);
                        $req7 = mysql_real_escape_string($_POST['req7']);
                        $req8 = mysql_real_escape_string($_POST['req8']);
                        $req9 = mysql_real_escape_string($_POST['req9']);
                        $req10 = mysql_real_escape_string($_POST['req10']);
                        $req11 = mysql_real_escape_string($_POST['req11']);
                        $req12 = mysql_real_escape_string($_POST['req12']);
                        $req13 = mysql_real_escape_string($_POST['req13']);
                        $req14 = mysql_real_escape_string($_POST['req14']);
                        $req15 = mysql_real_escape_string($_POST['req15']);

                        function error($msg){
                            echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                        }

                        //CHECK NULL VALUES
                        if($name != null && $img != null && $type != null && $req1 != null){

                            $url = URL;

                            mysql_query("INSERT INTO badges (name, img, type, req1, req2, req3, req4, req5,
                                req6, req7, req8, req9, req10, req11, req12, req13, req14, req15)
                                VALUES ('".$name."', 'images/badges/".$img."', '".$type."', '".$req1."', '".$req2."', '".$req3."',
                                    '".$req4."', '".$req5."', '".$req6."', '".$req7."', '".$req8."', '".$req9."', '".$req10."',
                                        '".$req11."', '".$req12."', '".$req13."', '".$req14."', '".$req15."')") or die(mysql_error());

                            mysql_close($conn);
                            //header("Location: badges.php?type=All");
                            echo "<script type=\"text/javascript\">document.location.href='badges.php?type=All'</script>";
                        }
                        else{
                            error("You have not completed all the required fields");
                        }
                    }
                ?>
                <br>
                <form id="addbadge" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="name">Badge Name:</label><input name="name" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['name'];}?>" /><span class="required">*</span><span class="hint">Enter badge name</span><br>
                    <label for="img">Image Name:</label><input name="img" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['img'];}?>" /><span class="required">*</span><span class="hint">Enter image filename (must be stored in /images)</span>
                    <label for="type">Type:</label>
                    <select name="type" class="box">
                        <option value="Activity" >Activity</option>
                        <option value="Challenge" >Challenge</option>
                    </select>
                    <span class="required">*</span><span class="hint">Select the badge type</span><br>
                    <label for="req1">Requirement 1:</label><textarea rows="4" cols="40" name="req1"></textarea><span class="required">*</span><span class="hint">Enter the 1st requirement</span>
                    <label for="req2">Requirement 2:</label><textarea rows="4" cols="40" name="req2"></textarea><span class="hint">Enter the 2nd requirement</span>
                    <label for="req3">Requirement 3:</label><textarea rows="4" cols="40" name="req3"></textarea><span class="hint">Enter the 3rd requirement</span>
                    <label for="req4">Requirement 4:</label><textarea rows="4" cols="40" name="req4"></textarea><span class="hint">Enter the 4th requirement</span>
                    <label for="req5">Requirement 5:</label><textarea rows="4" cols="40" name="req5"></textarea><span class="hint">Enter the 5th requirement</span>
                    <label for="req6">Requirement 6:</label><textarea rows="4" cols="40" name="req6"></textarea><span class="hint">Enter the 6th requirement</span>
                    <label for="req7">Requirement 7:</label><textarea rows="4" cols="40" name="req7"></textarea><span class="hint">Enter the 7th requirement</span>
                    <label for="req8">Requirement 8:</label><textarea rows="4" cols="40" name="req8"></textarea><span class="hint">Enter the 8th requirement</span>
                    <label for="req9">Requirement 9:</label><textarea rows="4" cols="40" name="req9"></textarea><span class="hint">Enter the 9th requirement</span>
                    <label for="req10">Requirement 10:</label><textarea rows="4" cols="40" name="req10"></textarea><span class="hint">Enter the 10th requirement</span>
                    <label for="req11">Requirement 11:</label><textarea rows="4" cols="40" name="req11"></textarea><span class="hint">Enter the 11th requirement</span>
                    <label for="req12">Requirement 12:</label><textarea rows="4" cols="40" name="req12"></textarea><span class="hint">Enter the 12th requirement</span>
                    <label for="req13">Requirement 13:</label><textarea rows="4" cols="40" name="req13"></textarea><span class="hint">Enter the 13th requirement</span>
                    <label for="req14">Requirement 14:</label><textarea rows="4" cols="40" name="req14"></textarea><span class="hint">Enter the 14th requirement</span>
                    <label for="req15">Requirement 15:</label><textarea rows="4" cols="40" name="req15"></textarea><span class="hint">Enter the 15th requirement</span><br>
                    <input type="submit" name="save" class="button" value="Save" />
                </form>
            </div>
        </div>
    </body>
</html>
