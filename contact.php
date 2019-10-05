<?php
  /* This is the contact page, where a user can enter a message and submit it
     The message, as well as the username will be inserted into a BigQuery table called contacts
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
      .TextCenter {
        Text-align:center!important;
      }
      .Message {
        color:LightBlue!important;
      }
      .hidden {
        display: none;
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
        $tableId   = 'Contacts';
        $date = date('Y-m-d H:i:s');

        $data = array(
          'UserName' => $_POST['UserID'],
          'Subject' => $_POST['Subject'],
          'Message' => $_POST['Message'],
          'CreatedDateTime' =>  str_replace(' ', 'T', $date)
        );

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
          $Message = "Message saved!";

        } catch (Exception $ex) {
          echo $ex->getMessage();
        }

      }
    //#EndRegion
    ?>
    <div class="login-form">
      <form action="/contact.php" method="post">
        <h2 class="text-center">Submit a Query</h2>
        <div class="form-group">
        	<div class="input-group">
            <input type="text" name="Subject" class="form-control" placeholder="Subject of message" required="required">
          </div>
        </div>
		    <div class="form-group">
          <div class="input-group">
            <textarea name="Message" class="form-control" rows=8>
          </div>
        </div>
        <div class="hidden">
        	<input type="text" name="UserID" value="<?php $_SESSION['UserName'] ?>">
        </div>
        <div class="form-group TextCenter">
          <button type="submit" class="btn btn-primary active">Submit</button>
        </div>
        <div class="form-group PaddingTop TextCenter">
          <label for="Error" class="Message"><?php echo $Message; ?></label>
        </div>
      </form>
    </div>
  </body>
</html>
