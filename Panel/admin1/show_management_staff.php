<!DOCTYPE html>
<html>
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
                
            </div>
            <div class="pdf_btn">
                
            </div>  
        </div>
    </div>
	
	<div class="table_section">
        <table id="myTable">
		
		<thead>
            <tr id="header">
                <th class="table-cell">S.No.</th>			
                <th class="table-cell">Name</th>
                <th class="table-cell">Role</th>
                <th class="table-cell">ID</th>
                <th class="table-cell">Password</th>
                <th class="table-cell">Edit</th>
                <th class="table-cell">Remove</th>	
                <th class="table-cell">Administrator</th>
            </tr>
		</thead>

		<tbody>
		<?php
			require "../../db.php";
			$sql = "SELECT * FROM administrator WHERE NOT ID=1";
			$result = $db->query($sql);

			if($result->num_rows>0)	
			{
                $No = 0;
				while ($row = $result->fetch_assoc()) {

					$No = $No+1;

					if($No%2 == 0)
					{
						echo "<tr class='even_row'><td>".$No."</td><td>".$row["Name"]."</td><td>".$row["Role"]."</td><td>".$row["log_id"]."</td><td>".$row["pss"]."</td>";
					}
					else
					{
						echo "<tr class='odd_row'><td>".$No."</td><td>".$row["Name"]."</td><td>".$row["Role"]."</td><td>".$row["log_id"]."</td><td>".$row["pss"]."</td>";
					}
                    ?>

                <td>
                    <button class="mod1 btn btn-primary"><a href="edit_management_staff.php?Change=<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></button>
                </td>
                <td>
                    <button class="mod2"><a href="process_management_staff.php?Remove=<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash"></i></a></button>
	 			</td>   

                 <?php
                    if($row['control'] == 1)
                	{ ?>
                    <td><button><a href="process_management_staff.php?No=<?php echo $row['ID']; ?>"><i class="fa-solid fa-xmark"></i></a></button></td>
                    <?php }
                    elseif($row['control'] == 0)
                    { ?>
                    	<td><button><a href="process_management_staff.php?Yes=<?php echo $row['ID']; ?>"><i class="fa-solid fa-check"></i></a></button></td>
                    <?php } ?>

                <?php	}
			}
			else
			{
				echo "No Events are available";
			}
			$db->close();
		?>
		</tbody>
	</table>
	

</body>
</html>