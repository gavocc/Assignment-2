<?php
/* This is the Mobile Phone Policy Induction page. 
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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Mobile Phone Policy. ');
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
    if ($style1=='display:inline' || $_POST['style1']=='display:inline') {
        $page=' Page 2';
        $style1 = 'display:none';
        $style2 = 'display:inline';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
      
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
      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style5']=='display:inline') {
        $page=' Page 6';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:inline';
      
        $StyleBtnAgree ='display:inline';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:none';
        $StyleFooter ='display:none';
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
     
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
   
}
elseif(isset($_POST['agree'])) {
 
   $page=' Page 6';
   $style1 = 'display:none';
   $style2 = 'display:none';
   $style3 = 'display:none';
   $style4 = 'display:none';
   $style5 = 'display:none';
   $style6 = 'display:inline';

   $StyleBtnAgree ='display:none';
   $StyleBtnPrint ='display:none';
   $StyleBtnPrevious ='display:none';
   $StyleBtnNext ='display:none';
   $StyleFooter ='display:none';

try {
        
    $date = date('Y-m-d H:i:s');
   
    $data = array('UserName' => $strUserName,
        'CourseName' => 'Mobile Phone Policy',
        'Category' => 'HR',
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


$SubmitMessage = "You have successfully completed Mobile Phone policy module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();
  }
#EndRegion
}

?>
<form action="/TrainingFiles/HR/MobilePhone.php" method="post">    
<div>
<div class="PageHeader"><h1>Mobile Phone/Device Policy</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
    <p class="mb-0">The objective of this policy is to provide guidance on the safe and responsible use of
mobile phones / devices. Whilst mobile phones / devices have become an effective
means of communication, they also can be a distraction creating a risk during driving
and/or work activities.</p>
    <p class="mb-0">Mobile phones / devices will be allocated to employees where a business requirement
can be demonstrated. It is acknowledged that at times there is a need to use
Company mobiles / devices for private use, but this must be minimised. Mobile phone
usage is subject to regular audits, the results of which are reported to Line Managers
and/or the Managing Director.</p>
<p class="mb-0">Where employees use their personal phones for authorised business use, claims can
be made for reasonable re-imbursement.</p>
</blockquote></div>
<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
    <p class="mb-0">As is the case with any Company property, equipment or facility, inappropriate use of
mobile phones I devices is prohibited. </p>
<p class="mb-0">Users of Company mobile phones must take all reasonable steps to keep the
Company communication costs to realistic levels in line with the needs of the
business and to ensure such items remain secure. </p>
<p class="mb-0">Guidelines for the use of mobile phones / devices are as follows:</p>
    <p>
        <ul class="square">
                <li>Private use must be minimised. </li>
                <li>Mobile phones should not be left unattended in cars. </li>
        </ul>
    </p>
</blockquote></div>
<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
    <p class="mb-0"><strong>Road Safety Rules</strong></p>
    <p class="mb-0">Drivers must adhere to relevant State Road laws / regulations in relation to the use of
mobile phones, and are responsible to familiarise themselves with such information.</p>
<p class="mb-0">In general, mobile phone use is prohibited whilst driving a vehicle unless the phone is:</p>
    <p>
        <ul class="square">
                <li>Secured in a commercially designed holder fixed to vehicle. </li>
                <li>Operated by the driver without touching any part of the phone - e.g. voice
                    activated. </li>
                <li>Texting I e-mailing from mobile phones whilst driving a vehicle is prohibited. </li>
                <li>Holding a phone whilst driving is prohibited. </li>
        </ul>
    </p>
</blockquote></div>
<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>"><blockquote>
    <p class="mb-0"><strong>General Operations Safety Rules</strong></p>
    <p>
        <ul class="square">
                <li>Mobile phone use is prohibited whilst operating mobile plant / equipment (e.g. Forklifts,
Isoloader)</li>
                <li>During loading I unloading of vehicles - drivers may only use mobile phones if they are
located within the driver safe area or within the cabin of their trucks, when the vehicle is
parked / stationary.</li>
                <li>Mobile phones are not to be used, under any circumstances, near fuel bowsers or LPG
filling stations or any other flammable substance or material, as they can be a source of
ignition. Where employees are required to re-fuel their vehicles or mobile plant, mobile
phones are to be turned off. </li>
                <li>Company workers will observe and are expected to comply with other site safety rules, policy
and procedures that may be more stringent than this existing policy. This may include
compliance with customer / contract requirements. </li>
        </ul>
    </p>
</blockquote></div>

<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
<p class="mb-0">Mobile phones should be turned off if a risk to safety exists by being
distracted in/during the completion of work tasks.</p>
<p class="mb-0">Employees are expected to abide to this policy and are responsible for
any penalty arising from a breach of laws, and/or may face disciplinary
action for non-compliance.</p>
</blockquote></div>

<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
    
    <div class="TextCenter" >
      <h3>"I have understood and agree to be bound by the terms of this policy".</h3>
   </div>
   <div class="TextCenter PaddingTop">
   <label for="Message" class="SubmittedMessage"><?php echo $SubmitMessage; ?></label>
   </div>
  
</blockquote></div>

<div class="TextCenter">
<footer class="blockquote-footer PageFooter" style="<?php echo $StyleFooter; ?>"><cite><?php echo $page; ?></cite></footer>
   
<button type="submit" name="print" class="btn btn-primary" style="<?php echo $StyleBtnPrint; ?>">Print Certificate</button><button type="submit" name="agree" class="btn btn-primary" style="<?php echo $StyleBtnAgree; ?>">Agree</button><button type="submit" name="previous" class="btn btn-primary" style="<?php echo $StyleBtnPrevious; ?>">Previous</button> <button type="submit" name="next" class="btn btn-primary" style="<?php echo $StyleBtnNext; ?>">Next</button>
</div>

</div>
</div>
</form>
</body>
</html>