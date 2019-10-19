<?php
/* This is the Safe Vehicle Parking Induction page. 
   User will go through each slide/section by clicking on Next button or go back to previous slide by clicking on the Previous button.
   Once reaching the last slide, user will have to click on the Agree button to complete the induction course.
   Upon completing the course, a print certificate button will be visible and by clicking on the print button it will generate a 
   completion certificate in pdf format.
   Record will be inserted into BigQuery table. The table name is TrainingRegistration.
*/

//#Region Import API
   ob_start();
   session_start();
   require_once 'php/google-api-php-client/vendor/autoload.php';
    require_once 'fpdf181/fpdf.php';
     date_default_timezone_set('Australia/Melbourne');
 
//#End Region

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
.ul, li {
    padding:5px;
}
.content {
	margin: 1% auto;
	padding: 3px;
	width: 100%;
	/*background-color: #ff7cff;*/
	color: #ffffff;
	font-family: 'Helvetica', sans-serif;
	border: 1px solid #000000;
	border-radius: 10px;
	box-shadow: 5px 5px 10px #212121;
	/*display: flex;*/
}
.square {
  list-style-type: square;
}
.error{
    color:red;
    font-weight:bold;
}
</style> 
</head>
<body class="content">

<?php
//#Region "Insert registration record into dynamodb table and generate pdf"
$SubmitMessage='';
$strUserName = $_SESSION['UserName'];
date_default_timezone_set("Australia/Melbourne");
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Bigquery::BIGQUERY);
$bigquery = new Google_Service_Bigquery($client);
$projectId = 's3809839-cc2019';
$datasetId = 'InductionTraining';
$tableId   = 'TrainingRegistration';

if(isset($_POST['print'])){
    $PrintDate = date('d-m-Y');
    try {
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
    $pdf->Write(5,$strUserName);
    $pdf->SetXY(10,50);
    $pdf->SetFontSize(12);
    $pdf->Write(5,'Congratulations! You have completed the induction course for Safe Vehicle Parking.');
    $pdf->SetXY(70,60);
    $pdf->SetFontSize(12);
    $pdf->Write(5,'Completion Date: '. strval($PrintDate));
    $pdf->Output('Certificate.pdf','D');
    ob_end_flush();
    }
    catch(Exception $e) {
        echo 'error Message: ' .$e->getMessage();
    }
}

if(!isset($_POST['previous']) && !isset($_POST['next'])){
$page=' Page 1';
$style1 = 'display:inline';
$style2 = 'display:none';
$style3 = 'display:none';
$style4 = 'display:none';
$style5 = 'display:none';
$style6 = 'display:none';
$style7 = 'display:none';
$style8 = 'display:none';
$style9 = 'display:none';
$StyleBtnAgree ='display:none';
$StyleBtnPrint ='display:none';
$StyleBtnPrevious ='display:inline';
$StyleBtnNext ='display:inline';
$StyleFooter ='display:inline';
}

