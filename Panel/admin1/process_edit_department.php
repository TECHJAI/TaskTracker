<?php 
require "../../db.php";

$id = 0;
$update = false;
$Name = '';
$Dept = '';
$log_id= '';
$pass= '';

if (isset($_GET['Remove'])) {
	$ID = $_GET['Remove'];

	$db -> query("DELETE FROM hod WHERE ID='$ID'") or die($db -> error());

	header("location:show_hod_data.php");
}

if (isset($_GET['Change'])) {
	$ID = $_GET['Change'];
	$update = true;
	$result = $db -> query("SELECT * FROM hod WHERE ID='$ID'") or die($db -> error());

	
	$row = $result -> fetch_array();
	$Name = $row['Name'];
	$Dept = $row['Dept'];
	$dep_id = $row['log_id'];
	$pass = $row['pass'];
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$Name = mysqli_real_escape_string($db,$_POST['Name']);
	$Dept = mysqli_real_escape_string($db,$_POST['Dept']);
	$log_id = mysqli_real_escape_string($db,$_POST['log_id']);
	$pass = mysqli_real_escape_string($db,$_POST['pass']);

	$db -> query("UPDATE hod SET Name = '$Name',Dept = '$Dept',log_id = '$log_id',pass = '$pass' WHERE ID='$ID'") or die($db -> error());

	header("location:show_hod_data.php");
}


?>