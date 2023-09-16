<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require "../../db.php";

if (isset($_POST['savemail'])) {
	$mail1 = $_POST['mail1'];
    $mail2 = $_POST['mail2'];

	session_start();
	$admin_id = $_SESSION['log_id'];

	if ($mail1==$mail2) 
	{
		$db -> query("UPDATE administrator SET email = '$mail1' WHERE log_id='$admin_id'") or die($db -> error());

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
							$mail->addAddress($mail1);     //Add a recipient
						
							//Content
							$mail->isHTML(true);                                  //Set email format to HTML
							$mail->Subject = 'Mail registered.';
							$mail->Body    = 'Dear Sir/Mam, <br><br>
							Your mail got registered and you will be receive your task notifications by this id. You can change your notification mail at any time.<br>
							Have a Nice day.<br><br>
							Thank you Sir/Mam.';
							$mail->AltBody = 'Task Traker Message';
						
							$mail->send();
							
						} catch (Exception $e) {
							echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
						}

		echo "<script>alert('Please check your mail for your varification.');
		window.location.href='index.php';</script>";
	}
	else
	{
		echo "<script>
		window.location.href='change_ip.php';
        alert('Please enter the correct ID or Password');
       	</script>";
	}	
}
 ?>