<?php
require "../../db.php";
session_start();
$admin_id = $_SESSION['log_id'];
$temp_result = $db -> query("SELECT * FROM staff WHERE log_id='$admin_id'") or die($db -> error());
$temp_row = $temp_result -> fetch_array();
$admin_name = $temp_row['Name'];

$sql_task = "SELECT * FROM tasks WHERE From1='$admin_name' OR To2='$admin_name'";
$result = $db->query($sql_task);

$sql_task_comp = "SELECT * FROM tasks WHERE state='comp' AND (From1='$admin_name' OR To2='$admin_name')";
$result_comp = $db->query($sql_task_comp);

$sql_task_nc = "SELECT * FROM tasks WHERE state='Not' AND (From1='$admin_name' OR To2='$admin_name')";
$result_nc = $db->query($sql_task_nc);

$tot_task = 0;
$tot_comp_task = 0;

$imed_tot_task = 0;
$urgt_tot_task = 0;
$impt_tot_task = 0;
$reg_tot_task = 0;
$expr_tot_task = 0;

$imed_comp_task = 0;
$urgt_comp_task = 0;
$impt_comp_task = 0;
$reg_comp_task = 0;
$expr_comp_task = 0;

$imed_nc_task = 0;
$urgt_nc_task = 0;
$impt_nc_task = 0;
$reg_nc_task = 0;
$expr_nc_task = 0;

//----------------------------------------------------------------------------------------------------task
if($result->num_rows>0)
{

	

  while ($row_task = $result->fetch_assoc())
  {

    $now_task = time(); // or your date as well
		$last_date_task = strtotime($row_task['Ends']);
		$datediff_task = $last_date_task - $now_task;

		$diff_task = round(($datediff_task / (60 * 60 * 24))+1);

    	if($diff_task == 0)
    	{
    		$imed_tot_task++;
    	}
    	elseif($diff_task == 1)
    	{
    		$urgt_tot_task++;
    	}
    	elseif ($diff_task == 2) 
    	{
    		$impt_tot_task++;
    	}
    	elseif($diff_task > 2)
    	{
    		$reg_tot_task++;
    	}

    	$tot_task++;
  }
}

//--------------------------------------------------------------------------------------------task comp
$comp_t = 0;

if($result_comp->num_rows>0)
{
	
	while ($row_comp_task = $result_comp->fetch_assoc())
  {

    $now_comp_task = time(); // or your date as well
		$last_date_comp_task = strtotime($row_comp_task['Ends']);
		$datediff_comp_task = $last_date_comp_task - $now_comp_task;

		$diff_comp = round(($datediff_comp_task / (60 * 60 * 24))+1);

    	if($diff_comp == 0)
    	{
    		$imed_comp_task++;
    	}
    	elseif($diff_comp == 1)
    	{
    		$urgt_comp_task++;
    	}
    	elseif ($diff_comp == 2) 
    	{
    		$impt_comp_task++;
    	}
    	elseif($diff_comp > 2)
    	{
    		$reg_comp_task++;
    	}
    	
    	$comp_t++;

  }
}

//------------------------------------------------------------------------------------------task nc
if($result_nc->num_rows>0)
{
	while ($row_nc_task = $result_nc->fetch_assoc())
  {

    $now_nc_task = time(); // or your date as well
		$last_date_nc_task = strtotime($row_nc_task['Ends']);
		$datediff_nc_task = $last_date_nc_task - $now_nc_task;
		$nc_task = $row_nc_task['State'];

		$diff_nc = round(($datediff_nc_task / (60 * 60 * 24))+1);

    	if($diff_nc == 0)
    	{
    		$imed_nc_task++;
    	}
    	elseif($diff_nc == 1)
    	{
    		$urgt_nc_task++;
    	}
    	elseif ($diff_nc == 2) 
    	{
    		$impt_nc_task++;
    	}
    	elseif($diff_nc > 2)
    	{
    		$reg_nc_task++;
    	}
    	else
    	{
    		$expr_tot_task++ ;
    	}

  }
}

	$tot = $tot_task;
	$comp = $comp_t;

	$imed_tot = $imed_tot_task;
	$urgt_tot = $urgt_tot_task;
	$impt_tot = $impt_tot_task;
	$reg_tot = $reg_tot_task;
	$expr_tot = $expr_tot_task;

	$imed_comp = $imed_comp_task;
	$urgt_comp = $urgt_comp_task;
	$impt_comp = $impt_comp_task;
	$reg_comp = $reg_comp_task;

	$imed_nc = $imed_nc_task;
	$urgt_nc = $urgt_nc_task;
	$impt_nc = $impt_nc_task;
	$reg_nc = $reg_nc_task;
?>