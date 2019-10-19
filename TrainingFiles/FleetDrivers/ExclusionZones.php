<?php
/* This is the Loading/Unloading Exclusion Zones Induction page. 
   User will go through each slide/section by clicking on Next button or go back to previous slide by clicking on the Previous button.
   Once reaching the last slide, user will have to click on the Submit button to complete the induction course.
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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Loading/Unloading Exclusion Zones. ');
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
$style11 = 'display:none';
$style12 = 'display:none';
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
        $style11 = 'display:none';
        $style12 = 'display:none';    
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
        $style11 = 'display:none';
        $style12 = 'display:none';
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
        $style11 = 'display:none';
        $style12 = 'display:none';       
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
        $style11 = 'display:none';
        $style12 = 'display:none';  
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
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none';
        $style11 = 'display:none';
        $style12 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style6']=='display:inline') {
        
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
        $style11 = 'display:none';
        $style12 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style7']=='display:inline') {

        if(isset($_POST['rdoQ1']))
        {
            if ($_POST['rdoQ1']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ1']!='D'){
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
        $style11 = 'display:none';
        $style12 = 'display:none';   
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
            $style11 = 'display:none';
            $style12 = 'display:none';       
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
        $style11 = 'display:none';
        $style12 = 'display:none';   
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
       }
     }
     elseif ($_POST['style8']=='display:inline') {
       
        if(isset($_POST['rdoQ2']))
        {
            if ($_POST['rdoQ2']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ2']!='B'){
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
        $style11 = 'display:none';
        $style12 = 'display:none';     
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
        $style11 = 'display:none';
        $style12 = 'display:none';        
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
        $style11 = 'display:none';
        $style12 = 'display:none';     
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     
    }
     elseif ($_POST['style9']=='display:inline') {
        if(isset($_POST['rdoQ3']))
        {
            if ($_POST['rdoQ3']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ3']!='C'){
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
        $style11 = 'display:none';
        $style12 = 'display:none';       
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
        $style11 = 'display:none';
        $style12 = 'display:none';         
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
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
        $style11 = 'display:none';
        $style12 = 'display:none';       
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
     }
    }
     elseif ($_POST['style10']=='display:inline') {
        if(isset($_POST['rdoQ4']))
        {
            if ($_POST['rdoQ4']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ4']!='D'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         if ($errorMessage !='') {
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
        $style11 = 'display:none';
        $style12 = 'display:none';       
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
        $page=' Page 11';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none';
        $style11 = 'display:inline';
        $style12 = 'display:none';    
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
        }
       }
       else {
        $errorMessage = "Please select an answer to proceed."; 
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
        $style11 = 'display:none';
        $style12 = 'display:none';       
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
       }
     }
     elseif ($_POST['style11']=='display:inline') {
        if(isset($_POST['rdoQ5']))
        {
            if ($_POST['rdoQ5']=='') {
                $errorMessage = "Please select an answer to proceed."; 
            }
            elseif($_POST['rdoQ5']!='A'){
                $errorMessage = "You have selected an incorrect answer. Please try again."; 
            }
         if ($errorMessage !='') {
           $page=' Page 11';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none'; 
        $style11 = 'display:inline';
        $style12 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
          
        }
        else {
        $page=' Page 12';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none'; 
        $style11 = 'display:none';
        $style12 = 'display:inline';
        $StyleBtnAgree ='display:inline';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:none';
        $StyleFooter ='display:none';
        }
     }
     else {
        $errorMessage = "Please select an answer to proceed.";
        $page=' Page 11';
        $style1 = 'display:none';
        $style2 = 'display:none';
        $style3 = 'display:none';
        $style4 = 'display:none';
        $style5 = 'display:none';
        $style6 = 'display:none';
        $style7 = 'display:none';
        $style8 = 'display:none';
        $style9 = 'display:none';
        $style10 = 'display:none'; 
        $style11 = 'display:inline';
        $style12 = 'display:none';      
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:none';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
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
        $style11 = 'display:none';
        $style12 = 'display:none';      
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
        $style11 = 'display:none';
        $style12 = 'display:none'; 
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
        $style11 = 'display:none';
        $style12 = 'display:none';
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
        $style11 = 'display:none';
        $style12 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style6']=='display:inline') {
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
        $style11 = 'display:none';
        $style12 = 'display:none';  
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
}
elseif(isset($_POST['agree'])) {
 
   $page=' Page 12';
   $style1 = 'display:none';
   $style2 = 'display:none';
   $style3 = 'display:none';
   $style4 = 'display:none';
   $style5 = 'display:none';
   $style6 = 'display:none';
   $style7 = 'display:none';
   $style8 = 'display:none';
   $style9 = 'display:none';
   $style10 = 'display:none';  
   $style11 = 'display:none';
   $style12 = 'display:inline'; 
   $StyleBtnAgree ='display:none';
   $StyleBtnPrint ='display:none';
   $StyleBtnPrevious ='display:none';
   $StyleBtnNext ='display:none';
   $StyleFooter ='display:none';

      
try {
      
    $date = date('Y-m-d H:i:s');
   
    $data = array('UserName' => $strUserName,
        'CourseName' => 'Exclusion Zones',
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


$SubmitMessage = "You have successfully completed Loading/Unloading Exclusion Zones module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();

  }
#EndRegion
}

?>
<form action="/TrainingFiles/FleetDrivers/ExclusionZones.php" method="post">    
<div>
<div class="PageHeader"><h1>Loading & Unloading Exclusion Zones (LUEZ)</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
<p class="mb-0"><strong>Introduction</strong></p>
    <p class="mb-0">The issue of truck driver and the safety of other people around mobile plant
equipment during loading and unloading operations — referred to as ‘loading,
unloading exclusion zones’ (LUEZ) is one of the significant safety issues
confronting all levels of Industries within the supply chain.</p>
<p class="mb-0"><cite>The LUEZ Guidelines are the standards adopted across all company sites.</cite></p>
</blockquote></div>

<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
<p class="mb-0"><strong>Purpose</strong></p>
<p class="mb-0">The purpose of this Safe Operating Procedure (SOP) is to ensure that whilst loading and unloading
operations are in progress, all people are aware of:</p>

    <p>
        <ul class="square">
                <li>Requirements of exclusion zones and safety zones.</li>
                <li>Forklift driver I material handling equipment Operators’ responsibilities.</li>
                <li>Truck driver responsibilities during the loading and/or unloading process.</li>
                <li>Individual responsibilities in areas where forklifts and/or material handling equipment are
operating.</li>
        </ul>
    </p>
    <p class="mb-0"><strong>Aim</strong></p>
    <p class="mb-0">The aim for establishing exclusion zones and safety zones is to segregate drivers and other people
from forklift and/or materials handling traffic/activity during the load/unload process, to reduce the risk
of serious injury, or incidents involving forklifts and/or materials handling equipment and people.</p>
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
    <p class="mb-0"><strong>Preparation</strong></p>
    <p class="mb-0">Prior to loading / unloading activities commencing workers must complete the following:</p>
    <p>
        <ul class="square">
                <li>Inspect the loading / unloading area to ensure the work area is free from of obstruction, slip,
                    trip hazards and the ground surface is even.</li>
                <li>Conduct a visual inspection to ensure:
                <ul class="square">
                    <li>
                    Product / packaging integrity is confirmed — i.e. Items of the load are bound together to
                    form a single unitised load on a pallet — using either / or a combination of banding,
                    strapping, gluing, stretch wrapping and shrink wrapping.
                    </li>
                    <li>Load is positioned correctly on trailer / tray deck and is not unstable and/or dislodged.</li>
                    <li>The gates and/or product do not appear to be leaning or pressing against the curtain /
                        tarp.</li>
                        <li>Load is positioned correctly on trailer / tray deck and is not unstable and/or dislodged.</li>
                        <li>There are no protrusions or bulges in the curtain / tarp indicating load movement.</li>
                 </ul>
                </li>
        </ul>
    </p>
   
</blockquote></div>

<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
    <p class="mb-0"><strong>Loading, Unloading Exclusion Zones (LUEZ) Guidelines</strong></p>
    <p class="mb-0">There are three fundamental principles involving best practice safety systems control for
the management of loading/unloading operations.</p>
<p class="mb-0">These principles are:</p>
    <p>
        <ul class="square">
                <li>That the forklifts, or other equipment, used for loading / unloading and the drivers,
                    and other pedestrians, are segregated.</li>
                    <li>That authority for the area in which the loading/unloading activity is occurring resides
                    with the forklift operator and/or materials handling operator.</li>
                    <li>Should the driver cease to be in the direct line of sight of the operator at any stage
                    during the loading / unloading activity, the loading/unloading activity is to immediately
                    stop and not resume again until a direct line of sight is re-established between the
                    operator and the driver.</li>
              </ul>
    </p>
   
</blockquote></div>

<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
    <p class="mb-0"><strong>Separation of People and Equipment</strong></p>
    <p>
        <ul class="square">
                <li>To avoid any injury, separation of people and equipment must be at the forefront
                    on any effective LUEZ system.</li>
                    <li>The <strong>greater the strength of separation (i.e. physical) the greater the control</strong>
                        and the less likelihood of an incident occurring - based on the hierarchy of
                        controls.</li>
                    <li>The quality of the separation is a vital factor in determining strength of
                        separation.</li>
              </ul>
    </p>
</blockquote></div>

<div id="page7" style="<?php echo $style7; ?>"><input name="style7" type="hidden" value="<?php echo $style7 ?>">

<blockquote>
    <p><strong>Question 1</strong></p>
   
    <p class="mb-0">Who does this Safety Operating Procedure apply to?</p>

   <p>
        <ul>
                <li><input type="radio" name="rdoQ1" value='A'> A) Only truck drivers.</li>
                <li><input type="radio" name="rdoQ1" value='B'> B) Only forklift/material handling operators.</li>
                <li><input type="radio" name="rdoQ1" value='C'> C) Both truck drivers and forklift/material handling operators.</li>
                <li><input type="radio" name="rdoQ1" value='D'> D) All workers, including drivers, contractors, agency worker, visitors.</li>
        </ul>
    </p>
   <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page8" style="<?php echo $style8; ?>"><input name="style8" type="hidden" value="<?php echo $style8 ?>"><blockquote>
<p><strong>Question 2</strong></p>
    <p class="mb-0">What is the main aim of LUEZ?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ2" value='A'> A) Teach workers what LUEZ stands for.</li>
                <li><input type="radio" name="rdoQ2" value='B'> B) Segregate people from the loading and/or unloading process involving
                                                                materials handling equipment.</li>
                <li><input type="radio" name="rdoQ2" value='C'> C) Load restraint.</li>
                <li><input type="radio" name="rdoQ2" value='D'> D) Assist the forklift/material handling operator in loading/unloading of freight.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page9" style="<?php echo $style9; ?>"><input name="style9" type="hidden" value="<?php echo $style9 ?>"><blockquote>
<p><strong>Question 3</strong></p>
    <p class="mb-0">Choose which hazard does not apply to LUEZ?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ3" value='A'> A) Struck by materials handling equipment.</li>
                <li><input type="radio" name="rdoQ3" value='B'> B) Struck by freight.</li>
                <li><input type="radio" name="rdoQ3" value='C'> C) Electrocution.</li>
                <li><input type="radio" name="rdoQ3" value='D'> D) Struck by other vehicles.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page10" style="<?php echo $style10; ?>"><input name="style10" type="hidden" value="<?php echo $style10 ?>"><blockquote>
<p><strong>Question 4</strong></p>
    <p class="mb-0">What are the key principles of LUEZ?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ4" value='A'> A) Segregation of forklifts and other equipment used for loading / unloading from
                    drivers and other pedestrians.</li>
                <li><input type="radio" name="rdoQ4" value='B'> B) The forklift/material handling operator retains the authority in which the
                        loading/unloading activity is occurring.</li>
                <li><input type="radio" name="rdoQ4" value='C'> C) Line of site must be maintained during the loading/unloading activity.</li>
                <li><input type="radio" name="rdoQ4" value='D'> D) All of the above.</li>
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>  
</blockquote></div>

<div id="page11" style="<?php echo $style11; ?>"><input name="style11" type="hidden" value="<?php echo $style11 ?>"><blockquote>
<p><strong>Question 5</strong></p>
    <p class="mb-0">The greater the strength of separation (that is physical control) the greater the control?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ5" value='A'> A) True.</li>
                <li><input type="radio" name="rdoQ5" value='B'> B) False.</li>
                <li><input type="radio" name="rdoQ5" value='C'> C) None of the above.</li>
               </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page12" style="<?php echo $style12; ?>"><input name="style12" type="hidden" value="<?php echo $style12 ?>"><blockquote>
    
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