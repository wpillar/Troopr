<?php
    $url = PageURL();
    include("includes/check_login.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Scouts</title>
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
                <?php include("includes/messages.php") ?>
                <h2>Scouts</h2>
                <div class="submenu">
                    <img src="images/icons/user_add.png" alt="add scout" /> <a href="addscout.php">Add Scout</a>
                    | <img src="images/icons/email.png" alt="email" /> <a href="sendmail.php?to=<?php
                                                                            include("includes/db_connect.php");

                                                                            $result = mysql_query("SELECT p1email FROM scouts");

                                                                            while($row = mysql_fetch_array($result)){
                                                                                echo $row['p1email'];
                                                                                echo ", ";
                                                                            }

                                                                            mysql_close($conn);
                                                                          ?>">Email All Parents</a>
                </div>

                <table>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>D.O.B</th>
                        <th>School</th>
                        <th>Date Joined</th>
                        <?php if($_SESSION['type'] == 'admin' || $_SESSION['type'] == 'superadmin'){ echo '<th>Edit</th><th>Delete</th>';}?>
                    </tr>
                <?php
                    include("includes/db_connect.php");

                    $result = mysql_query("SELECT sid, firstname, lastname, gender, dob, school, datejoined FROM scouts ORDER BY firstname ASC");

                    while($row = mysql_fetch_array($result))
                    {
                        echo '<tr><td><a href="scoutprofile.php?sid='.$row['sid'].'">'.$row['firstname'].'</a></td><td>'.$row['lastname'].'</td><td>'.ucwords($row['gender']).'</td><td>'.$row['dob'].'</td>
                            <td>'.$row['school'].'</td><td>'.$row['datejoined'].'</td>';
                        if($_SESSION['type'] == 'admin' || $_SESSION['type'] == 'superadmin'){
                            echo '<td><a href="editscout.php?sid='.$row['sid'].'">Edit</a></td><td><a href="functions/deletescout.php?sid='.$row['sid'].'&firstname='.str_rot13($row['firstname']).'&lastname='.str_rot13($row['lastname']).'">Delete</a></td>';}
                        echo '</tr>';
                    }
                    mysql_close($conn);
                ?>
                </table>
            </div>
        </div>
    </body>
</html>