if(isset($_POST['next'])){
    $errorMessage ='';
   
       if ($style1=='display:inline' || $_POST['style1']=='display:inline') {
        $page=' Page 2';
        $style1 = 'display:none';
        $style2 = 'display:inline';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style2']=='display:inline') {
        $page=' Page 3';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:inline';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style3']=='display:inline') {
        $page=' Page 4';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:inline';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
    elseif ($_POST['style4']=='display:inline') {

        if(isset($_POST['rdoQ1']))
        {
            if ($_POST['rdoQ1']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ1']!='E'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         
            if ($errorMessage !='') {
           $page=' Page 4';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:inline';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
            $page=' Page 5';
            $style1 = 'display:none';
            $style2 = 'display:none';
            $style3 = 'display:none';
            $style4 = 'display:none';
            $style5 = 'display:inline';
            $style6 = 'display:none';
            $style7 = 'display:none';
            $style8 = 'display:none';
            $style9 = 'display:none';
            $StyleBtnAgree ='display:none';
            $StyleBtnPrint ='display:none';
            $StyleBtnPrevious ='display:none';
            $StyleBtnNext ='display:inline';
            $StyleFooter ='display:inline';
        }

       }
       else {
        $errorMessage = "Please select an answer to proceed."; 
        $page=' Page 4';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:inline';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
       }
     }
     elseif ($_POST['style5']=='display:inline') {
       
        if(isset($_POST['rdoQ2']))
        {
            if ($_POST['rdoQ2']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ2']!='B'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         
       if ($errorMessage !='') {
           $page=' Page 5';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:inline';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
        $page=' Page 6';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:inline';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
        }
     }
     else {
        $errorMessage = "Please select an answer to proceed.";
        $page=' Page 5';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:inline';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
    }
     elseif ($_POST['style6']=='display:inline') {
        if(isset($_POST['rdoQ3']))
        {
            if ($_POST['rdoQ3']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ3']!='A'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         if ($errorMessage !='') {
           $page=' Page 6';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:inline';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
         }
        else {
        $page=' Page 7';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:inline';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
        }
     }
     else {
        $errorMessage = "Please select an answer to proceed."; 
        $page=' Page 6';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:inline';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
     }
    }
     elseif ($_POST['style7']=='display:inline') {
        if(isset($_POST['rdoQ4']))
        {
            if ($_POST['rdoQ4']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ4']!='E'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         if ($errorMessage !='') {
           $page=' Page 7';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:inline';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
        $page=' Page 8';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:inline';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
        }
       }
       else {
        $errorMessage = "Please select an answer to proceed."; 
        $page=' Page 7';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:inline';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
       }
     }
     elseif ($_POST['style8']=='display:inline') {
        if(isset($_POST['rdoQ5']))
        {
            if ($_POST['rdoQ5']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ5']!='A'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         if ($errorMessage !='') {
           $page=' Page 8';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:inline';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
        $page=' Page 9';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:inline';
        $StyleBtnAgree ='display:inline';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:none';
        $StyleFooter ='display:none';
        }
     }
     else {
        $errorMessage = "Please select an answer to proceed.";
        $page=' Page 8';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:inline';
        $style9 = 'display:none';
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
}
}
elseif(isset($_POST['previous'])) {
    if ($_POST['style2']=='display:inline' || $_POST['style1']=='display:inline') {
        $page=' Page 1';
        $style1 = 'display:inline';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style3']=='display:inline') {
        $page=' Page 2';
        $style1 = 'display:none';
        $style2 = 'display:inline';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
    
}
elseif(isset($_POST['agree'])) {
 
   $page=' Page 9';
   $style1 = 'display:none';
   $style2 = 'display:none';
   $style3 = 'display:none';
   $style4 = 'display:none';
   $style5 = 'display:none';
   $style6 = 'display:none';
   $style7 = 'display:none';
   $style8 = 'display:none';
   $style9 = 'display:inline';
   $StyleBtnAgree ='display:none';
   $StyleBtnPrint ='display:none';
   $StyleBtnPrevious ='display:none';
   $StyleBtnNext ='display:none';
   $StyleFooter ='display:none';
    
try {
   
    $date = date('Y-m-d H:i:s');
   
    $data = array('UserName' => $strUserName,
        'CourseName' => 'Safe Vehicle Parking',
        'Category' => 'Fleet Drivers',
        'CompletedDate' => str_replace(' ', 'T', $date));

    try {
        $rows = array();
        $row = new Google_Service_Bigquery_TableDataInsertAllRequestRows();
        $row->setJson($data);
        $row->setInsertId(date('YmdHis')); 
       $rows[0] = $row;
     
        $request = new Google_Service_Bigquery_TableDataInsertAllRequest();
        $request->setKind('bigquery#tableDataInsertAllRequest');
        $request->setRows($rows);
        $response =  $bigquery->tabledata->insertAll($projectId, $datasetId , $tableId, $request);
           
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }


$SubmitMessage = "You have successfully completed Safe Vehicle Parking module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();

  }
#EndRegion
}

?>
<form action="/TrainingFiles/FleetDrivers/SafeVehicleParking.php" method="post">    
<div>
<div class="PageHeader"><h1>Safe Vehicle Parking</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
<p class="mb-0"><strong>Purpose</strong></p>
    <p class="mb-0">The purpose of this Safe Operating Procedure (SOP) ¡s to provide guidance on the safe
method to park vehicles, coupling and uncoupling of equipment.</p>

<p class="mb-0"><strong>Related Documents</strong></p>
<p class="mb-0">Associated Training/Documents:</p>
<p>
        <ul class="square">
                <li>SOP 3 — Access & Egress — Vehicle / Equipment</li>
                <li>SOP 17 — Tag Out of Unsafe Plant / Equipment</li>
                <li>SOP 29 — Working in Hot Conditions</li>
                <li>SOP 34 — Pre-Start Equipment Checklists</li>
                <li>Site Safety Rules</li>
                <li>Other related SOP’s</li>
        </ul>
    </p>
</blockquote></div>

<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
<p class="mb-0"><h3><strong>SAFE VEHICLE PARKING</strong></h3></p>
<p class="mb-0">To park a vehicle safely, the following factors apply:</p>
<p class="mb-0"><strong>Accelerating</strong></p>
    <p>
        <ul class="square">
                <li>Accelerate smoothly and gradually.</li>
                <li>Rough or rapid acceleration may cause your load to shift and/or damage to equipment.
                </li>
        </ul>
    </p>
  <p class="mb-0"><strong>Steering</strong></p>
    <p>
        <ul class="square">
                <li>Always hold the steering wheel firmly with both hands, to maintain vehicle control.</li>
        </ul>
    </p>
    <p class="mb-0"><strong>Reversing</strong></p>
    <p>
        <ul class="square">
                <li>Ensure clear path before reversing.</li>
                <li>If in doubt, exit vehicle and check /look.</li>
                <li>Align vehicle and trailer.</li>
                <li>Reverse slowly and use all your mirrors.</li>
                <li>Avoid drifting off course and over correcting.</li>
        </ul>
    </p>
    <p class="mb-0">Note: If needed, stop, move forward and recommence from a straight position.
                        </p>
    <p class="mb-0"><strong>Braking</strong></p>
    <p>
        <ul class="square">
                <li>Ensure you are familiar with all braking devices/system for your vehicle/equipment.</li>
                <li>Apply brakes smoothly.</li>
        </ul>
    </p>
</blockquote></div>

<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
<p class="mb-0"><strong>Parking Location / Area</strong></p>
<p>
        <ul class="square">
                <li>Park in designated parking area.</li>
                <li>Use of hazard lights to warn others.</li>
                <li>Check ground surface prior to parking.</li>
                <li>Ensure availability of space for size of vehicle I equipment.</li>
                <li>Ensure no obstructions to other traffic — vehicle and/or pedestrian.</li>
                <li>Ensure the area is not prohibited from vehicle parking.</li>
                <li>Apply maxi/park brakes before exiting vehicle.</li>
                <li>Use wheel chocks where required - i.e. site rules, gradient area.</li>
                <li>Use timber bearers or steel plates under trailer landing legs for unstable I soft surfaces.</li>
        </ul>
    </p>
    <p class="mb-0"><strong>Important</strong></p>
    <p class="mb-0"><cite>Avoid distractions - Ensure full attention is maintained when undertaking this task.</cite></p>
</blockquote></div>

<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>">
<blockquote>
    <p><strong>Question 1</strong></p>
   
    <p class="mb-0">To drive and park a vehicle safely you must be able to?</p>

   <p>
        <ul>
                <li><input type="radio" name="rdoQ1" value='A'> A) Accelerate smoothly and gradually.</li>
                <li><input type="radio" name="rdoQ1" value='B'> B) Be familiar with its steering wheel.</li>
                <li><input type="radio" name="rdoQ1" value='C'> C) Always hold its steering wheel with both hands.</li>
                <li><input type="radio" name="rdoQ1" value='D'> D) Rough and rapid acceleration into the parking spot.</li>
                <li><input type="radio" name="rdoQ1" value='E'> E) Both A & C.</li>
        </ul>
    </p>
   <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
