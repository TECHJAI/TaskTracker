<?php 
require "../../db.php";
if (isset($_POST['save'])) {
	$aname = $_POST['uname'];
	$o_apass = $_POST['upass'];
	$apass = $_POST['cpass'];

	session_start();
	$admin_id = $_SESSION['log_id'];

	$result = $db -> query("SELECT * FROM administrator WHERE log_id='$admin_id'") or die($db -> error());
	$row = $result -> fetch_array();

	//For level-1 admin
    $qry1 = "SELECT * FROM administrator WHERE log_id='{$aname}'";
    $result1 = $db->query($qry1);

    //Form level-2 admin
    $qry2 = "SELECT * FROM HOD WHERE log_id='{$aname}'";
    $result2 = $db->query($qry2);

    //Form level-3 admin
    $qry3 = "SELECT * FROM staff WHERE log_id='{$aname}'";
    $result3 = $db->query($qry3);

    $qry4 = "SELECT * FROM staff_registration WHERE username='{$aname}'";
    $result4 = $db->query($qry4);

    if ($result1->num_rows>0) {
        $check = $result1->fetch_assoc();
        $aname = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='changeip.php';
                </script>";
    }
    elseif($result2->num_rows>0) {
        $check = $result2->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='changeip.php';
                </script>";
    }
    elseif($result3->num_rows>0) {
        $check = $result3->fetch_assoc();
        $username = $check["log_id"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='changeip.php';
                </script>";
    }
    elseif($result4->num_rows>0) {
        $check = $result4->fetch_assoc();
        $username = $check["username"];
        echo "<script>
                    alert('This username is already exist.');
                    window.location.href='changeip.php';
                </script>";
    }
	else{
		
		if ($o_apass==$apass) 
		{
			$db -> query("UPDATE administrator SET log_id = '$aname',pss = '$apass' WHERE log_id='$admin_id'") or die($db -> error());
			echo "<script>
                    alert('Your Data login data is successfully updated.');
                    window.location.href='../../index.php';
                </script>";
		}
		else
		{
			echo "<script>
			window.location.href='changeip.php';
			alert('Your passwords are mismatch');
			</script>";
		}
	}	
}
 ?>