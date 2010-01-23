<?php
    //include("init.php");
?>
<div class="header">
    <a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>/images/trooprbeta.png" alt="troopr logo" style="border: none;" /></a>
    <?php if(isset($_GET['page']) != "search"){ ?>
    <div class="search">
        <form id="searchbox" method="post" action="search.php?page=search">
                        <input type="text" class="box" name="query" />
                        <input type="submit" class="button" name="submit" value="Search" />
        </form>
    </div>
    <?php } ?>
</div>
