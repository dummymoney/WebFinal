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
 
// Define variables and initialize with empty values
$fName = $lName = $age = $email = $tNumber = $status = $inDate = "";
$fName_err = $lName_err = $age_err = $email_err = $tNumber_err = $status_err = $in_err ="";
$t_err = $ss_ee = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate artname
    $input_fName = trim($_POST["firstname"]);
    if(empty($input_fName)){
        $fName_err = "Please enter the first name.";
    } elseif(!filter_var($input_fName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fName_err = "Please enter a valid name.";
    } else{
        $fName = $input_fName;
    }

    $input_lName = trim($_POST["lastname"]);
    if(empty($input_lName)){
        $lName_err = "Please enter the last name.";
    } elseif(!filter_var($input_lName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lName_err = "Please enter a valid name.";
    } else{
        $lName = $input_lName;
    }
    
    // Validate age
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter the age.";     
    } elseif(!ctype_digit($input_age)){
        $age_err = "Please enter a positive integer value.";
    } else{
        $age = $input_age;
    }
    $input_tNumber = trim($_POST["tele"]);
    if(empty($input_tNumber)){
        $tNumber_err = "Please enter the phone number.";
    } if(preg_match('/^[0-9]{10}+$/', $input_tNumber)){
            $tNumber = $input_tNumber;
    }
    else{
        $tNumber_err = "Enter a valid number.";
    }
    // Validate dep
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the email";     
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    }else{
        $email = $input_email;
    }
    $input_stat = trim($_POST["status"]);
    if(empty($input_stat)){
        $status_err = "Please enter the status";     
    }  else{
        $status = $input_stat;
    }
    $input_in = trim($_POST["sDate"]);
    if(empty($input_in)){
        $in_err = "Please enter a date";     
    }
    else{ 
        $inDate = $input_in;
    }

    $chk_dup = true;

    $query = mysqli_query($connect, "SELECT * FROM CUSTOMERS WHERE Email='".$email."' AND FirstName='".$fName."' AND LastName='".$lName."'");

    if (!$query)
    {
        die('Error: ' . mysqli_error($connect));
    }

    if(mysqli_num_rows($query) > 0){

        $chk_dup = false;

    }else{

        $chk_dup = true;
    }

    $r_ticket = trim($_POST["regular"]);
    $c_ticket = trim($_POST["child"]);
    $st_ticket = trim($_POST["student"]);
    $se_ticket = trim($_POST["senior"]);
    $v_ticket = trim($_POST["veteran"]);

    $r_ticket = intval($r_ticket);
    $c_ticket = intval($c_ticket);
    $st_ticket = intval($st_ticket);
    $se_ticket = intval($se_ticket);
    $v_ticket = intval($v_ticket);

    if($r_ticket <= 0 && $c_ticket <= 0 && $st_ticket <= 0 && $se_ticket <= 0 && $v_ticket <= 0){
        $t_err = "No tickets added";
    }
    // Check input errors before inserting in database
    if(empty($t_err) && empty($fName_err) && empty($lName_err) && empty($age_err) && empty($email_err) && empty($status_err) && empty($tNumber_err)){
        // Prepare an insert statement
        if($chk_dup){
            $sql = "INSERT INTO CUSTOMERS (FirstName, LastName, Age, PhoneNumber, Email, SpecialStatus) VALUES (?, ?, ?, ?, ?, ?)";
        }
        else{
            $sql = "UPDATE CUSTOMERS SET FirstName=?, LastName=?, Age=?, PhoneNumber=?, Email=?, SpecialStatus=? WHERE Email='".$email."' AND FirstName='".$fName."' AND LastName='".$lName."'";
        }
        if($stmt = mysqli_prepare($connect, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisss", $param_fName, $param_lName, $param_age, $param_tNumber, $param_email, $param_status);
            
            // Set parameters
            $param_fName = $fName;
            $param_lName = $lName;
            $param_age = $age;
            $param_tNumber = $tNumber;
            $param_email = $email;
            $param_status = $status;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "done";
            } else{
                    $ss_ee = "Oops! Something went wrong. Please check your inputs.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    $result = $connect->query("SELECT * FROM CUSTOMERS WHERE Email='".$email."' AND FirstName='".$fName."' AND LastName='".$lName."'");
    $res = $result->fetch_all();
    $id = $res[0][5];
    if($r_ticket > 0){
        $sql2 = "INSERT INTO TICKET (TTYPES, QUANTITY, PRICE, SOLDDATE, CUSID) VALUES (?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($connect, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sidsi", $param_type, $param_qt, $param_price, $param_dt, $param_cid);
        
            // Set parameters
            $param_type = 'REGULAR';
            $param_qt = $r_ticket;
            $param_price = 10.00;
            $param_dt = $inDate;
            $param_cid = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "done";
            } else{
                $ss_ee = "Oops! Something went wrong. Please check the date.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if($c_ticket > 0){
        $sql2 = "INSERT INTO TICKET (TTYPES, QUANTITY, PRICE, SOLDDATE, CUSID) VALUES (?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($connect, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sidsi", $param_type, $param_qt, $param_price, $param_dt, $param_cid);
        
            // Set parameters
            $param_type = 'CHILD';
            $param_qt = $c_ticket;
            $param_price = 5.00;
            $param_dt = $inDate;
            $param_cid = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "done";
            } else{
                $ss_ee = "Oops! Something went wrong. Please check the date.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if($st_ticket > 0){
        $sql2 = "INSERT INTO TICKET (TTYPES, QUANTITY, PRICE, SOLDDATE, CUSID) VALUES (?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($connect, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sidsi", $param_type, $param_qt, $param_price, $param_dt, $param_cid);
        
            // Set parameters
            $param_type = 'STUDENT';
            $param_qt = $st_ticket;
            $param_price = 1.00;
            $param_dt = $inDate;
            $param_cid = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "done";
            } else{
                $ss_ee = "Oops! Something went wrong. Please check the date.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if($se_ticket > 0){
        $sql2 = "INSERT INTO TICKET (TTYPES, QUANTITY, PRICE, SOLDDATE, CUSID) VALUES (?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($connect, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sidsi", $param_type, $param_qt, $param_price, $param_dt, $param_cid);
        
            // Set parameters
            $param_type = 'SENIOR';
            $param_qt = $se_ticket;
            $param_price = 8.00;
            $param_dt = $inDate;
            $param_cid = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "done";
            } else{
                $ss_ee = "Oops! Something went wrong. Please check the date.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if($v_ticket > 0){
        $sql2 = "INSERT INTO TICKET (TTYPES, QUANTITY, PRICE, SOLDDATE, CUSID) VALUES (?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($connect, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sidsi", $param_type, $param_qt, $param_price, $param_dt, $param_cid);
        
            // Set parameters
            $param_type = 'VETERAN';
            $param_qt = $v_ticket;
            $param_price = 8.00;
            $param_dt = $inDate;
            $param_cid = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "done";
            } else{
                $ss_ee = "Oops! Something went wrong. Please check the date.";
            }
        }
        mysqli_stmt_close($stmt);
    }
        if($ss_ee == ""){
            header("location: testsend.php");
            exit();
        }
    }
    // Close connection
    mysqli_close($connect);
}

