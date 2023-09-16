<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Panel/vendor/autoload.php';
require "db.php";

if(isset($_POST["register"]))
{
    $name = mysqli_real_escape_string($db,$_POST['Name']);
    $email = mysqli_real_escape_string($db,$_POST['mail']);
    $primitiverole = mysqli_real_escape_string($db,$_POST['primitive']);
    $department = mysqli_real_escape_string($db,$_POST['department']);
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $password = mysqli_real_escape_string($db,$_POST['pass']);
    $cpassword = mysqli_real_escape_string($db,$_POST['cpass']);

    //For level-1 admin
    $qry1 = "SELECT * FROM administrator WHERE log_id='{$username}'";
    $result1 = $db->query($qry1);

    //Form level-2 admin
    $qry2 = "SELECT * FROM HOD WHERE log_id='{$username}'";
    $result2 = $db->query($qry2);

    //Form level-3 admin
    $qry3 = "SELECT * FROM staff WHERE log_id='{$username}'";
    $result3 = $db->query($qry3);

    $qry4 = "SELECT * FROM staff_registration WHERE username='{$username}'";
    $result4 = $db->query($qry4);

    if ($result1->num_rows>0) {
        $check = $result1->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result2->num_rows>0) {
        $check = $result2->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result3->num_rows>0) {
        $check = $result3->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result4->num_rows>0) {
        $check = $result4->fetch_assoc();
        $username = $check["username"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    else{
        if($password != $cpassword){
            echo "<script>
                    alert('Your passwords are mismatched.');
                    window.location.href='registration.php';
                    </script>";
        }
        else{
            $db -> query("INSERT INTO staff_registration(Name,email,department,primitiverole,username,password) values('$name','$email','$department','$primitiverole','$username','$password')");
    
            $mail = new PHPMailer(true);
    
            try {
                //Server settings
                
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'tasktracker541@gmail.com';                     //SMTP username
                $mail->Password   = 'jfnismcmximaofse';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('tasktracker541@gmail.com', 'Task Tracker');
                $mail->addAddress($email);     //Add a recipient
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "Registration Successful";
                $mail->Body    = 'Dear Sir/Madam, <br><p style="text-indent: 25px;">Thank you for utilizing our services. We\'re pleased to inform you that your application has been added to the waiting list for approval. Once your head approves the application, you will receive an email containing your username and password. Afterward, you\'ll be able to log in to the task tracker.<br>
                Thank you,<br>
                Have an energetic day Sir/Madam.</p>';
                $mail->AltBody = 'This message is sent by Task Tracker';
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "<script>
                    alert('Successfully registered. Please check your mail.');
                    window.location.href='index.php';
                    </script>";
        }
    }
}

if(isset($_POST["register_authority"]))
{
    $name = mysqli_real_escape_string($db,$_POST['Name']);
    $email = mysqli_real_escape_string($db,$_POST['mail']);
    $primitiverole = mysqli_real_escape_string($db,$_POST['primitive']);
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $password = mysqli_real_escape_string($db,$_POST['pass']);
    $cpassword = mysqli_real_escape_string($db,$_POST['cpass']);

    //For level-1 admin
    $qry1 = "SELECT * FROM administrator WHERE log_id='{$username}'";
    $result1 = $db->query($qry1);

    //Form level-2 admin
    $qry2 = "SELECT * FROM HOD WHERE log_id='{$username}'";
    $result2 = $db->query($qry2);

    //Form level-3 admin
    $qry3 = "SELECT * FROM staff WHERE log_id='{$username}'";
    $result3 = $db->query($qry3);

    $qry4 = "SELECT * FROM staff_registration WHERE username='{$username}'";
    $result4 = $db->query($qry4);

    $qry5 = "SELECT * FROM authority_registration WHERE username='{$username}'";
    $result5 = $db->query($qry4);

    if ($result1->num_rows>0) {
        $check = $result1->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result2->num_rows>0) {
        $check = $result2->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result3->num_rows>0) {
        $check = $result3->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result4->num_rows>0) {
        $check = $result4->fetch_assoc();
        $username = $check["username"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    elseif($result5->num_rows>0) {
        $check = $result5->fetch_assoc();
        $username = $check["username"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='registration.php';
                </script>";
    }
    else{
        if($password != $cpassword){
            echo "<script>
                    alert('Your passwords are mismatched.');
                    window.location.href='registration.php';
                    </script>";
        }
        else{
            $db -> query("INSERT INTO authority_registration(Name,email,role,username,password) values('$name','$email','$primitiverole','$username','$password')");
    
            $mail = new PHPMailer(true);
    
            try {
                //Server settings
                
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'tasktracker541@gmail.com';                     //SMTP username
                $mail->Password   = 'jfnismcmximaofse';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('tasktracker541@gmail.com', 'Task Tracker');
                $mail->addAddress($email);     //Add a recipient
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "Registration Successful";
                $mail->Body    = 'Dear Sir/Madam, <br><p style="text-indent: 25px;">Thank you for utilizing our services. We\'re pleased to inform you that your application has been added to the waiting list for approval. Once your head approves the application, you will receive an email containing your username and password. Afterward, you\'ll be able to log in to the task tracker.<br>
                Thank you,<br>
                Have an energetic day Sir/Madam.</p>';
                $mail->AltBody = 'This message is sent by Task Tracker';
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "<script>
                    alert('Successfully registered. Please check your mail.');
                    window.location.href='index.php';
                    </script>";
        }
    }
}

?>