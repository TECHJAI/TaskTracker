<?php
require "../../db.php";

$user_id = $_SESSION['log_id'];
$dep_result = $db -> query("SELECT * FROM hod WHERE log_id='$user_id'") or die($db -> error());
$dep_row = $dep_result -> fetch_array();
$user_dep = $dep_row['Dept'];

$sql = "SELECT * FROM staff_registration WHERE department='$user_dep'";
$result = $db->query($sql);
$app = 0;
if($result->num_rows>0)	
{
    while ($row = $result->fetch_assoc()) {
        $app++;
    }
}
?>