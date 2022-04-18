<!--connecting to cloud database-->
<?php session_start();?>
<?php

$dbServername = "team12.copftkcel1k2.us-east-1.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "Group12,museum";
$dbName = "FinalTeam12";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}


//session_start();
//$emp_id = $_SESSION['customer'];

//sql query
$query = mysqli_query($connect,"select exName, eDate, cover_url from Exhibition where sDate <= sysdate() and eDate>=sysdate() order by eDate asc;");
//$rows = mysqli_fetch_all($query);

/*
foreach ($rows as $thingy){
    echo $thingy->exName;
}
*/
/*
while ($rows = mysqli_fetch_array($query))
{
    echo $rows["exName"];
    echo $rows["eDate"];
}
*/

//mysqli_close($connect);

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "utf-8">
        <title>Museum Exhibition</title>
        <link rel="stylesheet" href = "./stella_style.css">
        <meta name="viewpoint" content="width=device-width, initial-scale=1">

    </head>

    <body>
    <!--following is nav bar-->
        <div class="header-container">
            <a href= "../front.php"><img class= "logo" src="../images/museum.jpeg" alt="logo"></a>
            
            <ul class= "nav-links">
            <li class="nav-item name"><?php
                    $result = $connect->query("select * from Museum");
                    $res = $result->fetch_all();
                    print_r($res[0][0]);
                ?></li>
                    <div class="dropdown">
                    <li class="nav-item"><button class="button-56" role="button">Navigate</button></li>  <!--manage button is right hereeeeeeeeeeeeee-->
                        <div class ="dropdown-content">
                            <a href="../front.php">Home</a>
                            <?php
                        if($_SESSION["user"] != "guest") 
                            { 
                                echo '<a href="../Reports/Exhibition-Search.php">Report</a>';
                                echo '<a href="cur_exhibition.php">Manage</a>';
                            }
                        ?> 
                        <?php
                        if($_SESSION["user"] == "guest") 
                            { 
                                echo '<a href="../GenAdmission.php">Tickets</a>';
                                echo '<a href="../Collections/displayArt.php">Gallery</a>';
                            }
                        ?> 
                        </div>

                    </div>
                </ul>
            
        </div>


<!-- following is body -->
        <div class = "body-page">
            <h2>Exhibitions</h2>
            <h3>Current Exhibitions</h4> 

            <!--exhibition cards-->
       
        <div class="all-cards-container">

             <?php foreach ($query as $thingy): ?>

            <div class= "cards">
                <img src="<?=htmlspecialchars($thingy["cover_url"])?>" alt="<?=htmlspecialchars($thingy["exName"])?>"  >
                <div class = "container">
                    <h4><b><?=htmlspecialchars($thingy["exName"])?></b></h4>
                    <p>Through <?=htmlspecialchars($thingy["eDate"])?></p>
                </div>
            </div>
            <?php endforeach ?>

            <?php
                mysqli_free_result($query);
                mysqli_close($connect);
            ?>
                            
            </div>   


        </div>
    </body>
</html>