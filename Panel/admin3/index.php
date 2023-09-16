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
    <link rel="stylesheet" href="../../CSS/footer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
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

    <div class="form_out">  
        <div class="form1">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Today Expires : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $imed_nc; ?>/<?php echo $imed_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Tomorrow Expires : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $urgt_nc; ?>/<?php echo $urgt_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">3rd day Expires : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $impt_nc; ?>/<?php echo $impt_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">	
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Regular waiting : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $reg_nc; ?>/<?php echo $reg_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Total Expired : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $expr_tot; ?>/<?php echo $tot; ?></span>
                </li>
            </ol>
        </div>

        <div class="form2">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Today's Completion : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $imed_comp; ?>/<?php echo $imed_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Tomorrow's Completion: </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $urgt_comp; ?>/<?php echo $urgt_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">3rd day's Completion : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $impt_comp; ?>/<?php echo $impt_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">	
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Regular Completion : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $reg_comp; ?>/<?php echo $reg_tot; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Total Completion : </div>
                    
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo $comp; ?>/<?php echo $tot; ?></span>
                </li>
            </ol>
        </div>
    </div>
    <center>
        <h1 align="center" class="heading"> Knowledge Institute Of Technology </h1>
        <p align="center" class="quote"> ... Your bright future begins with knowledge ... </p>
    </center>
</body>
<footer class="footer">
    <div class="footer-bottom">&copy; 2023 CRETO SOFT | <i class="fa-solid fa-envelope"></i> : <a href="mailto:cretosoft@gmail.com">cretosoft@gmail.com</a> | <i class="fa-brands fa-linkedin-in"></i> : <a href="https://www.linkedin.com/in/creto-soft-66a42a288/">CRETO Soft</a> | <i class="fa-brands fa-instagram"></i> : <a href="https://instagram.com/creto_soft?igshid=MzRlODBiNWFlZA==">@creto_soft</a> | Maintained by CRETO</div>
</footer>
</html>