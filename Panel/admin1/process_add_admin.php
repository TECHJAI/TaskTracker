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
	$temp_result = $db -> query("SELECT * FROM administrator WHERE log_id='$admin_id'") or die($db -> error());
	$temp_row = $temp_result -> fetch_array();
	$admin_name = $temp_row['Name'];
	$From1 = mysqli_real_escape_string($db,$admin_name);
	$Role1 = mysqli_real_escape_string($db,$temp_row['Role']);
	$Dep1 = "";

	/*$To2 = mysqli_real_escape_string($mysqli,$_POST['Assign_To[]']);
	$to_res = $mysqli -> query("SELECT * FROM administrator WHERE Name='$To2'");
	$to_row = $to_res -> fetch_array();
	$Role2 = mysqli_real_escape_string($mysqli,$to_row['Role']);*/
	$Dep2 = "";
	
	$Begins = date("y-m-d");
	
	$Task = mysqli_real_escape_string($db,$_POST['Task']);
	
	$Ends = $_POST['Dead_Line'];
	$Remarks = mysqli_real_escape_string($db,$_POST['Remarks']);
	$To = $_POST['Assign_To'];

	if(strtotime($Begins)<=strtotime($Ends))
	{
		if($To == 'all'){
			$result = $db -> query("SELECT * FROM administrator");
			$list1 = [];
			$list2 = [];
			$list3 = [];
			$num = 0;

			if($result->num_rows>0){
				while($row = $result->fetch_assoc()){
					$list1[$num] = mysqli_real_escape_string($db,$row['Name']);
					$list2[$num] = mysqli_real_escape_string($db,$row['Role']);
					$list3[$num] = mysqli_real_escape_string($db,$row['email']);
					$num++;
				}

				$num1 = sizeof($list1);
				for($i = 0;$i<$num1;$i++){
					$db -> query("INSERT INTO tasks(From1,Role1,Dep1,To2,Role2,Dep2,Task,Begins,Ends,Remarks) values('$From1','$Role1','$Dep1','$list1[$i]','$list2[$i]','$Dep2','$Task','$Begins','$Ends','$Remarks')");
					
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
						$mail->addAddress($list3[$i]);     //Add a recipient
					
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
			}
		}
		else if($To != ''){
			$tem_res = $db -> query("SELECT * FROM administrator WHERE Name='$To'");
			$tem_row = $tem_res -> fetch_array();
			$Role2 = $tem_row['Role'];
			$Role2 = mysqli_real_escape_string($db,$Role2);
			$db -> query("INSERT INTO tasks(From1,Role1,Dep1,To2,Role2,Dep2,Task,Begins,Ends,Remarks) values('$From1','$Role1','$Dep1','$To','$Role2','$Dep2','$Task','$Begins','$Ends','$Remarks')");
					
					
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
		

		/*$Assign_To = $_POST['Assign_To'];

				foreach($Assign_To as $item)
				{
					$tem = mysqli_real_escape_string($db,$item);
					$tem_res = $db -> query("SELECT * FROM administrator WHERE Name='$tem'");
					$tem_row = $tem_res -> fetch_array();
					$Role2 = $tem_row['Role'];
					$Role2 = mysqli_real_escape_string($db,$Role2);
					//$email = $tem_row['email'];
					//$email = mysqli_real_escape_string($mysqli,$email);
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
					
				}*/

		}
		

		//$_SESSION['message'] = "Record has been saved...";
		//$_SESSION['msgtype'] = "Success";

		header("location:onetime_task.php");
	}
	



if (isset($_GET['delete'])) {
	$ID = $_GET['delete'];

	$db -> query("DELETE FROM task WHERE ID='$ID'") or die($db -> error());

	$_SESSION['message'] = "Record has been deleted...";
	$_SESSION['msgtype'] = "danger";

	header("location:onetime_task.php");
}

if (isset($_GET['edit'])) {
	$ID = $_GET['edit'];
	$update = true;
	$result = $db -> query("SELECT * FROM task WHERE ID='$ID'") or die($db -> error());

	
		$row = $result -> fetch_array();
		$F_Date = date("y-m-d");
		$Assign_From = "Principal";
		$Task = $row['Task'];
		$Assign_To = $row['Assign_To'];
		$Dead_Line = $row['Dead_Line'];
		$Remarks = $row['Remarks'];
	
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$F_Date = date("y-m-d");
	$Assign_From = "Principal";
	$Task = $_POST['Task'];
	$Assign_To = $_POST['Assign_To'];
	$Dead_Line = $_POST['Dead_Line'];
	$Remarks = $_POST['Remarks'];

	$db -> query("UPDATE task SET F_Date = '$F_Date',Assign_From = '$Assign_From',Task = '$Task',Assign_To = '$Assign_To',Dead_Line = '$Dead_Line',Remarks = '$Remarks' WHERE ID='$ID'") or die($db -> error());

	$_SESSION['message'] = "Record has been updated successfully...";
	$_SESSION['msgtype'] = "warning";

	header("location:onetime_task.php");
}

if (isset($_GET['complete'])) {
	
	$ID = $_GET['complete'];
	$change = 1;

	$result = $db -> query("SELECT * FROM task WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['complete'];
	settype($val, "integer");

	$db -> query("UPDATE task SET complete = $change WHERE ID='$ID'") or die($db -> error());

	header("location:onetime_task.php");
}

if (isset($_GET['undo'])) {
	
	$ID = $_GET['undo'];
	$change = 0;

	$result = $db -> query("SELECT * FROM task WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['complete'];
	settype($val, "integer");

	$db -> query("UPDATE task SET complete = $change WHERE ID='$ID'") or die($db -> error());

	header("location:onetime_task.php");
}

if (isset($_GET['acces'])) {
	
	$ID = $_GET['acces'];
	$change = 1;

	$result = $db -> query("SELECT * FROM task WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['complete'];
	settype($val, "integer");

	$db -> query("UPDATE task SET complete = $change WHERE ID='$ID'") or die($db -> error());

	header("location:onetime_task.php");
}

if (isset($_GET['Re-assign'])) {
	$ID = $_GET['Re-assign'];
	$update = true;
	$result = $db -> query("SELECT * FROM task WHERE ID='$ID'") or die($db -> error());

	
		$row = $result -> fetch_array();
		$Dead_Line = $row['Dead_Line'];	
}

if (isset($_POST['re-assign'])) {
	
	$ID = $_POST['ID'];
	$Dead_Line = $_POST['Dead_Line'];

	$db -> query("UPDATE task SET Dead_Line = '$Dead_Line' WHERE ID='$ID'") or die($db -> error());

	$change = 0;

	$result = $db -> query("SELECT * FROM task WHERE ID='$ID'") or die($db -> error());
	$row = $result -> fetch_array();
	$val = $row['complete'];
	settype($val, "integer");

	$db -> query("UPDATE task SET complete = $change WHERE ID='$ID'") or die($db -> error());

	$_SESSION['message'] = "Record has been updated successfully...";
	$_SESSION['msgtype'] = "warning";

	header("location:onetime_task.php");
}

 ?>