<p><strong>Question 2</strong></p>
    <p class="mb-0">When reversing vehicle toward equipment /trailer?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ2" value='A'> A) Always accelerate until you reach the equipment / trailer then quickly
                brake to stop.</li>
                <li><input type="radio" name="rdoQ2" value='B'> B) Ensure clear path, reverse slowly, align the vehicle and equipment / trailer
                - if in doubt get out and check.</li>
                <li><input type="radio" name="rdoQ2" value='C'> C) Always approach from the side and then turn sharply when you reach the
                trailer.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
<p><strong>Question 3</strong></p>
    <p class="mb-0">Brake application requires?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ3" value='A'> A) Familiarity with devices I systems of your vehicle equipment.</li>
                <li><input type="radio" name="rdoQ3" value='B'> B) Quick actions by the driver.</li>
                <li><input type="radio" name="rdoQ3" value='C'> C) Operate brakes quick and harshly.</li>
                <li><input type="radio" name="rdoQ3" value='D'> D) Do not need brakes to park vehicle.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page7" style="<?php echo $style7;?>"><input name="style7" type="hidden" value="<?php echo $style7 ?>"><blockquote>
<p><strong>Question 4</strong></p>
    <p class="mb-0">When on-site parking is provided ensure?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ4" value='A'> A) Use of hazards light to warn others.</li>
                <li><input type="radio" name="rdoQ4" value='B'> B) Availability of space for size of vehicle I equipment.</li>
                <li><input type="radio" name="rdoQ4" value='C'> C) The area is not prohibited from vehicle parking.</li>
                <li><input type="radio" name="rdoQ4" value='D'> D) Application of maxi / park brakes before exiting.</li>
                <li><input type="radio" name="rdoQ4" value='E'> E) All of the above.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>  
