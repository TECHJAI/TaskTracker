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
    <?php require 'process_changemail.php'; 
    require "../../db.php";
    ?>
    <div class = "container login-cont">
        <div class="form-box px-5 py-4">
            <form action="process_changemail.php" method="post">
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                <label>New Email ID :</label>
                <input type="email" name="mail1" class="form-control" placeholder="Eg: example@gmail.com"><br>
                <label>Confirm Email ID :</label>
                <input type="email" name="mail2" class="form-control" placeholder="Confirm your mail"><br>
                <button type="submit" name="savemail" class="subm-btn form-control" onclick="showPreloader()">Save</button>
            </form>
        </div>
    </div>
</body>
</html>