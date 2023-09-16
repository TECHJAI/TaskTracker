<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../CSS/form.css">
    <link rel="stylesheet" href="../../CSS/nav.css">
    <link rel="stylesheet" href="../../CSS/page_loader.css">
    <script src="../../JS/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="preloader" id="preloader">
        <img src="../../IMG/preloader.gif" alt="Loading...">
    </div>
<?php
        include "task_analysis.php";
        include "identifier.php";
        $admin_id = $_SESSION['log_id'];
        $log_result = $db -> query("SELECT * FROM administrator WHERE log_id='$admin_id'") or die($db -> error());
        $log_row = $log_result -> fetch_array();
    ?>
    <img src="../../IMG/logo.jpg" alt="KIOT logo">
    <div class="menu-bar">
        <ul>
            <li class="active"><a href="index.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="#"><?php if($imed_nc == 0){ ?><i class="fa-solid fa-eye"></i><?php }else{?><i class="fa-solid fa-eye fa-fade"></i> <?php } ?>View Task</a>
                <div class="sub-menu-1">
                    <ul>
                        <li><a href="onetime_task.php">Single Time</a></li>
                        <li><a href="yearlytwise.php">Yearly Twise</a></li>
                        <li><a href="yearlyonce.php">Yearly Once</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#"><i class="fa-solid fa-plus"></i> Add Task</a>
                <div class="sub-menu-1">
                    <ul>
                        <li class="hover-me"><a href="#">Single Time</a><i class="fa fa-angle-right"></i>
                            <div class="sub-menu-2">
                                <ul>
                                    <li><a href="hod_get.php">HoD</a></li>
                                    <li><a href="admin_get.php">Management Staff</a></li>
                                    <li><a href="s_and_h_get.php">S&H Staff</a></li>
                                    <li><a href="dpt_select.php">Teaching staff</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="edit_yearlytwise.php">Yearly Twise</a></li>
                        <li><a href="edit_yearlyonce.php">Yearly Once</a></li>
                    </ul>
                </div>
            </li>
            <?php 			
			if($log_row['control'] == 1){ 
            ?>
            <li><a href="approval.php"><?php if($app == 0){ ?><i class="fa-solid fa-id-card-clip"></i><?php }else{?><i class="fa-solid fa-id-card-clip fa-fade"></i><?php } ?>Approvals</a></li>
            <?php } ?>
            <li><a href="#"><i class="fa-solid fa-circle-info"></i> More</a>
                <div class="sub-menu-1">
                    <ul>
                        <li><a href="changeip.php">Change ID/Password</a></li>
                        <li><a href="changemail.php">Change Email</a></li>
                        <?php 			
                        if($log_row['control'] == 1){ 
                        ?>
                        <li><a href="show_hod_data.php">HoD</a></li>
                        <li><a href="show_management_staff.php">Management staff</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <li><a href="../../index.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>
    <?php require 'process_add_sandh.php'; 
    require "../../db.php";
    $department = "MECH";
    ?>
    <div class = "container login-cont">
        <div class="form-box px-5 py-4">
            <form action="process_add_sandh.php" method="post">
            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
            <input type="hidden" name="dep" value="<?php echo $department; ?>">

            <label>Task :</label>
            <input type="text" name="Task" class="form-control" value="<?php echo $Task; ?>" placeholder="What is the task"><br>

            <label>Assign To :</label><br>
            <select name="Assign_To" id="subject">
                <option value="" selected="selected">Who's task is this</option>
                <option value="all">To all Members</option>
                <?php 
                    $sql = "SELECT * FROM staff  WHERE Dept='MECH'";
                    $result = $db->query($sql);
                    $list1 = [];
                    $num = 0;
                    
                    if($result->num_rows>0)
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            $list1[$num] = $row['Name'];
                            $list2[$num] = $row['Role2'];
                            $list3[$num] = $row['Dept'];
                            $num++;
                        }
                    }

                    $list1 =$list1;
                    
                    $list3 = $list3;
                    $num1 = sizeof($list1);

                    for($i = 0;$i<$num1;$i++)
                    { ?>
                        <option value="<?php echo $list1[$i]; ?>" type="checkbox" name="Assign_To[]" class="checkitem"><?php echo $list1[$i].'-'.$list2[$i].'-'.$list3[$i];?></option>
                    <?php } ?>
            </select><br>
            
            <label>Dead Line :</label>
            <input type="date" name="Dead_Line" class="form-control" value="<?php echo $Dead_Line; ?>"><br>
            <label>Remarks :</label>
            <input type="text" name="Remarks" class="form-control" value="<?php echo $Remarks; ?>" placeholder="Enter any remarks here"><br>

            <?php if ($update == true): ?>

                <button type="submit" name="update" class="subm-btn form-control" onclick="showPreloader()">Save Changes</button>
                
            <?php else: ?>

                <button type="submit" name="t_save" class="subm-btn form-control" onclick="showPreloader()">Save</button>

            <?php endif; ?>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script>
		$("#checkall").change(function(){
			$(".checkitem").prop("checked",$(this).prop("checked"))
		})

		var expanded = false;
		function showcheckboxes() {
			var checkboxes = document.getElementById("checkboxes");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
			} else {
				checkboxes.style.display = "none";
				expanded = false;
			}
		}
	</script>
</body>
</html>