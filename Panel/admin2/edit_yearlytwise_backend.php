<?php  
require "../../db.php";
$ID = 0;
$update = false;
$Date = '';
$Event = '';
$R_date = '';
$Remarks = '';

if (isset($_POST['save'])) {
	
	$Date = $_POST['Date'];
	$Event = $_POST['Event'];
	$R_date = $_POST['R_date'];
	$Remarks = $_POST['Remarks'];

	if($Date>$R_date || $Date == $R_date)
	{
		echo "<script>
			window.location.href='edit_yearlytwise.php';
			alert('Please enter the date in correct order');
		</script>";
	}
	else
	{
		$db -> query("INSERT INTO y_t_event(Date,Event,R_date,Remarks) values('$Date','$Event','$R_date','$Remarks')") or die($db -> error());

		header("location:yearlytwise.php");
	}

}

if (isset($_GET['delete'])) {
	$ID = $_GET['delete'];

	$db -> query("DELETE FROM y_t_event WHERE ID='$ID'") or die($db -> error());

	header("location:yearlytwise.php");
}

if (isset($_GET['edit'])) {
	$ID = $_GET['edit'];
	$update = true;
	$result = $db -> query("SELECT * FROM y_t_event WHERE ID='$ID'") or die($db -> error());

	
		$row = $result -> fetch_array();
		$Date = $row['Date'];
		$Event = $row['Event'];
		$R_date = $row['R_date'];
		$Remarks = $row['Remarks'];
	
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$Date = $_POST['Date'];
	$Event = $_POST['Event'];
	$R_date = $_POST['R_date'];
	$Remarks = $_POST['Remarks'];

	$db -> query("UPDATE y_t_event SET Date = '$Date',Event = '$Event',R_date = '$R_date',Remarks = '$Remarks' WHERE ID='$ID'") or die($db -> error());

	header("location:yearlytwise.php");
}

?>