</blockquote></div>
<div id="page8" style="<?php echo $style8; ?>"><input name="style8" type="hidden" value="<?php echo $style8 ?>"><blockquote>
<p><strong>Question 5</strong></p>
    <p class="mb-0">You cannot drive safely unless the task has your full attention?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ5" value='A'> A) True.</li>
                <li><input type="radio" name="rdoQ5" value='B'> B) False.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>
<div id="page9" style="<?php echo $style9; ?>"><input name="style9" type="hidden" value="<?php echo $style9 ?>"><blockquote>
    
    <div class="TextCenter" >
      <h3>You have answered all questions correctly.<br> Click submit to complete the course.</h3>
   </div>
   <div class="TextCenter PaddingTop">
   <label for="Message" class="SubmittedMessage"><?php echo $SubmitMessage; ?></label>
   </div>
  
</blockquote></div>

<div class="TextCenter">
<footer class="blockquote-footer PageFooter" style="<?php echo $StyleFooter; ?>"><cite><?php echo $page; ?></cite></footer>
   
<button type="submit" name="print" class="btn btn-primary" style="<?php echo $StyleBtnPrint; ?>">Print Certificate</button><button type="submit" name="agree" class="btn btn-primary" style="<?php echo $StyleBtnAgree; ?>">Submit</button><button type="submit" name="previous" class="btn btn-primary" style="<?php echo $StyleBtnPrevious; ?>">Previous</button> <button type="submit" name="next" class="btn btn-primary" style="<?php echo $StyleBtnNext; ?>">Next</button>
</div>

</div>
</div>
</form>
</body>
</html>