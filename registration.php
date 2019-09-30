<?php
/* This is the registration page for new user. 
   User will need to populate UserName(Required), Password(Required), FirstName, LastName and Email.
   Once registration is successful, details will be inserted into the User table in Google cloud BigQuery table.
*/

//#Region Import API
ob_start();
session_start();
require_once 'php/google-api-php-client/vendor/autoload.php';
//#End Region
?>

<html>
<head>
      <!-- [START css] -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <!-- [END css] -->

     <style type="text/css">
	.login-form {
		width: 390px;
		margin: 50px auto;
	}
    .login-form form {        
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
 	.input-group-addon .fa {
        font-size: 18px;
    }
    .input-group{
        width:330px!important;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
        width:150px;
    }
    .TextCenter{
        Text-align:center!important;
    }
    .Message{
        color:LightBlue!important;
    }
</style>
    </head>
<body>
<?php

//#Region Private Methods
$Message = "";
if(isset($_POST['UserID']) && isset($_POST['Password']) ) {

	$client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google_Service_Bigquery::BIGQUERY);
    $bigquery = new Google_Service_Bigquery($client);
    $projectId = 's3809839-cc2019';
    
    $datasetId = 'InductionTraining';
    $tableId   = 'User';
    $date = date('Y-m-d H:i:s');
   
    $data = array('UserName' => $_POST['UserID'],
        'Password' => $_POST['Password'],
       'FirstName' => $_POST['FirstName'],
        'LastName' => $_POST['LastName'],
       'Email' => $_POST['Email'],
       'CreatedDateTime' =>  str_replace(' ', 'T', $date));

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
        $Message = "Registration successful";
    
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    
}
//#EndRegion
  ?>
<div class="login-form">
    <form action="/registration.php" method="post">
        <h2 class="text-center">Registration</h2>
        <div class="form-group">
        	<div class="input-group">
                <input type="text" name="UserID" class="form-control" placeholder="Username" required="required">
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <input type="password" name="Password" class="form-control" placeholder="Password" required="required">
            </div>
        </div>
        <div class="form-group">
        	<div class="input-group">
                <input type="text" name="FirstName" class="form-control" placeholder="First Name" required="required">
            </div>
        </div>
        <div class="form-group">
        	<div class="input-group">
                <input type="text" name="LastName" class="form-control" placeholder="Last Name" required="required">
            </div>
        </div>
        <div class="form-group">
        	<div class="input-group">
                <input type="text" name="Email" class="form-control" placeholder="Email">
            </div>
        </div> 
        <div class="form-group TextCenter">
            <button type="submit" class="btn btn-primary active">Submit</button>
        </div>
        <div class="form-group PaddingTop TextCenter">
            <label for="Error" class="Message"><?php echo $Message; ?></label>
        </div>
    </form>
    <p class="text-center small">Already Registered! <a href="/login.php">Click here to login</a>.</p>
</div>
</body>
</html>