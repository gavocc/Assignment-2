<?php
/* This is the edit user profile page. 
   User will need to populate UserName(Required), Password(Required), FirstName, LastName and Email.
   Once saved, details will be updated in the User table in AWS DynamoDB.
*/

//#Region Import API
ob_start();
session_start();
require 'aws/aws-autoloader.php';
require_once 'fpdf181/fpdf.php';
use Aws\DynamoDb\DynamoDbClient;


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
	
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
 	.input-group-addon .fa {
        font-size: 18px;
    }
    .input-group{
        width:730px!important;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
        /* width:100px; */
    }
    .TextCenter{
        Text-align:center!important;
    }
    .Message{
        color:DarkRed!important;
    }
</style>
    </head>
<body>
<?php

//#Region Private Methods
$Message = "";

$client = new DynamoDbClient([
    'region'  => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
        'key'    => 'AKIAIOU7ZFE3Q235L6AQ',
        'secret' => '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'
     ]
    ]);   


$date = date('Y-m-d H:i:s');

if(isset($_POST['save']) ) {

    try {
  
    $response = $client->updateItem(array(
    'TableName' => 'User',
    'Key'=> array(
        'UserName' => array('S' =>$_POST['UserName']),
        'CreatedDateTime' => array('S' => $_POST['CreatedDateTime'])
    ),
    'ExpressionAttributeValues' =>  array (
    ':fnval'  => array('S' => $_POST['FirstName']),
    ':lnval' => array('S' => $_POST['LastName']),
    ':emval' => array('S' => $_POST['Email']),
    ':srval' => array('S' => $_POST['SecurityRole'])
    ),
    'UpdateExpression' => 'set FirstName = :fnval, LastName = :lnval, Email = :emval, SecurityRole = :srval',
    'ReturnValues' => 'ALL_NEW'
  ));

    $Message="Details saved successfully";

    //Reload new updated data
    $iterator = $client->getIterator('Scan', array(
    'TableName' => 'User',
    'FilterExpression' => 'UserName = :filter1',
        "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['UserName']))
    ));

    foreach ($iterator as $itr) {
     $strUserName = $itr["UserName"]['S'];
     $strPassword = $itr["Password"]['S'];
     $strFirstName = $itr["FirstName"]['S'];
      $strLastName = $itr["LastName"]['S'];
      $strEmail = $itr["Email"]['S'];
      $strCreatedDateTime = $itr["CreatedDateTime"]['S'];
      $strSecurityRole = $itr["SecurityRole"]['S'];
    }

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
}
elseif(isset($_POST['reset']) ) {
    $response = $client->updateItem(array(
        'TableName' => 'User',
        'Key'=> array(
            'UserName' => array('S' =>$_POST['UserName']),
            'CreatedDateTime' => array('S' => $_POST['CreatedDateTime'])
        ),
        'ExpressionAttributeValues' =>  array (
        ':pwdval'  => array('S' => 'WELCOME')),
        'UpdateExpression' => 'set Password = :pwdval',
        'ReturnValues' => 'ALL_NEW'
      ));
    
        $Message="Password reset successfully.";
    
        //Reload new updated data
        $iterator = $client->getIterator('Scan', array(
        'TableName' => 'User',
        'FilterExpression' => 'UserName = :filter1',
            "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['UserName']))
        ));
    
        foreach ($iterator as $itr) {
         $strUserName = $itr["UserName"]['S'];
         $strPassword = $itr["Password"]['S'];
         $strFirstName = $itr["FirstName"]['S'];
          $strLastName = $itr["LastName"]['S'];
          $strEmail = $itr["Email"]['S'];
          $strCreatedDateTime = $itr["CreatedDateTime"]['S'];
          $strSecurityRole = $itr["SecurityRole"]['S'];
        }
    
}
elseif(isset($_POST['delete']) ) {
    try {
    $response = $client->deleteItem(array(
        'TableName' => 'User',
        'Key'=> array(
            'UserName' => array('S' =>$_POST['UserName']),
            'CreatedDateTime' => array('S' => $_POST['CreatedDateTime'])
        ),
        'ConditionExpression' => 'UserName = :filter1',
            "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['UserName']))
        ));
    
        $Message="User deleted successfully.";
    
        $strUserName = "";
        $strPassword = "";
        $strFirstName = "";
         $strLastName = "";
         $strEmail = "";
         $strCreatedDateTime = "";
         $strSecurityRole = "";
    
     } catch (Exception $ex) {
       echo $ex->getMessage();
      }
}
else {
    if($_GET["strUserName"]!='') {
       $iterator = $client->getIterator('Scan', array(
        'TableName' => 'User',
        'FilterExpression' => 'UserName = :filter1',
         "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_GET["strUserName"]))
                                      ));
   
        foreach ($iterator as $itr) {
         $strUserName = $itr["UserName"]['S'];
         $strPassword = $itr["Password"]['S'];
         $strFirstName = $itr["FirstName"]['S'];
          $strLastName = $itr["LastName"]['S'];
          $strEmail = $itr["Email"]['S'];
          $strCreatedDateTime = $itr["CreatedDateTime"]['S'];
          $strSecurityRole = $itr["SecurityRole"]['S'];
        }
    }
  
}
//#EndRegion
  ?>

   <div class="col-lg-8 push-lg-4 personal-info">
           <H2>Edit User</H2>
             <form action="/edituser.php" method="post">
             <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">UserName</label>
                    <div class="col-lg-9">
                        <input class="form-control input-group" name="UserName" type="text" value="<?php echo $strUserName ?>" />
                        <input type="hidden" name="CreatedDateTime" type="text" value="<?php echo $strCreatedDateTime ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Password</label>
                    <div class="col-lg-9">
                        <input class="form-control input-group" name="Password" readonly type="text" value="<?php echo $strPassword ?>" />
                       
                    </div>
                </div>
             <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">First name</label>
                    <div class="col-lg-9">
                        <input class="form-control input-group" name="FirstName" type="text" value="<?php echo $strFirstName ?>" />
                    </div>
                </div>
              
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Last Name</label>
                    <div class="col-lg-9">
                        <input class="form-control input-group" name="LastName" type="text" value="<?php echo $strLastName ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control input-group" name="Email" type="text" value="<?php echo $strEmail ?>" />
                    </div>
                </div>
               
            <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Security Role</label>
              <div class="col-lg-9">
             <select name="SecurityRole" class="form-control input-group" >
              <option value=""></option>
              <option value="Administrator" <?php if($strSecurityRole == 'Administrator'){ echo ' selected="selected"'; } ?>>Administrator</option>
              <option value="Manager" <?php if($strSecurityRole == 'Manager'){ echo ' selected="selected"'; } ?>>Manager</option>
              <option value="Employee" <?php if($strSecurityRole == 'Employee'){ echo ' selected="selected"'; } ?>>Employee</option>
              </select>
              </div>
          </div>
        <div class="form-group PaddingTop TextCenter">
            <label for="Error" class="Message"><?php echo $Message; ?></label>
        </div>
        <div class="form-group TextCenter">
            <button name="save" type="submit" class="btn btn-primary active">Save</button> <button name="delete" type="submit" class="btn btn-primary active">Delete</button> <button name="reset" type="submit" class="btn btn-primary active">Reset Password</button>
        </div>
         
       </form>
   </div>

   

</body>
</html>