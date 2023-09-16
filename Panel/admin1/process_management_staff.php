<?php 
require "../../db.php";

$id = 0;
$update = false;
$Name = '';
$Role = '';
$log_id= '';
$pss= '';

if (isset($_GET['Remove'])) {
	$ID = $_GET['Remove'];

	$db -> query("DELETE FROM administrator WHERE ID='$ID'") or die($db -> error());

	header("location:show_management_staff.php");
}

if (isset($_GET['Yes'])) {
	$ID = $_GET['Yes'];

	$db -> query("UPDATE administrator SET control = 1 WHERE ID='$ID'") or die($db -> error());

	header("location:show_management_staff.php");
}

if (isset($_GET['No'])) {
	$ID = $_GET['No'];

	$db -> query("UPDATE administrator SET control = 0 WHERE ID='$ID'") or die($db -> error());

	header("location:show_management_staff.php");
}

if (isset($_GET['Change'])) {
	$ID = $_GET['Change'];
	$update = true;
	$result = $db -> query("SELECT * FROM administrator WHERE ID='$ID'") or die($db -> error());

	
	$row = $result -> fetch_array();
	$Name = $row['Name'];
	$Role = $row['Role'];
	$log_id = $row['log_id'];
	$pss = $row['pss'];
}

if (isset($_POST['update'])) {
	
	$ID = $_POST['ID'];
	$Name = mysqli_real_escape_string($db,$_POST['Name']);
	$Role = mysqli_real_escape_string($db,$_POST['Role']);
	$log_id = mysqli_real_escape_string($db,$_POST['log_id']);
	$pss = mysqli_real_escape_string($db,$_POST['pss']);

	$db -> query("UPDATE administrator SET Name = '$Name',Role = '$Role',log_id = '$log_id',pss = '$pss' WHERE ID='$ID'") or die($db -> error());

	header("location:show_management_staff.php");
}


?>