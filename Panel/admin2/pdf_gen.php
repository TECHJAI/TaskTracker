<?php  

require_once '../FPDF/fpdf.php';

$conn = mysqli_connect("localhost","root","","task manager");
session_start();
$admin_id = $_SESSION['log_id'];
$temp_result = $conn -> query("SELECT * FROM hod WHERE log_id='$admin_id'") or die($conn -> error());
$temp_row = $temp_result -> fetch_array();
$admin_name = $temp_row['Name'];


if(isset($_POST['btn-pdf']))
{
    date_default_timezone_set('Asia/Kolkata');
    $Today = time();
	$Today = date('d-M-Y',strtotime($Today));
    $pdf = new FPDF('L','mm','A4');
    $pdf->AddPage();
    $fontsize = 11;
    $tempFontSize = $fontsize;
    $pdf->Image('../../IMG/logo.jpg',130,5,20,20);
    $pdf->SetFont('Times','B',20);
    $pdf->cell(270,20,'',0,1,'C');
    $pdf->cell(270,5,'KNOWLEDGE INSTITUTE OF TECHNOLOGY',0,0,'C');
    $pdf->cell(270,20,'',0,1,'C');

    $pdf->SetFont('Arial','B',11);

	$pdf->cell(10,10,'S.No',1,0,'C');
    $pdf->cell(10,10,'ID',1,0,'C');
	$pdf->cell(40,10,'From',1,0,'C');
	$pdf->cell(40,10,'To',1,0,'C');
	$pdf->cell(100,10,'Task',1,0,'C');
	$pdf->cell(23,10,'Begins',1,0,'C');
	$pdf->cell(23,10,'Deadline',1,0,'C');
    $pdf->cell(23,10,'Status',1,1,'C');

    $sql = "SELECT * FROM tasks WHERE From1='$admin_name' OR To2='$admin_name' ORDER BY Ends";
    $res=$conn->query($sql);

    if($res->num_rows>0)
    {
        $state = "null";
        $now = time();
        
        $ind=0;
        while($row=$res->fetch_assoc())
        {
            $F_date = date('d-m-Y',strtotime($row["Begins"]));
            $Dead_Line = date('d-m-Y',strtotime($row["Ends"]));
            $last_date = strtotime($row['Ends']);
            $datediff = $last_date - $now;
            $diff = round(($datediff / (60 * 60 * 24))+1);
            $com = $row["State"];
            $ind++;

            if($com != 'comp')
            {
                if($diff == 0)
                {
                    $state = "Immediate";
                }
                elseif ($diff == 1) 
                {
                    $state = "Urgent";
                }
                elseif ($diff == 2) 
                {
                    $state = "Important";
                }
                elseif ($diff > 2) 
                {
                    $state = "Regular";
                }
                else
                {
                    $state = "Expired";
                }
            }
            else
            {
                $state = "Completed";
            }

            if($row["Role2"] == "")
            {
                $alt = $row["To2"];
            }
            else
            {
                $alt = $row["Role2"];
            }
            

            

            //Shrink font size until it fits in the cell width
            $cellwidth = 100; //Wrapped cell width
            $cellheight = 5; //Normal one-line cell height

            //Check whether the text is overflowing
            if($pdf->GetStringWidth($row["Task"]) < $cellwidth){
                // If not then do nothing
                $line=1;
            }else{
                //If it is, then calculate the height needed for wrapped cell
                //by splitting the text to fit the cell width
                //then count how many lines are needed for the text to fit the cell

                $textlength = strlen($row["Task"]); //Total text length
                $errmargin = 10; //cell width error margin, just in case
                $startchar = 0; //character start position for each line
                $maxchar = 0;
                $textarray = array();
                $tempstring = "";

                while( $startchar < $textlength ){ //Loop untill end of text
                    //loop until maximum character reached
                    while(
                        $pdf -> GetStringWidth( $tempstring ) < ($cellwidth-$errmargin) && ($startchar+$maxchar) < $textlength){
                        $maxchar++;
                        $tempstring = substr($row["Task"],$startchar,$maxchar);
                    }

                    //move startchar to next line
                    $startchar = $startchar+$maxchar;
                    //Then add it into the array so we know how many lines are needed
                    array_push($textarray,$tempstring);
                    //teset maxchar and tempstring
                    $maxchar = 0;
                    $tempstring = '';
                }
                //get number of line
                $line = count($textarray);
            }

            //Write the cell 
            $pdf->cell(10,($line*$cellheight),$ind,1,0);
            $pdf->cell(10,($line*$cellheight),$row["ID"],1,0);
            $pdf->cell(40,($line*$cellheight),$row["Role1"].$row["Dep1"],1,0);
            $pdf->cell(40,($line*$cellheight),$alt.$row["Dep2"],1,0);

            $xpos = $pdf -> GetX();
            $ypos = $pdf -> GetY();
            $pdf->Multicell($cellwidth,$cellheight,$row["Task"],1,0);

            $pdf -> SetXY($xpos+$cellwidth,$ypos);


            $pdf->cell(23,($line*$cellheight),$F_date,1,0);
            $pdf->cell(23,($line*$cellheight),$Dead_Line,1,0);
            $pdf->cell(23,($line*$cellheight),$state,1,1);
        }

    }
    else
    {
        $pdf->cell(10,6,'No Records Found',1,0,'C');
    }

    $pdf->Output();
}
?>