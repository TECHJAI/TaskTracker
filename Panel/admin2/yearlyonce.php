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
                <th class="table-cell">Event No.</th>			
                <th class="table-cell">Event Starts</th>
                <th class="table-cell">Event</th>
                <th class="table-cell">Event Ends</th>
                <th class="table-cell">Status</th>
                <th class="table-cell">Remarks</th>
                <th class="table-cell">Action</th>
            </tr>
		</thead>

		<tbody>
		<?php
			require "../../db.php";
			$sql = "SELECT * FROM y_once";
			$result = $db->query($sql);

			if($result->num_rows>0)	
			{
                            $cdate=date('d-m-y');
                            $No = 0;
				while ($row = $result->fetch_assoc()) {

					$No = $No+1;

					$t_date = date('d-m',strtotime($row["Date"]));
					$e_date = date('d-m',strtotime($row["E_event"]));

					if($No%2 == 0)
					{
						echo "<tr class='even_row'><td>".$No."</td><td>".$t_date."</td><td>".$row["Event"]."</td><td>".$e_date."</td>";
					}
					else
					{
						echo "<tr class='odd_row'><td>".$No."</td><td>".$t_date."</td><td>".$row["Event"]."</td><td>".$e_date."</td>";
					}

					
		                              
		                     //$sdate=$t_date;
                                  
					
                                   $curr_date = strtotime($cdate);
                                   $start_date = date(strtotime($row["Date"]));
                                   $end_date = date(strtotime($row['E_event']));

                                   if($curr_date==$start_date)
                                   {
                                          echo "<td><font color='darkgreen'>Event Started</td>";
                                   }
                              	elseif ($curr_date<=$end_date && $curr_date>=$start_date)
                                   {
                                    	echo "<td><font color='yellow'>Event On Progress</td>";
                                   }
                                   elseif ($curr_date<=$end_date && $curr_date>=$start_date)
                                   {
                                         	echo "<td><font color='red'>Will End Soon</td>";
                                   }
                                  	elseif($curr_date>$end_date)
                                   {
                                          echo "<td><font color='gray'>Event Finished</td>";
                                   }
                                   else
                                   {
                                   	echo "<td><font color='gray'>Not yet</td>";
                                   }

                                   echo "<td>".$row["Remarks"]."</td>"; ?>

                    		<td>
	 			<button class="mod1 btn btn-primary"><a href="edit_yearlyonce.php?edit=<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></button>
	 			<button class="mod2"><a href="edit_yearlyonce_backend.php?delete=<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash"></i></a></button>
	 			</td>   

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