<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="CSS/form.css">
    <link rel="stylesheet" href="CSS/reg_form.css">
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/page_loader.css">
    <script src="JS/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<div class="preloader" id="preloader">
        <img src="IMG/preloader.gif" alt="Loading...">
    </div>
    <?php require "process_registration.php"; ?>
    <div class = "container register-form">
        <div class="form-box px-5 py-4">
            <form action="process_registration.php" method="post">
                <label>Name :</label>
                <input type="text" name="Name" class="form-control" placeholder="Enter your Name" required><br>
                <label>Role :</label>
                <input type="text" name="primitive" class="form-control" placeholder="Eg:Placement Director"><br>
                <label>E-mail :</label>
                <input type="text" name="mail" class="form-control" placeholder="Eg: sample@gmail.com" required><br>
                <label>User Name :</label>
                <input type="text" name="username" class="form-control" placeholder="Enter Your User Name" required><br>
                <label>Password :</label>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Enter Your Password" required>
                <input type="checkbox" onclick="password()"><label>Show Password</label><br>
                <label>Confirm Password :</label>
                <input type="password" name="cpass" id="cpass" class="form-control" placeholder="Confirm Your Password" required>
                <input type="checkbox" onclick="cpassword()"><label>Show Password</label><br>
                <button type="submit" name="register_authority" class="subm-btn form-control" onclick="showPreloader()">Register<span class="spinner"></span></button>
            </form>
        </div>
    </div>
    <script>
        function password() {
            var x = document.getElementById("pass");
            if (x.type === "password") 
            {
            x.type = "text";
            } 
            else 
            {
            x.type = "password";
            }
        }

        function cpassword() {
            var x = document.getElementById("cpass");
            if (x.type === "password") 
            {
            x.type = "text";
            } 
            else 
            {
            x.type = "password";
            }
        }
    </script>
</body>
</html>