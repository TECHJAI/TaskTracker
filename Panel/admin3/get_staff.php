<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../CSS/nav.css">
    <link rel="stylesheet" href="../../CSS/home.css">
    <link rel="stylesheet" href="../../CSS/form.css">
    <link rel="stylesheet" href="../../CSS/page_loader.css">
    <script src="../../JS/loader.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="preloader" id="preloader">
        <img src="../../IMG/preloader.gif" alt="Loading...">
    </div>
<?php
        include "task_analysis.php";
        $admin_id = $_SESSION['log_id'];
        $log_result = $db -> query("SELECT * FROM staff WHERE log_id='$admin_id'") or die($db -> error());
        $log_row = $log_result -> fetch_array();
    ?>
    <img src="../../IMG/logo.jpg" alt="KIOT logo">
    <div class="menu-bar">
        <ul>
            <li class="active"><a href="index.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="#"><?php if($imed_nc == 0){ ?><i class="fa-solid fa-eye"></i><?php }else{?><i class="fa-solid fa-eye fa-fade"></i> <?php } ?>ViewTask</a>
                <div class="sub-menu-1">
                    <ul>
                        <li><a href="onetime_task.php">Single Time</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#"><i class="fa-solid fa-plus"></i> AddTask</a>
                <div class="sub-menu-1">
                    <ul>
                        <li class="hover-me"><a href="get_staff.php">Single Time</a><i class="fa fa-angle-right"></i></li>
                    </ul>
                </div>
            </li>
            
            <li><a href="#"><i class="fa-solid fa-circle-info"></i> More</a>
                <div class="sub-menu-1">
                    <ul>
                        <li><a href="changeip.php">Change ID/Password</a></li>
                        <li><a href="changemail.php">Change Email</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../../index.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <?php require 'process_staff_task.php'; 
    require "../../db.php";
    $department = $log_row["Dept"];
    ?>
    <div class = "container login-cont">
        <div class="form-box px-5 py-4">
            <form action="process_staff_task.php" method="post">
            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
            <input type="hidden" name="dep" value="<?php echo $department; ?>">

            <label>Task :</label>
            <input type="text" name="Task" class="form-control" value="<?php echo $Task; ?>" placeholder="What is the task"><br>

            <label>Assign To :</label><br>
            <select name="Assign_To" id="subject">
                <option value="" selected="selected">Who's task is this</option>
                <option value="all">To all Members</option>
                <?php 
                    $sql = "SELECT * FROM staff  WHERE Dept='$department'";
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

                <button type="submit" name="save" class="subm-btn form-control" onclick="showPreloader()">Save</button>

            <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>