<?php
/* This is the Falls Prevention Induction page. 
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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Falls Prevention. ');
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
$style10 = 'display:none';
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
        $style10 = 'display:none';    
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
        $style10 = 'display:none'; 
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
        $style10 = 'display:none';       
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style4']=='display:inline') {
        
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style5']=='display:inline') {

        if(isset($_POST['rdoQ1']))
        {
            if ($_POST['rdoQ1']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ1']!='D'){
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
        $style10 = 'display:none';      
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
            $style10 = 'display:none';      
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
       }
     }
     elseif ($_POST['style6']=='display:inline') {
       
        if(isset($_POST['rdoQ2']))
        {
            if ($_POST['rdoQ2']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ2']!='A'){
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
        $style10 = 'display:none';      
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
        $style10 = 'display:none';      
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
    }
     elseif ($_POST['style7']=='display:inline') {
        if(isset($_POST['rdoQ3']))
        {
            if ($_POST['rdoQ3']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ3']!='A'){
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
        $style10 = 'display:none';      
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
        $style10 = 'display:none';      
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
     }
    }
     elseif ($_POST['style8']=='display:inline') {
        if(isset($_POST['rdoQ4']))
        {
            if ($_POST['rdoQ4']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ4']!='D'){
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
        $style10 = 'display:none';      
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
       }
     }
     elseif ($_POST['style9']=='display:inline') {
        if(isset($_POST['rdoQ5']))
        {
            if ($_POST['rdoQ5']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ5']!='D'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         if ($errorMessage !='') {
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
        $style10 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
        $page=' Page 10';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:inline'; 
        $StyleBtnAgree ='display:inline';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:none';
        $StyleFooter ='display:none';
        }
     }
     else {
        $errorMessage = "Please select an answer to proceed.";
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
        $style10 = 'display:none';      
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
     elseif ($_POST['style4']=='display:inline') {
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
        $style10 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style5']=='display:inline') {
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
        $style10 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
}
elseif(isset($_POST['agree'])) {
 
   $page=' Page 10';
   $style1 = 'display:none';
   $style2 = 'display:none';
   $style3 = 'display:none';
   $style4 = 'display:none';
   $style5 = 'display:none';
   $style6 = 'display:none';
   $style7 = 'display:none';
   $style8 = 'display:none';
   $style9 = 'display:none';
   $style10 = 'display:inline';  
   $StyleBtnAgree ='display:none';
   $StyleBtnPrint ='display:none';
   $StyleBtnPrevious ='display:none';
   $StyleBtnNext ='display:none';
   $StyleFooter ='display:none';
    
try {

    $date = date('Y-m-d H:i:s');
   
    $data = array('UserName' => $strUserName,
        'CourseName' => 'Falls Prevention',
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


$SubmitMessage = "You have successfully completed Falls Prevention module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();

  }
#EndRegion
}

?>
<form action="/TrainingFiles/FleetDrivers/FallsPrevention.php" method="post">    
<div>
<div class="PageHeader"><h1>Falls Prevention</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
<p class="mb-0"><strong>Purpose</strong></p>
    <p class="mb-0">The purpose of this Safe Operating Procedure (SOP) is to provide information to
the person conducting a business or undertaking (PCBU) to prevent injuries
from falls in the workplace.</p>
</blockquote></div>
<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
<p class="mb-0"><strong>Related Documents</strong></p>
    <p>
        <ul class="square">
                <li>Falls Prevention Procedure</li>
                <li>Top of Trailer Policy</li>
                <li>Other associated Safe Operating Procedures (SOP’s)</li>
        </ul>
    </p>
</blockquote></div>
<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
<p class="mb-0"><strong>Managing the Risks of Falls</strong></p>
<p class="mb-0">Tasks associated with the potential for falls in the workplace are controlled by
law.</p>
<p class="mb-0">The Work Health and Safety (WHS) Regulations 2011 state:</p>
<p><cite>A person conducting a business or undertaking (PCBU) at a workplace must
manage risks to health and safety associated with a fall by a person from one level
to another that is reasonably likely to cause injury to the person or any other person.</cite></p>
</blockquote></div>
<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>"><blockquote>
    <p class="mb-0"><strong>IDENTIFY - The Risk of Falls at the Workplace</strong></p>
    <p class="mb-0">The risk of a fall to a worker/s includes.</p>
    <p>
        <ul class="square">
                <li>In/on plant or structure that is at an elevated level.</li>
                <li>In/on plant that is being used to gain access to an elevated level.</li>
                <li>In the vicinity of an opening through which a person could fall. </li>
                <li>In the vicinity of an edge over which a person could fall.</li>
                <li>On or in the vicinity of a surlace through which a person could fall.</li>
                <li>On or in the vicinity of a slippery, sloping or unstable surface.</li>
        </ul>
    </p>
   
</blockquote></div>
<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>">

<blockquote>
    <p><strong>Question 1</strong></p>
   
    <p class="mb-0">The WHS Regulations 2011 definition for the potential for falls is
defined as:</p>

   <p>
        <ul>
                <li><input type="radio" name="rdoQ1" value='A'> A) Working at a distance over 2 metres.</li>
                <li><input type="radio" name="rdoQ1"value='B'> B) Working on a roof or similar construction.</li>
                <li><input type="radio" name="rdoQ1" value='C'> C) Any task where a person can fall from one level to another that is likely to cause injury regardless of the height.</li>
                <li><input type="radio" name="rdoQ1" value='D'> D) All of the above.</li>
        </ul>
    </p>
   <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>
<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
<p><strong>Question 2</strong></p>
    <p class="mb-0">Work should be assessed prior to commencing a task that has the
potential for falls.</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ2" value='A'> A) True.</li>
                <li><input type="radio" name="rdoQ2" value='B'> B) False.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>
<div id="page7" style="<?php echo $style7; ?>"><input name="style7" type="hidden" value="<?php echo $style7 ?>"><blockquote>
<p><strong>Question 3</strong></p>
    <p class="mb-0">At all times, workers should avoid working above ground level.</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ3" value='A'> A) True.</li>
                <li><input type="radio" name="rdoQ3" value='B'> B) False.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>
<div id="page8" style="<?php echo $style8; ?>"><input name="style8" type="hidden" value="<?php echo $style8 ?>"><blockquote>
<p><strong>Question 4</strong></p>
    <p class="mb-0">A safe system of work that provides fall protection involves:</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ4" value='A'> A) Inspection of all equipment prior to use</li>
                <li><input type="radio" name="rdoQ4" value='B'> B) Providing a fall protection device, or a work positioning system,
or a fall arrest system.</li>
                <li><input type="radio" name="rdoQ4" value='C'> C) Effective consultation with your supervisor.</li>
                <li><input type="radio" name="rdoQ4" value='D'> D) All of the above.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>  
</blockquote></div>
<div id="page9" style="<?php echo $style9; ?>"><input name="style9" type="hidden" value="<?php echo $style9 ?>"><blockquote>
<p><strong>Question 5</strong></p>
    <p class="mb-0">An example of a Fall Prevention Device is:</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ5" value='A'> A) Industrial rope access.</li>
                <li><input type="radio" name="rdoQ5" value='B'> B) Forklift cage/workbox.</li>
                <li><input type="radio" name="rdoQ5" value='C'> C) Ladder.</li>
                <li><input type="radio" name="rdoQ5" value='D'> D) All of the above.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>
<div id="page10" style="<?php echo $style10; ?>"><input name="style10" type="hidden" value="<?php echo $style10 ?>"><blockquote>
    
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