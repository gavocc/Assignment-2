<?php
/* This is the Social Media Policy Induction page. 
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
    $pdf->Write(5,'Congratulations! You have completed the induction course for Social Media Policy. ');
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
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style7']=='display:inline') {
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
        $StyleBtnAgree ='display:none';
        $StyleBtnPrint ='display:none';
        $StyleBtnPrevious ='display:inline';
        $StyleBtnNext ='display:inline';
        $StyleFooter ='display:inline';
     }
     elseif ($_POST['style7']=='display:inline') {
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
        'CourseName' => 'Social Media Policy',
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


$SubmitMessage = "You have successfully completed Social Media policy module.";

$StyleBtnPrint ='display:inline';

}
catch(Exception $e) {
    echo 'error Message: ' .$e->getMessage();
  }
#EndRegion
}

?>
<form action="/TrainingFiles/HR/SocialMedia.php" method="post">    
<div>
<div class="PageHeader"><h1>Social Media Policy</h1></div>

<div class="TextSection">
<div id="page1" style="<?php echo $style1; ?>"><input name="style1" type="hidden" value="<?php echo $style1 ?>"><blockquote>
    <p class="mb-0">The Company and it's related bodies corporate acknowledges that social media is a powerful communications tool
    that has the potential to significantly impact upon organisational and professional reputations. For this reason the company 
    recognises the need to have a policy which provides guidance to employees as to the Company's expectations in regards to the 
    personal use of social media.</p>
    <p class="mb-0">These guidelines are intended to apply to both those listed below as well as any other online platform
     that is currently available or becomes available, including social networking sites and sites with user-generated content.</p>
  
</blockquote></div>
<div id="page2" style="<?php echo $style2; ?>"><input name="style2" type="hidden" value="<?php echo $style2 ?>"><blockquote>
    <p class="mb-0">Social media includes the various online technology tools that enable people to communicate easily 
    via the internet to share information and resources. Social media can include but is not limited to, text, audio, video, 
    images, podcasts, and other multimedia communications. Examples include but not limited to the following: </p>
    <p>
        <ul class="square">
                <li>Social networking sites such as Facebook, Linked, etc. </li>
                <li>Video and photo sharing websites such as Flickr, Youtube, etc. </li>
                <li>Micro-blogging sites such as Twitter, etc. </li>
                <li>Weblogs, including corporate blogs, personal blogs or blogs hosted by traditional media publications. </li>
                <li>Forum and discussion boards such as whirlpool, Vogue. </li>
        </ul>
    </p>
    <p class="mb-0">Employees are expected to follow the same behavioural standards online as they would in a professional 
    environment. The same laws, professional expectations, and guidelines for interacting with co-workers, contractors and customers 
    apply online. Employees are personally liable for anything they post to social media sites. </p>
    <p>
   
</blockquote></div>
<div id="page3" style="<?php echo $style3; ?>"><input name="style3" type="hidden" value="<?php echo $style3 ?>"><blockquote>
    <p class="mb-0"><strong>Protect Confidential Information</strong></p>
    <p class="mb-0">You may not use social media to disclose the Companys' confidential information.
                    This includes non-public financial information and anything related to Companys'
                    strategy, services, policy, management, and potential acquisitions that have not been
                    made public.</p>
    <p class="mb-0">Protecting the confidential information of our employees, customers, partners and
                suppliers is also important. Do not mention them, in social media without their
                permission, and make sure you don’t disclose items such as sensitive personal
                information of others or details related to the Company’s business with its customers.</p>
</blockquote></div>
<div id="page4" style="<?php echo $style4; ?>"><input name="style4" type="hidden" value="<?php echo $style4 ?>"><blockquote>
    <p class="mb-0"><strong>Show respect for copyright and fair use of copyrighted material owned by others — including 
                        the Company’s own copyrights and brands.</strong></p>
        <p class="mb-0">Do not use the company logo or any of our divisional logos. This includes photos or
recordings of our vehicles/equipment and those of our customers.
</p>
<p class="mb-0"><strong>Respect and protect the companys' customers, employees, business
partners and suppliers.</strong></p>
<p class="mb-0">While participating in a discussion in an online community, never discuss or identify a
customer, employee, partner or supplier without specific permission from them.</p>
<p class="mb-0">Never discuss details of a business relationship or denigrate the company or its
customers, employees, business partners or suppliers.</p>
</blockquote></div>
<div id="page5" style="<?php echo $style5; ?>"><input name="style5" type="hidden" value="<?php echo $style5 ?>"><blockquote>
<p class="mb-0"><strong>Consideration towards other members of staff when using social networking
sites.</strong></p>
<p class="mb-0">For example, there may be an expectation that photographs taken at a company event will not
appear publicly on the Internet. Staff should be considerate to their colleagues in such
circumstance and should not post information unless they have expressly been given
permission to do so.</p>
<p class="mb-0">Under no circumstance should offensive comments be made about colleagues on the
Internet.</p>
<p class="mb-0"><strong>This may amount to cyber-bullying and could be treated as a disciplinary offence.</strong></p>
</blockquote></div>

<div id="page6" style="<?php echo $style6; ?>"><input name="style6" type="hidden" value="<?php echo $style6 ?>"><blockquote>
<p class="mb-0"><strong>Be conscious when mixing your business and personal lives.</strong></p>
<p class="mb-0">Online, your personal and professional lives can possibly intersect. The Company
respects the free speech rights of all of its employees, but you must remember that
customers, colleagues and supervisors often have access to the online content you
post.</p>
<p class="mb-0">Keep this in mind when publishing information online that can be seen by more than
friends and family, and know that information originally intended just for friends and
family can be forwarded on.</p>
</blockquote></div>

<div id="page7" style="<?php echo $style7; ?>"><input name="style7" type="hidden" value="<?php echo $style7 ?>"><blockquote>
<p class="mb-0"><strong>Be aware that the Internet is permanent</strong></p>
<p class="mb-0">Once information is published online, it is essentially part of a permanent record, even
if you “remove / delete” it later or attempt to make it anonymous.</p>
<p class="mb-0"><strong>Breaches of this Policy</strong></p>
<p class="mb-0">Disciplinary action may be taken against employees who are found to have breached
this policy, including summary dismissal in the event of what the Company considers to
be a serious breach by an employee.</p>
</blockquote></div>

<div id="page8" style="<?php echo $style8; ?>"><input name="style8" type="hidden" value="<?php echo $style8 ?>"><blockquote>
    
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