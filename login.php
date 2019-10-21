<?php
/* This is the login page for the Employee Induction Portal. 
   User will need to populate UserName and Password.
   The page will check the username and password entered against the User table in Google Cloud
   using BigQuery. If validation failed, a message 'Username or Password is invalid' will be visible.
*/

//#Region Import API
ob_start();
session_start();
require 'aws/aws-autoloader.php';
use Aws\DynamoDb\DynamoDbClient;

date_default_timezone_set('Australia/Melbourne');
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
		width: 380px;
		margin: 140px auto;
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
    .btn {        
        font-size: 15px;
        font-weight: bold;
        width:150px;
    }
    .TextCenter{
        Text-align:center!important;
    }
    .ErrorMessage{
        color:Red!important;
    }
    .header{
        font-size:20px;
        background:beige;
        padding:10px;
        height:100px;
        color:#ab1815;
        font-weight:bold;
        margin-bottom:10px;
        background-image: url('images/images.jpg');
    }
</style>
    </head>
<body>

<?php
//#Region Private Methods
$_SESSION['UserName']='';
$strUserID='';
$ErrorMessage='';

$client = new DynamoDbClient([
    'region'  => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
        'key'    => '<Enter your AWS Access Key here>',
        'secret' => '<Enter your AWS Secret Key here>'
     ]
    ]);   

if(isset($_POST['UserID']) && isset($_POST['Password']) ) {
  if (empty($_POST["UserID"])||empty($_POST["Password"])) {
    $ErrorMessage = "User name or password is invalid";
  }
else {
    $strUserID= $_POST["UserID"];
    $strPassword= $_POST["Password"];
   
    if ($strUserID !='' && $strPassword !='') {

        $strLoginName = '';
      
           try {
             $iterator = $client->getIterator('Scan', array(
                'TableName' => 'User',
                'FilterExpression' => 'UserName = :filter1 and Password = :filter2',
                 "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserID),
                                              ":filter2"=>array("S"=>$strPassword))
              ));

              foreach ($iterator as $itr) {
                $strLoginName = $itr["UserName"]['S'];
                }
            } catch (Exception $ex) {
               echo $ex->getMessage();
           }
        
                if ($strLoginName !='') {
                    header('Location:index.php?UserName='.$strLoginName);
                    exit();
                }
               else {
                $ErrorMessage = "User name or password is invalid";
               }
      
    }
    else {
      $ErrorMessage = "User name or password is invalid";
    }

  }
}
else {
  if (!empty($_GET["UserID"])){
    $strUserID= $_GET["UserID"];
    
 }
}
//#EndRegion
?>

  
<div class="login-form">
               
    <form action="/login.php" method="post">
    <div class="TextCenter header">Employee Induction Portal</div>
         <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="UserID" class="form-control" placeholder="Username" required="required">
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" name="Password" class="form-control" placeholder="Password" required="required">
            </div>
        </div>        
        <div class="form-group TextCenter">
            <button type="submit" class="btn btn-primary">Log in</button>
        </div>
<div class="form-group PaddingTop TextCenter">
<label for="Error" class="ErrorMessage"><?php echo $ErrorMessage; ?></label>
</div>
    </form>
    <p class="text-center small">Don't have an account! <a href="/registration.php">Register here</a>.</p>
</div>
</body>
</html>