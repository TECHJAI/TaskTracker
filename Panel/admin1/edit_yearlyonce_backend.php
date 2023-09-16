<?php  
require "../../db.php";
$ID = 0;
$update = false;
$Date = '';
$Event = '';
$E_event = '';
$Remarks = '';

if (isset($_POST['save'])) {
	
	$Date = $_POST['Date'];
	$Event = $_POST['Event'];
	$E_event = $_POST['E_event'];
	$Remarks = $_POST['Remarks'];

	
	if(empty($E_event)){
		$E_event = $Date;
	}
	$db -> query("INSERT INTO y_once(Date,Event,E_event,Remarks) values('$Date','$Event','$E_event','$Remarks')") or die($db -> error());

	header("location:yearlyonce.php");

}

if (isset($_GET['delete'])) {
	$ID = $_GET['delete'];

	$db -> query("DELETE FROM y_once WHERE ID='$ID'") or die($db -> error());

	header("location:yearlyonce.php");
}

if (isset($_GET['edit'])) {
	$ID = $_GET['edit'];
	$update = true;
	$result = $db -> query("SELECT * FROM y_once WHERE ID='$ID'") or die($db -> error());

	
		$row = $result -> fetch_array();
		$Date = $row['Date'];
		$Event = $row['Event'];
		$E_event = $row['E_event'];
		$Remarks = $row['Remarks'];
	
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$Date = $_POST['Date'];
	$Event = $_POST['Event'];
	$E_event = $_POST['E_event'];
	$Remarks = $_POST['Remarks'];

	$db -> query("UPDATE y_once SET Date = '$Date',Event = '$Event',E_event = '$E_event',Remarks = '$Remarks' WHERE ID='$ID'") or die($db -> error());

	header("location:yearlyonce.php");
}

?>