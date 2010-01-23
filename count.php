<?php

function GetPercent($tid){
    include("includes/db_connect.php");

$tconst = 5; //number of non req fields in badge_tracker table
$bconst = 4; //number of non req fields in badges table

//SETUP QUERIES
$tquery = "SELECT * FROM badge_tracker WHERE tid =".$tid;
$tresult = mysql_query($tquery);
$trow = mysql_fetch_array($tresult);
$bquery = "SELECT * FROM badges WHERE bid =".$trow['bid'];
$bresult = mysql_query($bquery);

//GET DONE REQS
    $numfields = mysql_num_fields($tresult);
    $row = 0;
    $count = 0;

    for($i=0; $i < $numfields; $i++){
        if(mysql_result($tresult, $row, $i) != ''){
            $name[$count] = mysql_field_name($tresult, $i);
            $count++;
        }

    }
    $donreqs = $count-$tconst;

    //echo 'badge_tracker - num of completed requirements : '.($donreqs).'<br />';

//GET BADGES REQS
    $numfields = mysql_num_fields($bresult);
    $row = 0;
    $count = 0;

    for($i=0; $i < $numfields; $i++){
        if(mysql_result($bresult, $row, $i) != ''){
            $name[$count] = mysql_field_name($bresult, $i);
            $count++;
        }

    }
    $reqs = $count-$bconst;

    //echo 'badge - num of requirements : '.($reqs).'<br />';

//CALCULATE PERCENTAGE AND OUTPUT
    if($reqs < $donreqs){
        echo "SOMETHING HAS GONE HORRIBLY WRONG";
    }
    else {
        $calc = ($donreqs / $reqs)*100;
        $pcent = number_format($calc, 2, '.', '');
        //echo 'Percentage complete: '.$pcent."%<br>";
        return $pcent;
    }
}
?>

<!--<div style="background-color:red;height:15px;width:<?php //echo $pcent;?>px;"></div>-->