<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="CSS/form.css">
    <link rel="stylesheet" href="CSS/login_form_position.css">
    <link rel="stylesheet" href="CSS/bg.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<Style>
    .regbtn{
        background-image : linear-gradient(to right,  #0df128 , #e7f10d );
        text-align : center;
        text-decoration : none;
        width : 18em;
        font-weight : bold;
    }
    .regbtn:hover{
        background-image : linear-gradient(to left,  #0df128 , #e7f10d );
        
        color : black;
        font-weight : bold;
    }
    .mb-4{
        font-weight : bold;
    }
</Style>

<body>
    <?php 
    include "db.php";
    session_start(); ?>

    <div class="login-text">
        <p>Welcom to <span>TaskTracker</span></p>
        <p>Let's Begin.. Keep move on your Track...</p>
        <a href="registration_staff.php" class="regbtn subm-btn form-control">Register as Department Staff</a>
        <a href="registration_management.php" class="regbtn subm-btn form-control">Register as Management Authority</a>
    </div>
    <div class = "container login-cont">
        <div class="form-box px-5 py-4">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                <h2 class="text-center mb-4">LOGIN</h2>
                <label>User Id</label>
                <input type="text" name="userid" placeholder="Enter your Id" class="form-control" required><br>
                <label>Password</label>
                <input type="password" name="userpassword" placeholder="Enter your password" class="form-control" required><br>
                <button type="submit" name="login" class="subm-btn form-control">Login</button>
            </form>
        </div>
    </div>

    <?php 
    if(isset($_POST["login"]))
    {
        //For level-1 admin
        $qry1 = "SELECT * FROM administrator WHERE log_id='{$_POST["userid"]}' AND pss='{$_POST["userpassword"]}'";
        $result1 = $db->query($qry1);
    
        //Form level-2 admin
        $qry2 = "SELECT * FROM HOD WHERE log_id='{$_POST["userid"]}' AND pass='{$_POST["userpassword"]}'";
        $result2 = $db->query($qry2);
    
        //Form level-3 admin
        $qry3 = "SELECT * FROM staff WHERE log_id='{$_POST["userid"]}' AND pass='{$_POST["userpassword"]}'";
        $result3 = $db->query($qry3);

        if ($result1->num_rows>0) {
            $check = $result1->fetch_assoc();
            $_SESSION["log_id"] = $check["log_id"];
            $_SESSION["pss"] = $check["pss"];
            echo "<script>window.open('Panel/admin1/index.php','_self');</script>";
        }
        elseif($result2->num_rows>0) {
            $check = $result2->fetch_assoc();
            $_SESSION["log_id"] = $check["log_id"];
            $_SESSION["pass"] = $check["pass"];
            echo "<script>window.open('Panel/admin2/index.php','_self');</script>";
        }
        elseif($result3->num_rows>0) {
            $check = $result3->fetch_assoc();
            $_SESSION["log_id"] = $check["log_id"];
            $_SESSION["pass"] = $check["pass"];
            echo "<script>window.open('Panel/admin3/index.php','_self');</script>";
        }
        else{ ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Warning!</strong> Please enter correct Id and Password.
            </div>
        <?php
        }
    }
    ?>
</body>
<footer class="footer">
    <div class="footer-bottom">&copy; 2023 CRETO SOFT | <i class="fa-solid fa-envelope"></i> : <a href="mailto:cretosoft@gmail.com">cretosoft@gmail.com</a> | <i class="fa-brands fa-linkedin-in"></i> : <a href="https://www.linkedin.com/in/creto-soft-66a42a288/">CRETO Soft</a> | <i class="fa-brands fa-instagram"></i> : <a href="https://instagram.com/creto_soft?igshid=MzRlODBiNWFlZA==">@creto_soft</a> | Maintained by CRETO</div>
</footer>
</html>