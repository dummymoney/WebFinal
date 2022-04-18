//Connecting to server
<?php
echo "this is php";
$dbServername = "team12.copftkcel1k2.us-east-1.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "Group12,museum";
$dbName = "FinalTeam12";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

session_start();
// $customer_id = $_SESSION['customer']
?>
<?php
$price=$itemname=$quantity="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // variable containing query to search database for given item name from textbox
    $check_itemname = "SELECT * FROM FinalTeam12.GiftShop WHERE item_name='$itemname'";


    // run and store query result into variable
    $result = mysqli_query($connect, check_itemname);
    // boolean (i think...not sure but it works) variable from result
    $item_exists = mysqli_fetch_assoc($result);
    // if true
    if ($item_exists) $exist_err = "E-mail address is already taken.";
    
    // if all error strings are empty meaning all info is valid
    if (empty($exist_err)) {
        // variable containing query to insert info into database
        $sql = "INSERT INTO FinalTeam12.GiftShop (item_name, price, quantity) VALUES (?, ?, ?)";
        // prepare query statement
        if ($stmt = mysqli_prepare($connect, $sql)) {
            // bind parameters into query statement
            mysqli_stmt_bind_param($stmt, "sdi", $param_name, $param_price, $param_q);
            $param_name = $itemname;
            $param_price = $price;
            $param_q = $quantity;
            // if query executed successfully
            if (mysqli_stmt_execute($stmt)) {
                $success = '<div class="alert alert-success" role="alert">Your item has been created.</div>';
                // wait 2 seconds then redirect to sign-in page
                header('refresh:1; url=sign-in.php');
            }
            else $error = '<div class="alert alert-danger" role="alert">Oops, something went wrong. Please try again later.</div>';
        }
        else $error = '<div class="alert alert-danger" role="alert">Please make sure your information is valid.</div>';
    }
    // close the connection
    mysqli_close($conn_WebLogins);
}


?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        //Name of Item
        <label class="form-label">Item Name</label>
        <input type="text" name="name" class="form-control">

        //Price of Item
        <label class="form-label">Price</label>
        <input type="number" step="0.01" name="price" class="form-control">

        //Quantity of Item
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" min="0" class="form-control">

        //Create Button
        <input type="submit" name="submit" class="btn btn-outline-secondary" value="Create">
    </form>
</body>
</html>