?>
<style>
            #reder{
                color: red;
                background-color: white;
                margin: 10px;
            }
            #grener{
                background-color: green;
                margin: 10px;
            }
 </style>
<!DOCTYPE html>
<html>
<link href="tFormat.css" rel="stylesheet">
<body>
  <div id="main">
  <h1>TICKETS: GENERAL ADMISSION</h1>
  <?php
  if(!empty($ss_ee))
    echo '<h3 id="reder">'. $ss_ee .'</h3>';
  ?>
  <h2>Choose one of the following:</h2>


  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label>($10) Regular:</label>
    <input type="number" name="regular" min="0" max="99"/><br>

    <label>($5) Child:</label>
    <input type="number" name="child" min="0" max="99"/><br>

    <label>($1) Student:</label>
    <input type="number" name="student" min="0" max="99"/><br>

    <label>($8) Senior:</label>
    <input type="number" name="senior" min="0" max="99"/><br>

    <label>($8) Veteran:</label>
    <input type="number" name="veteran" min="0" max="99"/><br>

    <br>
    <div>
    <?php
        if(!empty($t_err))
            echo '<span id="reder">'. $t_err .'</span>';
    ?>
    </div>
    <br>

    <h2>Enter the following:</h2>

    <label>First Name:</label>
    <input type="text" name="firstname"/><br>
    <div>
    <?php
        if(!empty($fName_err))
            echo '<span id="reder">'. $fName_err .'</span>';
    ?>
    </div>

    <label>Last Name:</label>
    <input type="text" name="lastname"/><br>
    <div>
    <?php
        if(!empty($lName_err))
            echo '<span id="reder">'. $lName_err .'</span>';
    ?>
    </div>

    <label>Age:</label>
    <input type="number" name="age" min="4" max="200"/><br>
    <div>
    <?php
        if(!empty($age_err))
            echo '<span id="reder">'. $age_err .'</span>';
    ?>
    </div>

    <label>Phone Number:</label>
    <input type="tel" name="tele"/><br>
    <div>
    <?php
        if(!empty($tNumber_err))
            echo '<span id="reder">'. $tNumber_err .'</span>';
    ?>
    </div>

    <label>Email:</label>
    <input type="email" name="email"/><br>
    <div>
    <?php
        if(!empty($email_err))
            echo '<span id="reder">'. $email_err .'</span>';
    ?>
    </div>

    <label>Status:</label>
    <select name="status">
      <option value="None">None</option>
      <option value="CollegeStudent">College Student</option>
      <option value="Veteran">Veteran</option>
      <option value="Senior">Senior</option>
      <option value="Child">Child</option>
    </select><br>
    <label>Date:</label>
    <input type="date" id="start" name="sDate" value="2022-03-26" min="2022-01-01" max="9999-12-31"><br>
    <p></p>
    <link rel="stylesheet" href="Collections/Coll2.css">
    <style>
         .button-51 {
            right:-10px;
         }
    </style>
    <input type="submit" name=submit class="button-51" role="button" value="Buy Tickets"/>
    </form>  

    <link rel="stylesheet" href="Collections/Coll.css">
    <style>
         .button-56 {
            right:0px;
         }
    </style>
    <nav class="nav-item"><a href="front.php"><button class="button-56" role="button">Return</button></a></nav>
    <p></p>
  <p></p>

</div>
</body>
</html>