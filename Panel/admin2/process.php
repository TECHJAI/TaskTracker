<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require "../../db.php";

$id = 0;
$update = false;
$Begins = '';
$From1 = '';
$Task = '';
$To2 = '';
$Dep2 = '';
$Ends = '';
$Remarks = '';
$email = '';

if (isset($_POST['save'])) {

	session_start();
	$admin_id = $_SESSION['log_id'];
	$temp_result = $db -> query("SELECT * FROM hod WHERE log_id='$admin_id'") or die($db -> error());
	$temp_row = $temp_result -> fetch_array();
	$admin_name = $temp_row['Name'];
	$From1 = mysqli_real_escape_string($db,$admin_name);
	$Role1 = mysqli_real_escape_string($db,$temp_row['Role']);
	$Dep1 = "";

	/*$To2 = mysqli_real_escape_string($mysqli,$_POST['Assign_To']);
	$to_res = $mysqli -> query("SELECT * FROM hod WHERE Name='$To2'");
	$to_row = $to_res -> fetch_array();
	
	$Dep2 = $to_row['Dept'];
	$Dep2 = "/".$Dep2;
	$Dep2 = mysqli_real_escape_string($mysqli,$Dep2); */
	
	$Begins = date("y-m-d");

	$Role2 = "HOD";
	
	$Task = mysqli_real_escape_string($db,$_POST['Task']);
	
	$Ends = $_POST['Dead_Line'];
	$Remarks = mysqli_real_escape_string($db,$_POST['Remarks']);

	if(strtotime($Begins)<=strtotime($Ends))
	{

				$Assign_To = $_POST['Assign_To'];

				foreach($Assign_To as $item)
				{
					$tem = mysqli_real_escape_string($db,$item);
					$tem_res = $db -> query("SELECT * FROM hod WHERE Name='$tem'");
					$tem_row = $tem_res -> fetch_array();
					$Dep2 = $tem_row['Dept'];
					$Dep2 = "/".$Dep2;
					$Dep2 = mysqli_real_escape_string($db,$Dep2);
					$db -> query("INSERT INTO tasks(From1,Role1,Dep1,To2,Role2,Dep2,Task,Begins,Ends,Remarks) values('$From1','$Role1','$Dep1','$item','$Role2','$Dep2','$Task','$Begins','$Ends','$Remarks')");
					
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
							$mail->addAddress($tem_row['email']);     //Add a recipient
						
							//Content
							$mail->isHTML(true);                                  //Set email format to HTML
							$mail->Subject = $Begins;
							$mail->Body    = 'Dear Sir/Madam, <br>    You got a new task. For more details follow the description.
							<br><br><br>
							<b>From : </b>'.$From1.' ['.$Role1.']<br>
							<b>Deadline : </b>'.$Ends.'<br>
							<b>Task : </b>'.$Task.'<br>
							<b>Remarks : </b>'.$Remarks.'<br><br>
							Thank you for reading,<br>
							Have a energetic day Sir/Madam.';
							$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
						
							$mail->send();
							echo 'Message has been sent';
						} catch (Exception $e) {
							echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
						}
				}
		

		$_SESSION['message'] = "Record has been saved...";
		$_SESSION['msgtype'] = "Success";

		header("location:onetime_task.php");
	}
	else
	{
		echo "You want to give a reasonable  date";
	}

	
}

if (isset($_GET['delete'])) {
	$ID = $_GET['delete'];

	$db -> query("DELETE FROM tasks WHERE ID='$ID'") or die($db -> error());

	$_SESSION['message'] = "Record has been deleted...";
	$_SESSION['msgtype'] = "danger";

	header("location:Task.php");
}

if (isset($_GET['edit'])) {
	$ID = $_GET['edit'];
	$update = true;
	$result = $db -> query("SELECT * FROM tasks WHERE ID='$ID'") or die($db -> error());

	
		$row = $result -> fetch_array();

		$To2 = mysqli_real_escape_string($db,$row['To2']);

		$Task = mysqli_real_escape_string($db,$row['Task']);
		$Assign_To = $row['To2'];
		$Dead_Line = $row['Ends'];
		$Remarks = $row['Remarks'];
	
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$Begins = date("y-m-d");

	$Task = mysqli_real_escape_string($db,$_POST['Task']);

	$Ends = $_POST['Dead_Line'];
	$Remarks = mysqli_real_escape_string($db,$_POST['Remarks']);

	$db -> query("UPDATE tasks SET Task = '$Task',Begins = '$Begins',Ends = '$Ends',Remarks = '$Remarks' WHERE ID='$ID'") or die($db -> error());

	$_SESSION['message'] = "Record has been updated successfully...";
	$_SESSION['msgtype'] = "warning";

	header("location:onetime_task.php");
}

if (isset($_GET['State'])) {
	
	$ID = $_GET['State'];
	$change = "comp";

	$result = $db -> query("SELECT * FROM tasks WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['State'];
	settype($val, "integer");

	$db -> query("UPDATE tasks SET State = '$change' WHERE ID='$ID'") or die($db -> error());

	header("location:onetime_task.php");
}

if (isset($_GET['undo'])) {
	
	$ID = $_GET['undo'];
	$change = "Not";

	$result = $db -> query("SELECT * FROM tasks WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['State'];
	settype($val, "integer");

	$db -> query("UPDATE tasks SET State = '$change' WHERE ID='$ID'") or die($db -> error());

	header("location:onetime_task.php");
}

if (isset($_GET['acces'])) {
	
	$ID = $_GET['acces'];
	$change = "comp";

	$result = $db -> query("SELECT * FROM tasks WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['State'];
	settype($val, "integer");

	$db -> query("UPDATE tasks SET State = '$change' WHERE ID='$ID'") or die($db -> error());

	header("location:onetime_task.php");
}

if (isset($_GET['Re-assign'])) {
	$ID = $_GET['Re-assign'];
	$update = true;
	$result = $db -> query("SELECT * FROM tasks WHERE ID='$ID'") or die($db -> error());

	
		$row = $result -> fetch_array();
		$Dead_Line = $row['Ends'];	
}

if (isset($_POST['re-assign'])) {
	
	$ID = $_POST['ID'];
	$Dead_Line = $_POST['Dead_Line'];
	$change = "Not";

	$mysqli -> query("UPDATE tasks SET Ends = '$Dead_Line',State = '$change' WHERE ID='$ID'") or die($mysqli -> error());

	$_SESSION['message'] = "Record has been updated successfully...";
	$_SESSION['msgtype'] = "warning";

	header("location:onetime_task.php");
}

 ?>