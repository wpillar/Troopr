<?php
    $url = PageURL();
    include("includes/check_login.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Users</title>
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
                <h2>Users</h2>
                <div class="submenu">
                    <?php if($_SESSION['type'] != 'leader'){ ?><img src="images/icons/user_add.png" alt="add user" /> <a href="adduser.php">Add User</a><?php } ?>
                    | <img src="images/icons/email.png" alt="email" /> <a href="sendmail.php?to=<?php
                                                                            include("includes/db_connect.php");

                                                                            $result = mysql_query("SELECT email FROM users WHERE type != 'superadmin'");

                                                                            while($row = mysql_fetch_array($result)){
                                                                                echo $row['email'];
                                                                                echo ", ";
                                                                            }

                                                                            mysql_close($conn);
                                                                          ?>">Email All Users</a>
                </div>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Last Login</th>
                        <?php if($_SESSION['type'] == 'admin' || $_SESSION['type'] == 'superadmin'){ echo '<th>Edit</th><th>Delete</th>';}?>
                    </tr>
                <?php
                    include("includes/db_connect.php");

                    $result = mysql_query("SELECT uid, username, firstname, lastname, email, lastlogin, type FROM users WHERE type='leader' OR type='admin'");

                    while($row = mysql_fetch_array($result))
                    {
                        echo '<tr><td>'.$row['username'].'</td><td>'.$row['firstname'].'</td><td>'.$row['lastname'].'</td><td>'.$row['email'].'</td><td>'.$row['lastlogin'].'</td>';
                        if($_SESSION['type'] == 'admin' || $_SESSION['type'] == 'superadmin'){echo '<td><a href="edituser.php?uid='.$row['uid'].'">Edit</a></td><td>
                            <a href="functions/deleteuser.php?uid='.$row['uid'].'&username='.$row['username'].'">Delete</a></td>';}
                        echo '</tr>';
                    }
                    mysql_close($conn);
                ?>
                </table>
            </div>
        </div>
    </body>
</html>