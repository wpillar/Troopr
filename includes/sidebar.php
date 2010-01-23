<?php
?>
<div class="sidebar">
    <div class="sideacc">
        <h4>Account</h4>
        <p>
            Logged in as: <span class="sidedata"><?php echo $_SESSION['username']; ?><br></span>
            Account Type: <span class="sidedata"><?php echo ucwords($_SESSION['type']); ?><br></span>
            Date: <span class="sidedata"><?php echo date("d-m-Y"); ?></span>
        </p>
        <center>
            <form id="logout" method="post" action="<?php echo URL; ?>functions/logout.php">
                <input class="button" type="submit" name="logout" value="Logout"/>
            </form>
        </center>
        <ul id="sidebarmenu">
            <li><img src="<?php echo URL; ?>images/icons/key.png" alt="key"/> <a href="<?php echo URL; ?>changepass.php">Change Password</a></li>
            <li><img src="<?php echo URL; ?>images/icons/coins.png" alt="coins" /> <a href="<?php echo URL; ?>billing/index.php">Billing</a></li>
            <li><?php if($_SESSION['type'] == "superadmin"){echo '<img src="';
            echo URL;
            echo 'images/icons/award_star_add.png" alt="addbadge"/> <a href="';
            echo URL;
            echo 'addbadge.php">Add Badge</a>';
            } ?></li>
            <li><?php if($_SESSION['type'] == "superadmin" || $_SESSION['type'] == "admin"){echo '<img src="';
            echo URL;
            echo 'images/icons/page_white_gear.png" alt="page_white_gear"/> <a href="';
            echo URL;
            echo 'logs.php?action=activity">Logs</a>';
            } ?></li>
        </ul>  
    </div>
    <div class="sidesupp">
        <h4>Support</h4>
        <ul id="sidebarmenu">
            <li><img src="<?php echo URL; ?>images/icons/bug.png" alt="bug"/> 
                <a href="<?php echo URL; ?>sendmail.php?to=tickets%2Bwpillar%2Btroopr%2Bc4ba10c8acfe%40goplanapp.com&sub=Bug/Error Occurred&msg=Please explain what happened:">Report Bug/Error</a></li>
        </ul>
    </div>
</div>
