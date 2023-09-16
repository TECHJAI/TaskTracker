<?php
require "../../db.php";
$sql = "SELECT * FROM authority_registration";
$result = $db->query($sql);
$app = 0;
if($result->num_rows>0)	
{
    while ($row = $result->fetch_assoc()) {
        $app++;
    }
}
?>