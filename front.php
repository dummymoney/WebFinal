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
?>
<link href="site.css" rel="stylesheet">
<body>
    <!--following is nav bar-->
        <div class="header-container">
            <a href= "front.php"><img class= "logo" src="images/museum.jpeg" alt="logo"></a>
                <ul class= "nav-links">
                <?php
                        if($_SESSION["user"] != "guest") 
                            { 
                                echo '<li class="nav-item"><a href="Reports/Ticket.php"><button class="button-56" role="button">Reports</button></a></li>';
                            }
                        ?> 
                        <?php
                        if($_SESSION["user"] == "guest") 
                            { 
                                echo '<li class="nav-item"><a href="GenAdmission.php"><button class="button-56" role="button">Buy Tickets</button></a></li>';
                            }
                        ?> 
                    <li class="nav-item"><a href="Collections/displayArt.php"><button class="button-56" role="button">Gallery</button></a></li>
                    <li class="nav-item"><a href="Ex/exhibition_page.php"><button class="button-56" role="button">Exhibitions</button></a></li>
                    <?php
                        if($_SESSION["user"] != "guest") 
                            { 
                                echo '<li class="nav-item"><a href="Employees/employee.php"><button class="button-56" role="button">Employees</button></a></li>';
                            }
                        ?>                     
                    <li class="nav-item login-button" ><a href="index.php"><button >Logout</button></a></li>
                </ul>
                <h4>&emsp;Rated: <?php
                $result = $connect->query("select * from Museum");
                $res = $result->fetch_all();
                echo $res[0][7];
                ?>/5</h4>
        </div>

<!-- following is body -->
        <div class = "body-page">
            <h2>
                <?php
                $result = $connect->query("select * from Museum");
                $res = $result->fetch_all();
                print_r($res[0][0]);
                ?>
                </h2>
                <h3>Address: 
                <?php
                echo $res[0][1] . " " . $res[0][2]." " . $res[0][3]." " . $res[0][4];
                $connect->close();
                ?>
                </h3>
            <p>&emsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vestibulum elit urna, ut semper nisl rutrum quis. In dapibus felis eget leo pharetra sagittis. Integer vitae lorem nunc. Nullam accumsan sit amet dolor sed imperdiet. Aenean eget nisi eu eros gravida ultricies. 
              Mauris non nulla a felis dictum convallis. Donec arcu augue, aliquet et varius vel, rhoncus eu arcu. Morbi quis urna purus. Morbi suscipit nunc nec mauris posuere, ut vulputate turpis tincidunt. Nullam pulvinar lorem non lectus facilisis suscipit. Fusce hendrerit sagittis erat interdum euismod. Integer et odio ac mi posuere laoreet. 
              Donec sed pretium nunc, non pulvinar elit. 
              Nullam quis mauris interdum urna dapibus maximus a nec sapien. 
              Nulla mat is arcu vitae arcu cursus laoreet. Nam vitae porttitor lacus, sed lacinia massa. Vestibulum maximus viverra metus eget varius. Nullam aliquet nisi eget lorem fringilla pharetra. Nulla facilisi. Nullam vitae urna pulvinar, mollis elit eu, porta ligula. Nulla vitae massa eros. In a ornare justo. Proin scelerisque pulvinar arcu sed dignissim. Ut varius libero vel venenatis mollis. 
              In pellentesque mollis augue, eu efficitur massa. Aliquam suscipit vulputate lectus, sit amet ullamcorper enim posuere non. Morbi sit amet magna ut orci semper sodales consequat ut neque. Cras in eros gravida, ornare ipsum id, mollis leo.
            </p>
            <p></p>
            <p>&emsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vestibulum elit urna, ut semper nisl rutrum quis. In dapibus felis eget leo pharetra sagittis. Integer vitae lorem nunc. Nullam accumsan sit amet dolor sed imperdiet. Aenean eget nisi eu eros gravida ultricies. 
              Mauris non nulla a felis dictum convallis. Donec arcu augue, aliquet et varius vel, rhoncus eu arcu. Morbi quis urna purus. Morbi suscipit nunc nec mauris posuere, ut vulputate turpis tincidunt. Nullam pulvinar lorem non lectus facilisis suscipit. Fusce hendrerit sagittis erat interdum euismod. Integer et odio ac mi posuere laoreet. 
              Donec sed pretium nunc, non pulvinar elit. 
              Nullam quis mauris interdum urna dapibus maximus a nec sapien. 
              Nulla mat is arcu vitae arcu cursus laoreet. Nam vitae porttitor lacus, sed lacinia massa. Vestibulum maximus viverra metus eget varius. Nullam aliquet nisi eget lorem fringilla pharetra. Nulla facilisi. Nullam vitae urna pulvinar, mollis elit eu, porta ligula. Nulla vitae massa eros. In a ornare justo. Proin scelerisque pulvinar arcu sed dignissim. Ut varius libero vel venenatis mollis. 
              In pellentesque mollis augue, eu efficitur massa. Aliquam suscipit vulputate lectus, sit amet ullamcorper enim posuere non. Morbi sit amet magna ut orci semper sodales consequat ut neque. Cras in eros gravida, ornare ipsum id, mollis leo.
            </p>

        </div>
    </body>
