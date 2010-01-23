<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    $sid = $_GET['sid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Edit Scout</title>
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

                include("includes/db_connect.php");

                $getscout = mysql_query("SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE sid=".$sid);
                $scout = mysql_fetch_array($getscout);

                $name = $scout['name'];
                $firstname = $scout['firstname'];
                $lastname = $scout['lastname'];
                $dob = $scout['dob'];
                $gender = $scout['gender'];
                $religion = $scout['religion'];
                $school = $scout['school'];
                $datejoined = $scout['datejoined'];

                $p1firstname = $scout['p1firstname'];
                $p1lastname = $scout['p1lastname'];
                $p1address1 = $scout['p1address1'];
                $p1address2 = $scout['p1address2'];
                $p1address3 = $scout['p1address3'];
                $p1postcode = $scout['p1postcode'];
                $p1hometel = $scout['p1hometel'];
                $p1mobile = $scout['p1mobile'];
                $p1email = $scout['p1email'];

                $p2firstname = $scout['p2firstname'];
                $p2lastname = $scout['p2lastname'];
                $p2address1 = $scout['p2address1'];
                $p2address2 = $scout['p2address2'];
                $p2address3 = $scout['p2address3'];
                $p2postcode = $scout['p2postcode'];
                $p2hometel = $scout['p2hometel'];
                $p2mobile = $scout['p2mobile'];
                $p2email = $scout['p2email'];

                $altname = $scout['altcontact'];
                $altrelation = $scout['altrelation'];
                $altaddress = $scout['altaddress'];
                $alttel = $scout['alttel'];

                $dietreq = $scout['dietreq'];
                $medreq = $scout['medreq'];
                $relreq = $scout['relreq'];
                $hobbies = $scout['hobbies'];

            ?>
            <div class="content">
                <h2>Edit Scout: <?php echo $name ?></h2>
                <?php
                    function error($msg){
                        echo '<p class="error" style="text-align:center;"><img src="images/icons/cancel.png" alt="error"/> '.$msg.'</p>';
                    }
                    function success($msg){
                        echo '<p class="success" style="text-align:center;"><img src="images/icons/accept.png" alt="error"/> '.$msg.'</p>';
                    }

                    if(isset($_POST['save'])){
                        //CHECK NULLS
                        if($_POST['firstname'] != null && $_POST['lastname'] != null && $_POST['dob'] != null && $_POST['gender'] != null &&
                            $_POST['religion'] != null && $_POST['school'] != null
                                && $_POST['datejoined'] != null && $_POST['p1firstname'] != null && $_POST['p1lastname'] != null &&
                                $_POST['p1address1'] != null && $_POST['p1address2'] != null
                                && $_POST['p1postcode'] != null && $_POST['p1hometel'] != null && $_POST['p1mobile'] != null && $_POST['p1email'] != null){
                            //UPDATE DATA
                            mysql_query("UPDATE scouts SET firstname='".$_POST['firstname']."', lastname='".$_POST['lastname']."', dob='".$_POST['dob']."', gender='".$_POST['gender']."',
                                    religion='".$_POST['religion']."', school='".$_POST['school']."', datejoined='".$_POST['datejoined']."', p1firstname='".$_POST['p1firstname']."', p1lastname='".$_POST['p1lastname']."',
                                        p1address1='".$_POST['p1address1']."', p1address2='".$_POST['p1address2']."', p1address3='".$_POST['p1address3']."', p1postcode='".$_POST['p1postcode']."', p1hometel='".$_POST['p1hometel']."',
                                            p1mobile='".$_POST['p1mobile']."', p1email='".$_POST['p1email']."', p2firstname='".$_POST['p2firstname']."', p2lastname='".$_POST['p2lastname']."',
                                                p2address1='".$_POST['p2address1']."', p2address2='".$_POST['p2address2']."', p2address3='".$_POST['p2address3']."', p2postcode='".$_POST['p2postcode']."',
                                                    p2hometel='".$_POST['p2hometel']."',
                                                    p2mobile='".$_POST['p2mobile']."', p2email='".$_POST['p2email']."', altcontact='".$_POST['altname']."', altrelation='".$_POST['altrelation']."',
                                                        alttel='".$_POST['alttel']."', altaddress='".$_POST['altaddress']."',
                                                        dietreq='".$_POST['dietreq']."', medreq='".$_POST['medreq']."', relreq='".$_POST['relreq']."', hobbies='".$_POST['hobbies']."' WHERE sid=".$sid) or die(mysql_error());
                            //REDIRECT TO SCOUT PROFILE
                            //header("Location: scoutprofile.php?sid=".$sid);
                            echo "<script type=\"text/javascript\">document.location.href='scoutprofile.php?sid=".$sid."'</script>";
                        }
                        else{
                            error("You did not complete all the required fields");
                        }
                    }
                ?>
                <br>
                <form id="addscout" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?sid=<?php echo $sid; ?>">
                    <h3>Scout Details</h3>
                        <label for="firstname">First Name:</label><input name="firstname" type="text" class="box" value="<?php echo $firstname; ?>" /><span class="required">*</span><span class="hint">Enter the Scout's first name</span><br>
                        <label for="lastname">Last Name:</label><input name="lastname" type="text" class="box" value="<?php echo $lastname; ?>" /><span class="required">*</span><span class="hint">Enter the Scout's last name</span><br>
                        <label for="dob">Date of Birth:</label><input name="dob" type="text" class="box" value="<?php echo $dob; ?>" /><span class="required">*</span><span class="hint">Enter the Scout's date of birth.</span><br>
                        <?php
                            if($gender == "male"){
                                $rad1 = "checked=\"\"";
                            }
                            if($gender == "female"){
                                $rad2 = "checked=\"\"";
                            }
                        ?>
                        <label for="gender">Gender:</label><input name="gender" type="radio" value="male" <?php echo @$rad1; ?> /> Male
                        <input name="gender" type="radio" value="female" <?php echo @$rad2; ?> /> Female
                        <br><br>
                        <label for="religion">Religion:</label><input name="religion" type="text" class="box" value="<?php echo $religion; ?>" /><br>
                        <label for="school">School:</label><input name="school" type="text" class="box" value="<?php echo $school; ?>" /><br>
                        <label for="datejoined">Date Joined:</label><input name="datejoined" type="text" class="box" value="<?php echo $datejoined; ?>" /><br>
                    <br>
                    <h3>Parent/Carer Details</h3>
                    <h4>Person 1</h4><br>
                        <label for="p1firstname">First Name:</label><input name="p1firstname" type="text" class="box" value="<?php echo $p1firstname; ?>" /><br>
                        <label for="p1lastname">Last Name:</label><input name="p1lastname" type="text" class="box" value="<?php echo $p1lastname; ?>" /><br>
                        <label for="p1address1">Address 1:</label><input name="p1address1" type="text" class="box" value="<?php echo $p1address1; ?>" /><br>
                        <label for="p1address2">Address 2:</label><input name="p1address2" type="text" class="box" value="<?php echo $p1address2; ?>" /><br>
                        <label for="p1address3">Address 3:</label><input name="p1address3" type="text" class="box" value="<?php echo $p1address3; ?>" /><br>
                        <label for="p1postcode">Postcode:</label><input name="p1postcode" type="text" class="box" value="<?php echo $p1postcode; ?>" /><br>
                        <label for="p1hometel">Home Tel:</label><input name="p1hometel" type="text" class="box" value="<?php echo $p1hometel; ?>" /><br>
                        <label for="p1mobile">Mobile:</label><input name="p1mobile" type="text" class="box" value="<?php echo $p1mobile; ?>" /><br>
                        <label for="p1email">Email:</label><input name="p1email" type="text" class="box" value="<?php echo $p1email; ?>" /><br>
                    <br>
                    <h4>Person 2</h4><br>
                        <label for="p2firstname">First Name:</label><input name="p2firstname" type="text" class="box" value="<?php echo $p2firstname; ?>" /><br>
                        <label for="p2lastname">Last Name:</label><input name="p2lastname" type="text" class="box" value="<?php echo $p2lastname; ?>" /><br>
                        <label for="p2address1">Address 1:</label><input name="p2address1" type="text" class="box" value="<?php echo $p2address1; ?>" /><br>
                        <label for="p2address2">Address 2:</label><input name="p2address2" type="text" class="box" value="<?php echo $p2address2; ?>" /><br>
                        <label for="p2address3">Address 3:</label><input name="p2address3" type="text" class="box" value="<?php echo $p2address3; ?>" /><br>
                        <label for="p2postcode">Postcode:</label><input name="p2postcode" type="text" class="box" value="<?php echo $p2postcode; ?>" /><br>
                        <label for="p2hometel">Home Tel:</label><input name="p2hometel" type="text" class="box" value="<?php echo $p2hometel; ?>" /><br>
                        <label for="p2mobile">Mobile:</label><input name="p2mobile" type="text" class="box" value="<?php echo $p2mobile; ?>" /><br>
                        <label for="p2email">Email:</label><input name="p2email" type="text" class="box" value="<?php echo $p2email; ?>" /><br>
                    <br>
                    <h3>Alternative Contact</h3>
                        <label for="altname">Name:</label><input name="altname" type="text" class="box" value="<?php echo $altname; ?>" /><br>
                        <label for="altrelation">Relationship:</label><input name="altrelation" type="text" class="box" value="<?php echo $altrelation; ?>" /><br>
                        <label for="altaddress">Address:</label><input name="altaddress" type="text" class="box" value="<?php echo $altaddress; ?>" style="width: 400px;" /><br>
                        <label for="alttel">Tel:</label><input name="alttel" type="text" class="box" value="<?php echo $alttel; ?>" /><br>
                    <br>
                    <h3>Special Requirements</h3>
                        <label for="dietreq">Dietary:</label><input name="dietreq" type="text" class="box" value="<?php echo $dietreq; ?>" style="width: 400px;" /><br>
                        <label for="medreq">Medical:</label><input name="medreq" type="text" class="box" value="<?php echo $medreq; ?>" style="width: 400px;" /><br>
                        <label for="relreq">Religous:</label><input name="relreq" type="text" class="box" value="<?php echo $relreq; ?>" style="width: 400px;" /><br>
                        <label for="hobbies">Hobbies/Interests:</label><input name="hobbies" type="text" value="<?php echo $hobbies; ?>" class="box" style="width: 400px;" /><br>
                    <br>
                    <input name="save" type="submit" class="button" value="Save"/>
                </form>
            </div>
        </div>
    </body>
</html>
