<?php
ob_start();
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
		width: 340px;
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
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
    .TextCenter{
        Text-align:center!important;
    }
    .ErrorMessage{
        color:Red!important;
    }
</style>
    </head>
<body>
<?php
$strUserID='';
$ErrorMessage='';
if(isset($_POST['UserID']) && isset($_POST['Password']) ) {
  if (empty($_POST["UserID"])||empty($_POST["Password"])) {
    $ErrorMessage = "User name or password is invalid";
  }
else {
    $strUserID= $_POST["UserID"];
    $strPassword= $_POST["Password"];
 
  
    if ($strUserID !='' && $strPassword !='') {
      header('Location:index.php?UserID='.$strUserID);
      exit();
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
  ?>

<div class="login-form">
<!--<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">-->
					<span class="login100-form-title-1">
						Sign In
					</span>
				</div>
    <form action="/login.php" method="post">
        <h2 class="text-center">Sign In</h2>
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
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="form-group PaddingTop TextCenter">
<label for="Error" class="ErrorMessage"><?php echo $ErrorMessage; ?></label>
</div>
    </form>
    <p class="text-center small">Don't have an account! <a href="/register.php">Register here</a>.</p>
</div>
</body>
</html>