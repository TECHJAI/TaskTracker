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
    <link rel="stylesheet" href="../../CSS/page_loader.css">
    <script src="../../JS/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../../JS/search_area.js"></script>
</head>

<style>
    button a{
        text-decoration : none;
        color : white;
    }
</style>

<body>
<div class="preloader" id="preloader">
        <img src="../../IMG/preloader.gif" alt="Loading...">
    </div>
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
            <tr id="header" align="center">
                <th class="table-cell">S.No.</th>			
                <th class="table-cell">Authority Data</th>
                <th class="table-cell">Login Credential</th>
                <th class="table-cell">Action</th>
            </tr>
		</thead>

		<tbody>
		<?php
			require "../../db.php";
			$sql = "SELECT * FROM authority_registration";
			$result = $db->query($sql);

			if($result->num_rows>0)	
			{
                $No = 0;
				while ($row = $result->fetch_assoc()) {

					$No = $No+1;

					if($No%2 == 0)
					{
						echo "<tr class='even_row' align='center'><td>".$No."</td><td align='left'><b>Name:</b>".$row["Name"]."<br><b>Role :</b>".$row["role"]."<br><b>Mail:</b>".$row["email"]."</td><td><b>Username:</b>".$row["username"]."<br><b>Password:</b>".$row["password"]."</td>";
					}
					else
					{
						echo "<tr class='odd_row' align='center'><td>".$No."</td><td align='left'><b>Name:</b>".$row["Name"]."<br><b>Role :</b>".$row["role"]."<br><b>Mail:</b>".$row["email"]."</td><td><b>Username:</b>".$row["username"]."<br><b>Password:</b>".$row["password"]."</td>";
					}
                    ?>

                <td>
                    <button class="mod1 btn btn-primary" onclick="showPreloader()"><a href="process_approval.php?approve=<?php echo $row['sno']; ?>">Approve</a></button>
                    <button class="mod2 btn btn-primary" onclick="showPreloader()"><a href="process_approval.php?decline=<?php echo $row['sno']; ?>">Decline</a></button>
	 			</td>   

                     <?php	}
			}
			else
			{
				echo "No approvals are available";
			}
			$db->close();
		?>
		</tbody>
	</table>
	

</body>
</html>