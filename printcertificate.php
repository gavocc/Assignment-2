<?php
/* This is the print certificate page for the Employee Induction Portal. 
  Completed training details will be passed from Training modules page to this page and a pdf certificate
  will be generated. 
*/

//#Region Import API
ob_start();
session_start();
require_once 'fpdf181/fpdf.php';
  
date_default_timezone_set('Australia/Melbourne');

//#End Region
?>

<html>

<body>

<?php
//#Region "Insert registration record into dynamodb table and generate pdf"

 try {
        echo $_GET['strCourseName'];

                $pdf= new FPDF();
                $pdf->SetTitle('Completion Certificate');
                $pdf->SetFont('Helvetica','B',30);
                $pdf->SetTextColor(50,60,100);
                $pdf->AddPage('P');
                $pdf->SetDisplayMode(real,'default');
                $pdf->SetXY(30,20);
                $pdf->SetDrawColor(50,60,100);
                $pdf->Cell(100,10,'COMPLETION CERTIFICATE');
                $pdf->SetXY(80,40);
                $pdf->SetFontSize(22);
                $pdf->Write(5,$_GET['strUserName']);
                $pdf->SetXY(10,50);
                $pdf->SetFontSize(12);
                $pdf->Write(5,'Congratulations! You have completed the induction course for '. $_GET['strCourseName'] .'. ');
                $pdf->SetXY(70,60);
                $pdf->SetFontSize(12);
                $pdf->Write(5,'Completion Date: '. strval($_GET['strCompletedDate']));
                $pdf->Output('Certificate.pdf','I');
                ob_end_flush();
                }
                catch(Exception $e) {
                    echo 'error Message: ' .$e->getMessage();
                }
//#EndRegion
?>

  
<div>
</div>
</body>
</html>