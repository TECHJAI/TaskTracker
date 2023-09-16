<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../CSS/nav.css">
    <link rel="stylesheet" href="../../CSS/home.css">
    <link rel="stylesheet" href="../../CSS/table_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../../JS/search_area.js"></script>
</head>
<body>
    <img src="../../IMG/logo.jpg" alt="KIOT logo">
    <div class="menu-bar">
        <ul>
            <li class="active"><a href="index.php"><i class="fa-solid fa-house"></i>Home</a></li>
            <li><a href="../../index.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
        </ul>
    </div>
    
    <div class="table">
        <div class="table_header">
            <div class="search_area">
                <i class="fa-solid fa-magnifying-glass fa-beat"></i>
                <input type="text" id="To_inp" onkeyup="To()" placeholder="Enter the person name">
                <i class="fa-solid fa-calendar-days"></i>
                <input type="text" id="deadline_inp" onkeyup="deadline()" placeholder="Search by DeadLine">
            </div>
            <div class="pdf_btn">
                <form action="pdf_gen.php" method="POST" target="_blank"><button type="submit" name="btn-pdf" class="pdf">Generate PDF</button></form>
            </div>  
        </div>
    </div>
    <div class="table_section">
        <table id="myTable">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Id</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Task</th>
                    <th>Started on</th>
                    <th>Deadline</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Modify</th>
                    <th>Completion</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                require "../../db.php";
                $admin_id = $_SESSION['log_id'];
                include "table_backend.php";
                $temp_result = $db -> query("SELECT * FROM staff WHERE log_id='$admin_id'") or die($db -> error());
                $temp_row = $temp_result -> fetch_array();
                $admin_name = $temp_row['Name'];

                $query = "SELECT * FROM tasks WHERE From1='$admin_name' OR To2='$admin_name' ORDER BY Ends";
                $data = $db->query($query);

                $expir = "SELECT * FROM tasks WHERE From1='$admin_name' OR To2='$admin_name' ORDER BY Ends Asc";
                $ex_data = $db->query($expir);

                $complete = "SELECT * FROM tasks WHERE From1='$admin_name' OR To2='$admin_name' ORDER BY Ends";
                $com_data = $db->query($complete);

                $today = "SELECT * FROM tasks WHERE From1='$admin_name' AND Begins=CURDATE() ORDER BY date1 DESC";
                $tod_data = $db->query($today);

                $sno = 0;

                if($tod_data -> num_rows > 0)
                {
                    while($row = $tod_data -> fetch_assoc())
                    {
                        $sno += 1;
                        $date1 = date('d-m-Y h:m:s',strtotime($row["date1"]));
                        $date2 = date('d-m-Y',strtotime($row["Ends"]));
                        
                        
                        if($sno%2 == 0)
                        {
                            $cls = "even_row";
                        }
                        else
                        {
                            $cls = "odd_row";
                        }
                        

                        echo "<tr class='$cls'>";
                        echo "<td>".$sno."</td>";
                        echo "<td>".$row["ID"]."</td>";
                        echo "<td id='From_inp'>".$row["From1"]." ".$row["Role1"]." ".$row["Dep1"]."</td>";
                        echo "<td id='To_inp'>".$row["To2"]." ".$row["Role2"]." ".$row["Dep2"]."</td>";
                        echo "<td>".$row["Task"]."</td>";
                        echo "<td>".$date1."</td>";
                        echo "<td>".$date2."</td>";
                        echo "<td>".$row["Remarks"]."</td>";
                        echo "<td align = 'center'>Today starts</td>";
                        echo "<td align='center'>"; ?>
                        <button class="mod1 btn btn-primary"><a href="edit_data.php?edit=<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></button>
                        <button class="mod2"><a href="table_backend.php?delete=<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash"></i></a></button>
                        <?php
                        echo "<td>"; 
                        if($row["State"] != "comp" && $admin_name == $row['From1'])
                        { ?>
                        <button class='complete'><a class="mark" href="table_backend.php?complete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-check"></i></a></button>
                        <?php }
                        else if($row["State"] != "comp" && $admin_name != $row['From1'])
                        { ?>
                        <button class='mod1'><a class="mark" href="table_backend.php?request_state=<?php echo $row['ID']; ?>">Request<i class="fa-solid fa-circle-check"></i></a></button>
                        <?php }
                        else { ?>
                        <button class='mod2'><a class="mark" href="table_backend.php?incomplete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-xmark"></i></a></button>
                        <?php }
                        echo "</td>";
                        echo "</td>";
                        echo "</tr>";

                    }
                }
                
                if($data->num_rows>0)
                {
                    while($row = $data->fetch_assoc())
                    {
                        $date1 = date('d-m-Y h:m:s',strtotime($row["date1"]));
                        $date2 = date('d-m-Y',strtotime($row["Ends"]));

                        $now = time(); // or your date as well
                        $last_date = strtotime($row['Ends']);
                        $datediff = $last_date - $now;

                        $diff = round(($datediff / (60 * 60 * 24))+1);
                        
                        if($row['State'] != 'comp' && $diff >= 0)
                        {
                            
                            if($sno%2 == 0)
                            {
                                $cls = "odd_row";
                            }
                            else
                            {
                                $cls = "even_row";
                            }

                            if($row['State'] == "req")
                            {
                                $sno += 1;
                                $status = "Request";
                                $st_cls = "req";
                            }
                            else if($diff == 0)
                            {
                                $sno += 1;
                                $status = "Immediate";
                                $st_cls = "imd";
                            }
                            else if($diff == 1)
                            {
                                $sno += 1;
                                $status = "Urgent";
                                $st_cls = "urg";
                            }
                            else if($diff == 2)
                            {
                                $sno += 1;
                                $status = "Important";
                                $st_cls = "imp";
                            }
                            else if($diff > 2)
                            {
                                $sno += 1;
                                $status = "Regular";
                                $st_cls = "reg";
                            }

                            echo "<tr class='$cls'>";
                            echo "<td>".$sno."</td>";
                            echo "<td>".$row["ID"]."</td>";
                            echo "<td id='From_inp'>".$row["From1"]." ".$row["Role1"]." ".$row["Dep1"]."</td>";
                            echo "<td id='To_inp'>".$row["To2"]." ".$row["Role2"]." ".$row["Dep2"]."</td>";
                            echo "<td>".$row["Task"]."</td>";
                            echo "<td>".$date1."</td>";
                            echo "<td>".$date2."</td>";
                            echo "<td>".$row["Remarks"]."</td>";
                            echo "<td><div class='$st_cls'><i class='fa-sharp fa-solid fa-circle-info'></i>$status</div></td>";
                            echo "<td align='center'>"; 
                            if($admin_name == $row["From1"]){ ?>
                            <button class="mod1 btn btn-primary"><a href="edit_data.php?edit=<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></button>
                            <button class="mod2"><a href="table_backend.php?delete=<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash"></i></a></button>
                            <?php }
                            else{ ?>
                            <button class="mod1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#denied_permission"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></button>
                            <button class="mod2" data-bs-toggle="modal" data-bs-target="#denied_permission"><a href="#"><i class="fa-solid fa-trash"></i></a></button>
                           <?php }
                            echo "<td>"; 
                            if($row["State"] != "comp" && $admin_name == $row['From1'])
                            { ?>
                            <button class='complete'><a class="mark" href="table_backend.php?complete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-check"></i></a></button>
                            <?php }
                            else if($row["State"] != "comp" && $admin_name != $row['From1'])
                            { ?>
                            <button class='mod1'><a class="mark" href="table_backend.php?request_state=<?php echo $row['ID']; ?>">Request<i class="fa-solid fa-circle-check"></i></a></button>
                            <?php }
                            else { ?>
                            <button class='mod2'><a class="mark" href="table_backend.php?incomplete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-xmark"></i></a></button>
                            <?php }
                            echo "</td>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                }
                
                if($ex_data->num_rows>0)
                {
                    while($row = $ex_data->fetch_assoc())
                    {
                        $date1 = date('d-m-Y h:m:s',strtotime($row["date1"]));
                        $date2 = date('d-m-Y',strtotime($row["Ends"]));

                        $now = time(); // or your date as well
                        $last_date = strtotime($row['Ends']);
                        $datediff = $last_date - $now;

                        $diff = round(($datediff / (60 * 60 * 24))+1);
                        
                        if($row['State'] != 'comp' && $diff < 0)
                        {
                            $sno += 1;
                            
                            if($sno%2 == 0)
                            {
                                $cls = "even_row";
                            }
                            else
                            {
                                $cls = "odd_row";
                            }

                            if($diff < 0)
                            {
                                $status = "Expired";
                                $st_cls = "exp";
                            }

                            echo "<tr class='$cls'>";
                            echo "<td>".$sno."</td>";
                            echo "<td>".$row["ID"]."</td>";
                            echo "<td id='From_inp'>".$row["From1"]." ".$row["Role1"]." ".$row["Dep1"]."</td>";
                            echo "<td id='To_inp'>".$row["To2"]." ".$row["Role2"]." ".$row["Dep2"]."</td>";
                            echo "<td>".$row["Task"]."</td>";
                            echo "<td>".$date1."</td>";
                            echo "<td>".$date2."</td>";
                            echo "<td>".$row["Remarks"]."</td>";
                            echo "<td><div class='$st_cls'><i class='fa-sharp fa-solid fa-circle-info'></i>$status</div></td>";
                            echo "<td align='center'>"; 
                            if($admin_name == $row["From1"]){ ?>
                                <button class="mod1 btn btn-primary"><a href="edit_data.php?edit=<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                <button class="mod2"><a href="table_backend.php?delete=<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash"></i></a></button>
                                <?php }
                                else{ ?>
                                <button class="mod1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#denied_permission"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                <button class="mod2" data-bs-toggle="modal" data-bs-target="#denied_permission"><a href="#"><i class="fa-solid fa-trash"></i></a></button>
                            <?php }
                            echo "<td>"; 
                            if($row["State"] != "comp" && $admin_name == $row['From1'])
                            { ?>
                            <button class='complete'><a class="mark" href="table_backend.php?complete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-check"></i></a></button>
                            <?php }
                            else if($row["State"] != "comp" && $admin_name != $row['From1'])
                            { ?>
                            <button class='mod1'><a class="mark" href="table_backend.php?request_state=<?php echo $row['ID']; ?>">Request<i class="fa-solid fa-circle-check"></i></a></button>
                            <?php }
                            else { ?>
                            <button class='mod2'><a class="mark" href="table_backend.php?incomplete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-xmark"></i></a></button>
                            <?php }
                            echo "</td>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                }

                if($com_data->num_rows>0)
                {
                    while($row = $com_data->fetch_assoc())
                    {
                        $date1 = date('d-m-Y h:m:s',strtotime($row["date1"]));
                        $date2 = date('d-m-Y',strtotime($row["Ends"]));
                        

                        $now = time(); // or your date as well
                        $last_date = strtotime($row['Ends']);
                        $datediff = $last_date - $now;

                        $diff = round(($datediff / (60 * 60 * 24))+1);
                        
                        if($row['State'] == 'comp')
                        {
                            $sno += 1;
                            
                            if($sno%2 == 0)
                            {
                                $cls = "even_row";
                            }
                            else
                            {
                                $cls = "odd_row";
                            }

                            $status = "Completed";
                            $st_cls = "comp";

                            echo "<tr class='$cls'>";
                            echo "<td>".$sno."</td>";
                            echo "<td>".$row["ID"]."</td>";
                            echo "<td id='From_inp'>".$row["From1"]." ".$row["Role1"]." ".$row["Dep1"]."</td>";
                            echo "<td id='To_inp'>".$row["To2"]." ".$row["Role2"]." ".$row["Dep2"]."</td>";
                            echo "<td>".$row["Task"]."</td>";
                            echo "<td>".$date1."</td>";
                            echo "<td>".$date2."</td>";
                            echo "<td>".$row["Remarks"]."</td>";
                            echo "<td><div class='$st_cls'><i class='fa-sharp fa-solid fa-circle-info'></i>$status</div></td>";
                            echo "<td align='center'>"; 
                            if($admin_name == $row["From1"]){ ?>
                                <button class="mod1 btn btn-primary"><a href="edit_data.php?edit=<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                <button class="mod2"><a href="table_backend.php?delete=<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash"></i></a></button>
                                <?php }
                                else{ ?>
                                <button class="mod1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#denied_permission"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                <button class="mod2" data-bs-toggle="modal" data-bs-target="#denied_permission"><a href="#"><i class="fa-solid fa-trash"></i></a></button>
                               <?php }
                            echo "<td>"; 
                            if($row["State"] != "comp" && $admin_name == $row['From1'])
                            { ?>
                            <button class='complete'><a class="mark" href="table_backend.php?complete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-check"></i></a></button>
                            <?php }
                            else if($row["State"] != "comp" && $admin_name != $row['From1'])
                            { ?>
                            <button class='mod1'><a class="mark" href="table_backend.php?request_state=<?php echo $row['ID']; ?>">Request<i class="fa-solid fa-circle-check"></i></a></button>
                            <?php }
                            else { ?>
                            <button class='mod2'><a class="mark" href="table_backend.php?incomplete_state=<?php echo $row['ID']; ?>">Mark<i class="fa-solid fa-circle-xmark"></i></a></button>
                            <?php }
                            echo "</td>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                }
                
                
                ?>
            </tbody>
        </table>
    </div>
    <div class="modal" id="denied_permission">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Warning!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    You don't have permission to make change in this task.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</body>
</html>