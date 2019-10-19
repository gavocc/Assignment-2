<?php
  session_start();
  require_once 'php/google-api-php-client/vendor/autoload.php';

  date_default_timezone_set('Australia/Melbourne');

#Region Private Methods
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Bigquery::BIGQUERY);
$bigquery = new Google_Service_Bigquery($client);
$projectId = 's3809839-cc2019';
$datasetId = 'InductionTraining';
$tableId   = 'TrainingRegistration';
$ReadRequest = new Google_Service_Bigquery_QueryRequest();
$ReadRequest->setUseLegacySql(false);

  $ReadRequest->setQuery("select CourseName,count(*) as total from InductionTraining.TrainingRegistration Group by CourseName  order by count(*) desc,coursename asc Limit 5;");
  $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
  $ReadRows = $ReadResponse->getRows();

 $array = array();
 foreach ($ReadRows as $ReadRow)
 {
   $array += array($ReadRow->f[0]->v => $ReadRow->f[1]->v);
        
 }
 
 //array("Peter"=>"35","Ben"=>"37","Joe"=>"43");

header('Content-Type: application/json');
//$a = rand(1,20);

//$array = array(65+$a,68+$a,75+$a,81+$a,95+$a,105+$a,130+$a,120+$a,105+$a,90+$a,75+$a,70+$a);

echo json_encode($array);
exit;

//#EndRegion
?>
