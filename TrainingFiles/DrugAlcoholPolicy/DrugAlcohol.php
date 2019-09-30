<?php
/* This is the Drug and Alcohol Policy Induction page. 
   User will go through each slide/section by clicking on Next button or go back to previous slide by clicking on the Previous button.
   Once reaching the last slide, user will have to click on the Agree button to complete the induction course.
   Upon completing the course, a print certificate button will be visible and by clicking on the print button it will generate a 
   completion certificate in pdf format.
   Record will be inserted into AWS Dynamodb table. The table name is TrainingRegistration.
*/

//#Region Import API
   ob_start();
   session_start();
   require_once 'php/google-api-php-client/vendor/autoload.php';
   require 'aws/aws-autoloader.php';
    require_once 'fpdf181/fpdf.php';
     date_default_timezone_set('America/New_York');
   
   use Aws\DynamoDb\DynamoDbClient;
//#End Region

?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
.ul, li {
    padding:5px;
}

</style> 
</head>
<body class="content">

<?php
//#Region "Insert registration record into dynamodb table and generate pdf"
$SubmitMessage='';
$strUserName = $_SESSION['UserName'];
date_default_timezone_set("Australia/Melbourne");

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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Drug and Alcohol Policy. ');
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
$style5 = 'display:none';;
$style6 = 'display:none';
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

   $client = new DynamoDbClient([
    'region'  => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
        'key'    => 'AKIAJTUYQD5U6L7MXOOQ',
        'secret' => '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'
     ]
    ]);   
    
try {
   
$date = date('d-m-Y H:i:s');

//Insert into Dynamodb TrainingRegistration table.
 $response = $client->putItem(array(
    'TableName' => 'TrainingRegistration', 
    'Item' => array(
        'UserName'   => array('S' => $strUserName),
        'Category'  => array('S' => 'HR'),
        'CourseName'  => array('S' => 'Drug and Alcohol Policy'),
         'CompletedDate'  => array('S' => strval($date)),
    )
));

$SubmitMessage = "You have successfully completed Drug and Alcohol policy module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();
  }
#EndRegion
}

?>
<form action="/TrainingFiles/DrugAlcoholPolicy/DrugAlcohol.php" method="post">    
<div>
<div class="PageHeader"><h1>Drug and Alcohol Policy</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
    <p class="mb-0">Company has a duty of care to provide a healthy and safe environment to all persons performing work
     and/or acting as a company representative, free from any adverse effects of drugs or alcohol.</p>
     <p>Workers have a duty of care to ensure their health and safety and the health and safety of others around them 
     is not placed at risk due to being impaired by either the effects of drugs or alcohol during the course of performing duties
     within their role at work.</p>
  
</blockquote></div>
<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
    <p class="mb-0">Whilst undertaking all work on Company or Customer sites the policy consists of:</p>
    <p>
        <ul>
            <li>The use, consumption, possession, storage, manufacture, sale, purchase, distribution or transfer of illicit
                substances is prohibited. </li>
                <li>The unauthorised use, consumption, possession, storage, manufacture, sale, purchase, distribution or transfer of illicit
                substances, prescription and pharmacy drugs or alcohol is prohibited. </li>
                <li>Workers are prohibited from the opreation of equipment, machinery and/or if they have consumed or taken illicit 
                    substances, prescription and pharmacy drugs unless prior to the commencement of work, management has been provided
                  with written confirmation from the workers medical practitioner, that the taking of prescribed/non-prescribed medication
                  does not affect the workers ability to perform work safely and does not breach any prescribed legal limits. </li>
        </ul>
    </p>
   
</blockquote></div>
<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
    <p class="mb-0"><h4>Whilst undertaking all work on Company or Customer sites the policy consists of:</h4></p>
    <p>
        <ul>
            <li>Workers are encouraged to notify the Company of any drug or alcohol dependency or work related situation
                conducive to or involving drug or alcohol abuse, or breach of this policy. The company will take reasonable steps
             to investigate and respond to such notifications. </li>
                <li>Workers who attend business or work social functions where alcohol is served should ensure they observe 
                    responsible consumption in regard to their behaviour and legal driving responsibilities. </li>
               </ul>
    </p>
    
</blockquote></div>
<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>"><blockquote>
    <p class="mb-0"><h4>Whilst undertaking all work on Company or Customer sites the policy consists of:</h4></p>
    <p>
        <ul>
            <li>The Company will conduct drug and alcohol testing to support this policy. This process will include both random
                 and "show cause" testing. Workers who test positive to drugs or alcohol will be declared unfit for work and 
                required to participate in remedial plan to return to work free from drugs or alcohol.</li>
                <li>Prescribed drug and alcohol content legal limits are set by applicable laws, rules, procedures and/or 
                    Australian Standards (in each case to the strictest criteria applicable) relevant to the worker duties. </li>
               </ul>
    </p>
   
</blockquote></div>
<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
    <p class="mb-0">Workers may face disciplinary procedures including termination if they: </p>
    <p>
        <ul>
            <li>Recklessly place the health and safety of themselves and/or other persons at risk.</li>
                <li>Tested positive to drugs or alcohol. </li>
                <li>Refuse to participate in the random testing process. </li>
                <li>Refuse to participate in remedial processes. </li>
               </ul>
    </p>
  
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