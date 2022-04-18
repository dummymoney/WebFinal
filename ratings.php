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
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
	    $rating = $_POST['rating'];
        if($rating > 0 && $rating < 10){
            $sql = "INSERT INTO rating (rNum,cName) VALUES (".$rating.",'Customer')"; 
            if(mysqli_query($connect, $sql)){
                echo '<h2>Thanks for rating! '.$rating.'</h2>';
            } else{
                echo "ERROR: Could not able to execute";
            }
            header("location: front.php");
            exit();
        }
        else{
            header("location: front.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Museum Ratings</title>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
</head>
<body>
<div class="container">
	<h2>Museum Ratings</h2>
	<form action="#" method="post">
    <label for="ratinginput" class="control-label">Give rating for the museum:</label>
    <input id="ratinginput" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="2">
	<p></p>
    <link rel="stylesheet" href="Collections/Coll2.css">
    <style>
         .button-51 {
            right:-10px;
         }
    </style>
    <input type="submit" class="button-51" role="button" name="Submit"/>
	</form>
</div>
<script>
$("#ratinginput").rating();
</script>
</body>
</html>