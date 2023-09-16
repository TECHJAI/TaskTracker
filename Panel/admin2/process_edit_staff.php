<?php 
require "../../db.php";
$admin_id = $_SESSION['log_id'];
$temp_result = $db -> query("SELECT * FROM hod WHERE log_id='$admin_id'") or die($db -> error());
$temp_row = $temp_result -> fetch_array();
$admin_dpt = $temp_row['Dept'];

$id = 0;
$update = false;
$Name = '';
$Dept = '';
$log_id= '';
$pass= '';

if (isset($_GET['Remove'])) {
	$ID = $_GET['Remove'];

	$db -> query("DELETE FROM staff WHERE sno='$ID'") or die($db -> error());

	header("location:show_hod_data.php");
}

if (isset($_GET['Change'])) {
	$ID = $_GET['Change'];
	$update = true;
	$result = $db -> query("SELECT * FROM staff WHERE ID='$ID'") or die($db -> error());

	
	$row = $result -> fetch_array();
    $ID = $row['ID'];
	$Name = $row['Name'];
    $primitive = $row['Role2'];
	$Dept = $row['Dept'];
	$dep_id = $row['log_id'];
	$pass = $row['pass'];
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$Name = mysqli_real_escape_string($db,$_POST['Name']);
    $primitive = mysqli_real_escape_string($db,$_POST['primitive']);
	$log_id = mysqli_real_escape_string($db,$_POST['log_id']);
	$pass = mysqli_real_escape_string($db,$_POST['pass']);

	$db -> query("UPDATE staff SET Name = '$Name',Role2 = '$primitive',log_id = '$log_id',pass = '$pass' WHERE ID='$ID'") or die($db -> error());

	header("location:staff_data.php");
}


?>