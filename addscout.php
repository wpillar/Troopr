<?php
    $url = PageURL();
    include("includes/check_login.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Add Scout</title>
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
                <h2>Add Scout</h2>
                <span class="required">* required field</span><br>
                <?php
                    function error($msg){
                        echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                    }
                    function success($msg){
                        echo '<p class="success" style="text-align:center;"><img src="images/icons/accept.png" alt="error"/> '.$msg.'</p>';
                    }

                    if(isset($_POST['save'])){

                        include("includes/db_connect.php");

                        //GET VALUES FROM FORM
                        $firstname = mysql_real_escape_string($_POST['firstname']);
                        $lastname = mysql_real_escape_string($_POST['lastname']);
                        $dob = mysql_real_escape_string($_POST['dob']);
                        $gender = @mysql_real_escape_string($_POST['gender']);
                        $religion = mysql_real_escape_string($_POST['religion']);
                        $school = mysql_real_escape_string($_POST['school']);
                        $datejoined = mysql_real_escape_string($_POST['datejoined']);

                        $p1firstname = mysql_real_escape_string($_POST['p1firstname']);
                        $p1lastname = mysql_real_escape_string($_POST['p1lastname']);
                        $p1address1 = mysql_real_escape_string($_POST['p1address1']);
                        $p1address2 = mysql_real_escape_string($_POST['p1address2']);
                        $p1address3 = mysql_real_escape_string($_POST['p1address3']);
                        $p1postcode = mysql_real_escape_string($_POST['p1postcode']);
                        $p1hometel = mysql_real_escape_string($_POST['p1hometel']);
                        $p1mobile = mysql_real_escape_string($_POST['p1mobile']);
                        $p1email = mysql_real_escape_string($_POST['p1email']);

                        $p2firstname = mysql_real_escape_string($_POST['p2firstname']);
                        $p2lastname = mysql_real_escape_string($_POST['p2lastname']);
                        $p2address1 = mysql_real_escape_string($_POST['p2address1']);
                        $p2address2 = mysql_real_escape_string($_POST['p2address2']);
                        $p2address3 = mysql_real_escape_string($_POST['p2address3']);
                        $p2postcode = mysql_real_escape_string($_POST['p2postcode']);
                        $p2hometel = mysql_real_escape_string($_POST['p2hometel']);
                        $p2mobile = mysql_real_escape_string($_POST['p2mobile']);
                        $p2email = mysql_real_escape_string($_POST['p2email']);

                        $altname = mysql_real_escape_string($_POST['altname']);
                        $altrelation = mysql_real_escape_string($_POST['altrelation']);
                        $altaddress = mysql_real_escape_string($_POST['altaddress']);
                        $alttel = mysql_real_escape_string($_POST['alttel']);

                        $dietreq = mysql_real_escape_string($_POST['dietreq']);
                        $medreq = mysql_real_escape_string($_POST['medreq']);
                        $relreq = mysql_real_escape_string($_POST['relreq']);
                        $hobbies = mysql_real_escape_string($_POST['hobbies']);

                        //CHECK NULL ENTRIES
                        if($firstname != null && $lastname != null && $dob != null && $gender != null && $religion != null && $school != null
                                && $datejoined != null && $p1firstname != null && $p1lastname != null && $p1address1 != null && $p1address2 != null
                                && $p1postcode != null && $p1hometel != null && $p1mobile != null && $p1email != null){

                            //SUBMIT DATA
                            mysql_query("INSERT INTO scouts (firstname, lastname, dob, gender, religion,
                                school, datejoined, p1firstname, p1lastname, p1address1, p1address2, p1address3,
                                p1postcode, p1hometel, p1mobile, p1email, p2firstname, p2lastname, p2address1, p2address2, p2address3,
                                p2postcode, p2hometel, p2mobile, p2email, altcontact, altrelation, alttel, altaddress, dietreq, 
                                medreq, relreq, hobbies, assigned) VALUES ('".$firstname."', '".$lastname."', '".$dob."', '".$gender."',
                                    '".$religion."', '".$school."', '".$datejoined."', '".$p1firstname."', '".$p1lastname."',
                                        '".$p1address1."', '".$p1address2."', '".$p1address3."', '".$p1postcode."', '".$p1hometel."',
                                            '".$p1mobile."', '".$p1email."', '".$p2firstname."', '".$p2lastname."',
                                                '".$p2address1."', '".$p2address2."', '".$p2address3."', '".$p2postcode."', '".$p2hometel."',
                                                    '".$p2mobile."', '".$p2email."', '".$altname."', '".$altrelation."', '".$alttel."', '".$altaddress."',
                                                        '".$dietreq."', '".$medreq."', '".$relreq."', '".$hobbies."', 'no')") or die (error(mysql_error()));
                            //UPDATE ACTIVITY LOGS
                            mysql_query("INSERT INTO activity_logs (username, action, datetime) VALUES ('".$_SESSION['username']."', 'Added Scout (".$firstname." ".$lastname.")', '".date("Y-m-d - H:i:s")."')") or die (error(mysql_error()));
                            //success("Scout successfully added");
                            //REDIRECT
                            //header("Location: scouts.php");
                            echo "<script type=\"text/javascript\">document.location.href='scouts.php'</script>";
                        }
                        else{
                            error("You did not complete the required fields");
                        }
                        
                        
                }

                ?>
                <br>
                <form id="addscout" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h3>Scout Details</h3>
                        <label for="firstname">First Name:</label><input name="firstname" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['firstname'];} ?>" /><span class="required">*</span><span class="hint">Enter the Scout's first name</span><br>
                        <label for="lastname">Last Name:</label><input name="lastname" type="text" class="box" value="<?php if(isset($_POST['save'])){echo $_POST['lastname'];} ?>" /><span class="required">*</span><span class="hint">Enter the Scout's last name</span><br>
                        <label for="dob">Date of Birth:</label><input name="dob" type="text" class="box" /><span class="required">*</span><span class="hint">Enter the Scout's date of birth.</span><br>
                        <label for="gender">Gender:</label><input name="gender" type="radio" value="male"> Male
                        <input name="gender" type="radio" value="female"> Female
                        <span class="required" style="margin-left:112px;">*</span><span class="hint">Select the Scout's gender</span><br><br>
                        <label for="religion">Religion:</label><input name="religion" type="text" class="box" /><span class="required">*</span><span class="hint">Enter the Scout's religion.</span><br>
                        <label for="school">School:</label><input name="school" type="text" class="box" /><span class="required">*</span><span class="hint">Enter the Scout's school.</span><br>
                        <label for="datejoined">Date Joined:</label><input name="datejoined" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Scout's join date (yyyy-mm-dd).</span><br>
                    <br>
                    <h3>Parent/Carer Details</h3>
                    <h4>Person 1</h4><br>
                        <label for="p1firstname">First Name:</label><input name="p1firstname" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's first name.</span><br>
                        <label for="p1lastname">Last Name:</label><input name="p1lastname" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's lastname.</span><br>
                        <label for="p1address1">Address 1:</label><input name="p1address1" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's address.</span><br>
                        <label for="p1address2">Address 2:</label><input name="p1address2" type="text" class="box" /><br>
                        <label for="p1address3">Address 3:</label><input name="p1address3" type="text" class="box" /><br>
                        <label for="p1postcode">Postcode:</label><input name="p1postcode" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's postcode.</span><br>
                        <label for="p1hometel">Home Tel:</label><input name="p1hometel" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's home phone number.</span><br>
                        <label for="p1mobile">Mobile:</label><input name="p1mobile" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's mobile number.</span><br>
                        <label for="p1email">Email:</label><input name="p1email" type="text" class="box" /><span class="required">*</span><span class="hint">Enter Parent's email address.</span><br>
                    <br>
                    <h4>Person 2</h4><br>
                        <label for="p2firstname">First Name:</label><input name="p2firstname" type="text" class="box" /><br>
                        <label for="p2lastname">Last Name:</label><input name="p2lastname" type="text" class="box" /><br>
                        <label for="p2address1">Address 1:</label><input name="p2address1" type="text" class="box" /><br>
                        <label for="p2address2">Address 2:</label><input name="p2address2" type="text" class="box" /><br>
                        <label for="p2address3">Address 3:</label><input name="p2address3" type="text" class="box" /><br>
                        <label for="p2postcode">Postcode:</label><input name="p2postcode" type="text" class="box" /><br>
                        <label for="p2hometel">Home Tel:</label><input name="p2hometel" type="text" class="box" /><br>
                        <label for="p2mobile">Mobile:</label><input name="p2mobile" type="text" class="box" /><br>
                        <label for="p2email">Email:</label><input name="p2email" type="text" class="box" /><br>
                    <br>
                    <h3>Alternative Contact</h3>
                        <label for="altname">Name:</label><input name="altname" type="text" class="box" /><br>
                        <label for="altrelation">Relationship:</label><input name="altrelation" type="text" class="box" /><br>
                        <label for="altaddress">Address:</label><input name="altaddress" type="text" class="box" style="width: 400px;" /><br>
                        <label for="alttel">Tel:</label><input name="alttel" type="text" class="box" /><br>
                    <br>
                    <h3>Special Requirements</h3>
                        <label for="dietreq">Dietary:</label><input name="dietreq" type="text" class="box" style="width: 400px;" /><br>
                        <label for="medreq">Medical:</label><input name="medreq" type="text" class="box" style="width: 400px;" /><br>
                        <label for="relreq">Religous:</label><input name="relreq" type="text" class="box" style="width: 400px;" /><br>
                        <label for="hobbies">Hobbies/Interests:</label><input name="hobbies" type="text" class="box" style="width: 400px;" /><br>
                    <br>
                    <input name="save" type="submit" class="button" value="Save"/>
                </form>
            </div>
        </div>
    </body>
</html>
