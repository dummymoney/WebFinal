<?php 
$dbServername = "team12.copftkcel1k2.us-east-1.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "Group12,museum";
$dbName = "FinalTeam12";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");

$sql="SELECT * FROM Notifications"; 
$result = mysqli_query($connect, $sql) or die ('Error querying database.'); 

$cName = $email = "";
if ($row = mysqli_fetch_array($result)) {
    $cName= $row['cName'];
    $email= $row['Email'];
    $sql2="DELETE FROM Notifications WHERE EID >= 1"; 
    if(mysqli_query($connect, $sql2)){
        echo "Records were deleted successfully.";
    } else{
        echo "ERROR: Could not able to execute";
    }
}
var_dump($result);
//Block 8
mysqli_close($connect);
if($email == "" || $email != "Dummy.Email1768@gmail.com"){
    header("location: ratings.php");
    exit();
}

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
require './vendor/autoload.php';

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 'michael.scofield624@gmail.com';
$senderName = 'Museum';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = $email;

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AKIA5MPRFK3B2R23UFHN';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = 'BAoA67axgDqvvQZQDsneVtRIL7cVIN3b60yC6BeaOI1E';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.us-east-1.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = 'Ticket';

// The plain-text body of the email
$bodyText =  "Bought Ticket";

// The HTML-formatted body of the email
$bodyHtml = '<h3>Dear '.$cName.'</h3> <p>Thank you for purchasing tickets</p>';

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
  //  $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();
    echo "Email sent!" , PHP_EOL;
    header("location: ratings.php");
    exit();
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}
?>