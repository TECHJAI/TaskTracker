<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php

include "../../db.php";

//-----------------------------------------Single Time Task BackEnd---------------------------------------
// To delete the task.
if (isset($_GET['delete'])) {
    $ID = $_GET['delete'];
    $db -> query("DELETE FROM tasks WHERE ID='$ID'") or die($db -> error());
    header("location:onetime_task.php");
}

// To mark the task as completed.
if (isset($_GET['complete_state'])) {
	
	$ID = $_GET['complete_state'];
	$change = "comp";
    $db -> query("UPDATE tasks SET State = '$change' WHERE ID='$ID'") or die($db -> error());
    header("location:onetime_task.php");
}

// To mark the task as not completed.
if (isset($_GET['incomplete_state'])) {
	
	$ID = $_GET['incomplete_state'];
	$change = "Not";
    $db -> query("UPDATE tasks SET State = '$change' WHERE ID='$ID'") or die($db -> error());
    header("location:onetime_task.php");
}

// To mark the task as requested.
if (isset($_GET['request_state'])) {
	
	$ID = $_GET['request_state'];
	$change = "req";
    $db -> query("UPDATE tasks SET State = '$change' WHERE ID='$ID'") or die($db -> error());
    header("location:onetime_task.php");
}

//---------------------------------Yearly Task BackEnd--------------------------------------------------------
if (isset($_GET['delete_yearly'])) {
    $ID = $_GET['delete_yearly'];
    $db -> query("DELETE FROM y_once WHERE ID='$ID'") or die($db -> error());
    header("location:yearlyonce.php");
}
?>
</body>
</html>