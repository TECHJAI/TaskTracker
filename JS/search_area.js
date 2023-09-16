function To() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("To_inp");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) 
	{
			td = tr[i].getElementsByTagName("td")[3];
			if (td) 
			{
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) 
				{
					tr[i].style.display = "";
				} 
				else 
				{
					tr[i].style.display = "none";
				}
			}       
	}
}

function deadline() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("deadline_inp");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) 
	{
			td = tr[i].getElementsByTagName("td")[6];
			if (td) 
			{
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) 
				{
					tr[i].style.display = "";
				} 
				else 
				{
					tr[i].style.display = "none";
				}
			}       
	}
}