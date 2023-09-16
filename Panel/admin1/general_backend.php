<?php

if (isset($_POST['save_change'])) {
    include "../../db.php";
    $ID = $_POST['ID'];
    $Begins = date("y-m-d");

    $Task = mysqli_real_escape_string($db,$_POST['task']);
    $Ends = $_POST['deadline'];
    $Remarks = mysqli_real_escape_string($db,$_POST['remark']);
    header("location:onetime_task.php");

    $db -> query("UPDATE tasks SET Task = '$Task',Begins = '$Begins',Ends = '$Ends',Remarks = '$Remarks' WHERE ID='$ID'") or die($db -> error());
    
    
} 

?>