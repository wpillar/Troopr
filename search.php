<?php
    $url = PageURL();
    include("includes/check_login.php"); //Check if user is logged in

    include("includes/db_connect.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Troopr - Search</title>
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
                <h2>Search</h2>
                <div class="searchpage">
                    <form id="searchbox" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=search">
                        <input type="text" class="box" name="query" />
                        <input type="submit" class="button" name="submit" value="Search" />
                    </form>
                </div>
                <div class="results" style="margin-left:10px;">
                    <?php
                        $query = $_POST['query'];
                        $split = explode(" ", $_POST['query']);

                        function PrintArray($array){
                            /*for($c = 0; $c < count($array); $c += 1){
                                return $array[$c]."* ";
                            }*/
                            $v = "";
                            foreach($array as $value){
                                
                                $v .= $value."%";
                            }
                            return $v;
                        }

                        //GENERATE quer
                        //SELECT CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE lastname LIKE '%ill%' OR firstname LIKE '%ill%'
                        //SELECT bid, name FROM badges WHERE name LIKE '%ill%' ORDER BY name ASC
                            $squer = "SELECT sid, CONCAT(firstname, ' ', lastname) AS name FROM scouts WHERE lastname LIKE '%";
                            $squer .= PrintArray($split);
                            $squer .= "' OR firstname LIKE '%";
                            $squer .= PrintArray($split);
                            $squer .= "' ORDER BY name ASC";

                            $bquer = "SELECT bid, name FROM badges WHERE name LIKE '%";
                            $bquer .= PrintArray($split);
                            $bquer .= "' ORDER BY name ASC";

                        if($query == null || $query == ""){
                            echo "<br><span class=\"hint\">You did not enter any search terms</span>";
                        }
                        else {

                            //echo $squer."<br>";
                            //echo $bquer."<br>";
                            
                            $scouts = mysql_query($squer) or die(mysql_error());
                            $snum = mysql_num_rows($scouts);
                            
                            $badges = mysql_query($bquer) or die(mysql_error());
                            $bnum = mysql_num_rows($badges);

                            if($snum == 0 && $bnum == 0){
                                echo "<br><span class=\"hint\">Your search did not return any results</span>";
                            }
                            else {
                                
                                if($snum != 0){
                                    echo "<br>";
                                    echo "<h3>Scouts</h3>";
                                    while($sresults = mysql_fetch_array($scouts)){
                                        echo "<a href=\"scoutprofile.php?sid=".$sresults['sid']."\">".$sresults['name']."</a><br>";
                                    }
                                }
                                else{
                                    //echo "<br><span class=\"hint\">Your search did not return any Scout results</span>";
                                }
                                
                                if($bnum != 0){
                                    echo "<br>";
                                    echo "<h3>Badges</h3>";
                                    while($bresults = mysql_fetch_array($badges)){
                                        echo "<a href=\"badgeprofile.php?bid=".$bresults['bid']."\">".$bresults['name']."</a><br>";
                                    }
                                }
                                else{
                                    //echo "<br><span class=\"hint\">Your search did not return any Badge results</span>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
