<?php
/* This is the Emergency Preparedness Induction page. 
   User will go through each slide/section by clicking on Next button or go back to previous slide by clicking on the Previous button.
   Once reaching the last slide, user will have to click on the Agree button to complete the induction course.
   Upon completing the course, a print certificate button will be visible and by clicking on the print button it will generate a 
   completion certificate in pdf format.
   Record will be inserted into Big Query table. The table name is TrainingRegistration.
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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Emergency Preparedness. ');
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
                elseif($_POST['rdoQ1']!='B'){
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
        'CourseName' => 'Emergency Preparedness',
        'Category' => 'Warehouse',
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


$SubmitMessage = "You have successfully completed Emergency Preparedness module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();

  }
#EndRegion
}

?>
<form action="/TrainingFiles/Warehouse/EmergencyPreparedness.php" method="post">    
<div>
<div class="PageHeader"><h1>Emergency Preparedness</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
<p class="mb-0"><strong>Introduction</strong></p>
    <p class="mb-0">The purpose of this training is to provide the participant with the knowledge and the skills to be able to
competently assess the risk and act accordingly in the event of an evacuation. It is designed to assist
and direct people to appropriate facilities and assembly areas in the event of an emergency and to
ensure that they are fully prepared in the event of an evacuation. The evacuation could relate to many
differing forms of emergency or business interruption and could include but is not limited to:</p>

<p class="mb-0">There are 3 main ways in which management and employees can identify hazards within
the company operations. These include:</p>
<p>
        <ul class="square">
                <li>Fire</li>
                <li>Flood</li>
                <li>Chemical spills</li>
                <li>Personal threat</li>
                <li>Trapped by Machinery</li>
                <li>Bomb threats</li>
        </ul>
    </p>

<p class="mb-0">If experiencing any difficulties at all, evacuate immediately.</p>
<p class="mb-0">Life preservation should be the major aim of your emergency procedure.</p>
</blockquote></div>

<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
<p class="mb-0"><strong>Fire awareness in the workplace</strong></p>
<p class="mb-0">Portable extinguishers are the first method of equipment used for fighting fires and are particularly
effective for small fires. Portable fire extinguishers can save lives, property and equipment by putting
out or containing lires. The extinguisher must be the correct type for the particular lire and must be
used correctly.</p>
<p class="mb-0">You must contact your chief warden to alert them to the emergency happening within your area and
to question whether or not you should fight the fire at all, as portable equipment has general
limitations which may include:</p>
<p>
        <ul class="square">
                <li>The equipment has limited capacity and may be exhausted before the fire is extinguished.</li>
                <li>The equipment has limited range, necessitating the operator to come within close proximity to the
fire.</li>
                <li>The equipment has a measure of unreliability if not correctly maintained.</li>
                
        </ul>
    </p
</blockquote></div>

<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
<p class="mb-0"><h3><strong>Flood</strong></h3></p>
<p class="mb-0"><strong>Safety Issues:</strong></p>
<p>
        <ul class="square">
                <li>What is in the water? Has it mixed with dangerous chemicals, sewerage, etc?</li>
                <li>What is floating in the water which you cannot see?</li>
                <li>How deep is the water? You might not be able to see the large hole or basement stairs covered in
water. Access pit lids usually float off in flooded water.</li>
                 <li>Is the water live with electricity? For floods inside buildings, this is especially dangerous with most
power points and power boards close to the floor.</li>
        </ul>
    </p>

<p class="mb-0"><h3><strong>Chemical spills</strong></h3></p>
<p class="mb-0">The range and quantity of hazardous substances used in the workplace may differ and requires pre
planning to respond safely to chemical spills. The cleanup of a chemical spill should only be done by
knowledgeable and experienced personnel. Spill kits with instwctions, absorbents, reactants and
protective equipment should be available to clean up minor spills. A minor chemical spill is one that
employees should be capable of handling safely without the assistance of safety and emergency
personnel, however, you must notify your supervisor. All other chemical spills are considered major
and must have this specialist assistance.</p>
</blockquote></div>

<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>">
<blockquote>
    <p><strong>Question 1</strong></p>
   
    <p class="mb-0">An Area Warden is responsible for the entire site during an evacuation?</p>

   <p>
        <ul>
                <li><input type="radio" name="rdoQ1" value='A'> A) True.</li>
                <li><input type="radio" name="rdoQ1" value='B'> B) False.</li>
               </ul>
    </p>
   <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
<p><strong>Question 2</strong></p>
    <p class="mb-0">Who do you contact in the event of an emergency?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ2" value='A'> A) OHS Department. </li>
                <li><input type="radio" name="rdoQ2" value='B'> B) Chief Fire Warden.</li>
                <li><input type="radio" name="rdoQ2" value='C'> C) The Finance Department.</li>
                
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
<p><strong>Question 3</strong></p>
    <p class="mb-0">A minor chemical spill is one that employees should be capable of handling safely.</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ3" value='A'> A) True.</li>
                <li><input type="radio" name="rdoQ3" value='B'> B) False.</li>
               
        </ul>
    </p>
    <div style="text-align:center"><label class="error"><?php echo $errorMessage; ?></label></div>
</blockquote></div>

<div id="page7" style="<?php echo $style7;?>"><input name="style7" type="hidden" value="<?php echo $style7 ?>"><blockquote>
<p><strong>Question 4</strong></p>
    <p class="mb-0">If you found a locked room during your area search in an evacuation, you
should....?</p>
   <p>
        <ul>
                <li><input type="radio" name="rdoQ4" value='A'> A) Search for the keys to unlock it.</li>
                <li><input type="radio" name="rdoQ4" value='B'> B) Break the door down.</li>
                <li><input type="radio" name="rdoQ4" value='C'> C) Knock on the door, if no answer, move on.</li>
                <li><input type="radio" name="rdoQ4" value='D'> D) Find another way to check that room.</li>
        
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