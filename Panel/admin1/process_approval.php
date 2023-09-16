<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require "../../db.php";

$id = 0;
$update = false;
$Name = '';
$Dept = '';
$log_id= '';
$pass= '';

if (isset($_GET['decline'])) {
	$ID = $_GET['decline'];

	$db -> query("DELETE FROM authority_registration WHERE sno='$ID'") or die($db -> error());

	header("location:approval.php");
}

if (isset($_GET['approve'])) {
	$ID = $_GET['approve'];

	$result = $db -> query("SELECT * FROM authority_registration WHERE sno='$ID'") or die($db -> error());
    $row = $result -> fetch_array();
    $name = $row["Name"];
    $email = $row["email"];
    $role = $row["role"];
    $username = $row["username"];
    $password = $row["password"];

    $db -> query("INSERT INTO administrator(Name,Role,email,log_id,pss) values('$name','$role','$email','$username','$password')");

    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tasktracker541@gmail.com';                     //SMTP username
        $mail->Password   = 'jfnismcmximaofse';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('tasktracker541@gmail.com', 'Task Tracker');
        $mail->addAddress($email);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Authorized";
        $mail->Body    = 'Dear Sir/Madam, <br><p style="text-indent: 25px;">Your registered application has been approved by your superior. We are now at your service, so you can log in to The Task Tracker.<br>
        UserName : <b>'.$username.'</b><br>
        UserName : <b>'.$password.'</b><br>
        Thank you,<br>
        Have an energetic day Sir/Madam.</p>';
        $mail->AltBody = 'This message is sent by Task Tracker';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    $db -> query("DELETE FROM authority_registration WHERE sno='$ID'") or die($db -> error());

	header("location:approval.php");
}


?>