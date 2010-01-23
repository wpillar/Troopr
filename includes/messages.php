<?php
    include("includes/db_connect.php");

    $sresult = mysql_query("SELECT sid FROM scouts WHERE assigned = 'no'");
    $srow = mysql_num_rows($sresult);

    $presult = mysql_query("SELECT pid FROM patrols WHERE num = 0");
    $prow = mysql_num_rows($presult);
    $div = " | ";

    function message($msg){
        echo "<div class=\"message\"><center>".$msg."</center></div>";
    }

    if($srow != 0)
        $scouts = "<a href=\"assignscouts.php\">(".$srow.") Scouts not assigned</a>";
    else
        $scouts = "";

    if($prow != 0)
        $patrols = "<a href=\"assignscouts.php\">(".$prow.") Empty Patrols</a>";
    else
        $patrols = "";

    if($srow != 0 && $prow != 0)
        message($scouts.$div.$patrols);
    else if($srow != 0 || $prow != 0)
        message($scouts.$patrols);

?>
