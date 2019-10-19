<?php
/* This is the Top of Trailer Induction page. 
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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Top of Trailer. ');
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
        
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
    elseif ($_POST['style4']=='display:inline') {

        if(isset($_POST['rdoQ1']))
        {
            if ($_POST['rdoQ1']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ1']!='D'){
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
            elseif($_POST['rdoQ2']!='D'){
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
            elseif($_POST['rdoQ3']!='D'){
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
            elseif($_POST['rdoQ4']!='C'){
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
        $StyleBtnAgree ='display:inline';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:none';
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
 
   $page=' Page 8';
   $style1 = 'display:none';
   $style2 = 'display:none';
   $style3 = 'display:none';
   $style4 = 'display:none';
   $style5 = 'display:none';
   $style6 = 'display:none';
   $style7 = 'display:none';
   $style8 = 'display:inline';
   $StyleBtnAgree ='display:none';
   $StyleBtnPrint ='display:none';
   $StyleBtnPrevious ='display:none';
   $StyleBtnNext ='display:none';
   $StyleFooter ='display:none';
    
try {
    $date = date('Y-m-d H:i:s');
   
    $data = array('UserName' => $strUserName,
        'CourseName' => 'Top Of Trailer',
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


$SubmitMessage = "You have successfully completed Top of Trailer module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();

  }
#EndRegion
}

?>
<form action="/TrainingFiles/FleetDrivers/TopOfTrailer.php" method="post">    
<div>
<div class="PageHeader"><h1>Top of Trailer</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
<p class="mb-0"><strong>Purpose</strong></p>
    <p class="mb-0">The purpose of this Safe Operating Procedure (SOP) is to ensure all workers are
aware of the hazards involved when working on a trailer /tray deck and the
processes and controls that need to be undertaken to provide and maintain a
safe working environment.</p>

<p class="mb-0"><strong>Associated Policies:</strong></p>
     <p>
        <ul class="square">
                <li>Top of Trailer / Tray Policy</li>
        </ul>
    </p>

<p class="mb-0"><strong>Related Documents:</strong></p>
     <p>
        <ul class="square">
                <li>Take 3 - Top of Trailer / Tray Deck Risk Assessment</li>
                <li>Other associated companys' Safe Operating Procedures
                    (SOP’s and checklists)</li>
        </ul>
    </p>
    <p class="mb-0"><strong>Associated SOP Training:</strong></p>
     <p>
        <ul class="square">
                <li>SOP 3 - Vehicle Access & Egress</li>
                <li>SOP 21 - Fall Prevention</li>
                <li>SOP 50 - Safe Use of Harness</li>
               
        </ul>
    </p>

</blockquote></div>


<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
<p class="mb-0"><strong>WORKING ON TRAILER DECKS</strong></p>
<p class="mb-0">Elevated work is by its very nature hazardous. The degree of risk is often increased
by the lack of proper pre-works planning and the conditions under which the work
is carried out.</p>
<p class="mb-0">Prior to any work being carried out on top of trailer/tray deck, the following must be
considered:</p>

    <p>
        <ul class="square">
                <li>Explore all options not to work on the trailer / tray - ALWAYS WORK FROM
                    GROUND LEVEL.</li>
                <li>After exhausting all options and working on the trailer / tray is assessed as
                    being unavoidable, prior authorisation must be obtained from the respective
                    manager and/or supervisor by undertaking a TAKE 3 Top of Trailer/Tray Deck
                    Risk Assessment.</li>
                
        </ul>
    </p>
</blockquote></div>

<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
<p class="mb-0"><strong>WORKING ON TRAILER DECKS</strong></p>
<p class="mb-0"><h3>A "TAKE 3" RISK ASSESSMENT IS TO BE COMPLETED ON
EVERY OCCASION THAT ACCESS IS REQUIRED TO A
TRAIIÆR/TRAY DECK</h3> — <cite>unless a full risk assessment and
controls have been completed/are in place.</cite></p>

</blockquote></div>

<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>">
<blockquote>
    <p><strong>Question 1</strong></p>
   
    <p class="mb-0">All work on the top of trailer /tray deck must be avoided at all times unless:</p>

   <p>
        <ul>
                <li><input type="radio" name="rdoQ1" value='A'> A) You are not going to be on the trailer / tray deck for very long.</li>
                <li><input type="radio" name="rdoQ1" value='B'> B) Fall protection system is in place.</li>
                <li><input type="radio" name="rdoQ1" value='C'> C) You have a spotter.</li>
                <li><input type="radio" name="rdoQ1" value='D'> D) All of the above.</li>
        </ul>
    </p>
   <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
<p><strong>Question 2</strong></p>
    <p class="mb-0">What are examples of fall protection systems?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ2" value='A'> A) A mobile platform.</li>
                <li><input type="radio" name="rdoQ2" value='B'> B) A barrier gate on a trailer.</li>
                <li><input type="radio" name="rdoQ2" value='C'> C) A ladder.</li>
                <li><input type="radio" name="rdoQ2" value='D'> D) A & B.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
<p><strong>Question 3</strong></p>
    <p class="mb-0">Prior to any work being carried out on top of trailer /tray deck, the following must be considered:</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ3" value='A'> A) Explore all options not to work on the trailer / tray.</li>
                <li><input type="radio" name="rdoQ3" value='B'> B) Always work from ground level.</li>
                <li><input type="radio" name="rdoQ3" value='C'> C) Prior authorisation must be obtained from the respective manager /
                                                                supervisor and a Take 3 Risk Assessment must be undertaken.</li>
                <li><input type="radio" name="rdoQ3" value='D'> D) All of the above.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page7" style="<?php echo $style7;?>"><input name="style7" type="hidden" value="<?php echo $style7 ?>"><blockquote>
<p><strong>Question 4</strong></p>
    <p class="mb-0">When is a Take 3 Top of Trailer I Tray Deck Risk Assessment to be
completed?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ4" value='A'> A) On every occasion you are loading.</li>
                <li><input type="radio" name="rdoQ4" value='B'> B) On every occasion you are unloading.</li>
                <li><input type="radio" name="rdoQ4" value='C'> C) On every occasion that access to top of trailer /tray deck is required
                                                                unless a full risk assessment and controls have been completed
                                                                and are in place.</li>
                <li><input type="radio" name="rdoQ4" value='D'> D) All of the above.</li>
               
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>  
</blockquote></div>

<div id="page8" style="<?php echo $style8; ?>"><input name="style8" type="hidden" value="<?php echo $style8 ?>"><blockquote>
    
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