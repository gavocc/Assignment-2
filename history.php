<?php
/* This is the Induction History page that will allow users to search for their completed induction records. 
   There will be 3 search criterias - Course Name, Category and Completed Date.
*/

//#Region Import API
   ob_start();
   session_start();
   require 'aws/aws-autoloader.php';
   date_default_timezone_set('America/New_York');
   
   use Aws\DynamoDb\DynamoDbClient;

//#End Region   
?>

<html>
<head>
      <!-- [START css] -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link type="text/css" rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
        width:50px;
    }
    .TextCenter{
        Text-align:center!important;
    }
    .Message{
        color:LightBlue!important;
    }
    .Padding{
	  padding:10px!important;
    }
    
</style>
    </head>
<body>
<?php
//Set Course name and category variable
 if(isset($_POST['Search'])) {
       $strCourseName = $_POST['CourseName'];
        $strCategory = $_POST['Category'];
 }
 else {
    $strCourseName = '';
    $strCategory = '';
 }
  ?>
<form action="/history.php" method="post">
<div class="container-fluid padding">
        <div class="row">
                   
            <div class="col-md-2">
                <label>Course Name</label>
            </div>
            <div class="col-md-2">
                <label>Category</label>
            </div>
            <div class="col-md-2">
                <label>Completed Date</label>
            </div>
        </div>

        <div class="row mb-2">
           <div class="col-md-2">
                <input type="text" name="CourseName" value="<?php echo $strCourseName; ?>" class="form-control" placeholder="Course Name" >
            </div>
            <div class="col-md-2">
            <select name="Category" class="form-control" >
              <option value=""></option>
              <option value="HR" >HR</option>
              <option value="Warehouse" >Warehouse</option>
              <option value="Drivers">Fleet Drivers</option>
              </select>
                            
            </div>
            <div class="col-md-2">
                <input type="text" name="CompletedDate" class="form-control datepicker" autocomplete="off" placeholder="Completed Date:">
                
            </div>
                      
            <div class="col-md-1">
                <button name="Search" runat="server" type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</form>
    <div class='content PaddingTop'>
	<?php
    //#Region "Get Data and populate result list"
       $strUserName = $_SESSION['UserName'];
       $client = new DynamoDbClient([
        'region'  => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key'    => 'AKIAJTUYQD5U6L7MXOOQ',
            'secret' => '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'
         ]
        ]);   

        if(isset($_POST['Search'])) {
            //  $strCourseName = $_POST['CourseName'];
            //  $strCategory = $_POST['Category'];
                         
            if (isset($_POST['CourseName']) && $_POST['CourseName']!="") {
            
             $iterator = $client->getIterator('Scan', array(
                'TableName' => 'TrainingRegistration',
                'FilterExpression' => 'UserName = :filter1 and contains(CourseName,:filter2)',
                 "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName),
                                              ":filter2"=>array("S"=>$_POST['CourseName']))
            ));

            if (isset($_POST['Category']) && $_POST['Category']!="") {
                $iterator = $client->getIterator('Scan', array(
                    'TableName' => 'TrainingRegistration',
                    'FilterExpression' => 'UserName = :filter1 and contains(CourseName,:filter2) and Category= :filter3',
                     "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName),
                                                  ":filter2"=>array("S"=>$_POST['CourseName']),
                                                  ":filter3"=>array("S"=>$_POST['Category']) ) ));
            }
            
            if ($_POST['Category']!="" && $_POST['CompletedDate']!="") {
                $strCompletedDate = str_replace('/', '-',$_POST['CompletedDate']);

                $iterator = $client->getIterator('Scan', array(
                    'TableName' => 'TrainingRegistration',
                    'FilterExpression' => 'UserName = :filter1 and contains(CourseName,:filter2) and Category= :filter3 and contains(CompletedDate,:filter4)',
                     "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName),
                                                  ":filter2"=>array("S"=>$_POST['CourseName']),
                                                  ":filter3"=>array("S"=>$_POST['Category']),
                                                  ":filter4"=>array("S"=>$strCompletedDate )) ));
            }
            
            if ($_POST['Category']=="" && $_POST['CompletedDate']!="") {
               $strCompletedDate = str_replace('/', '-',$_POST['CompletedDate']);

              $iterator = $client->getIterator('Scan', array(
                  'TableName' => 'TrainingRegistration',
                  'FilterExpression' => 'UserName = :filter1 and contains(CourseName,:filter2) and contains(CompletedDate,:filter3)',
                   "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName),
                                                ":filter2"=>array("S"=>$_POST['CourseName']),
                                                ":filter3"=>array("S"=>$strCompletedDate )) ));
           }


           }
           elseif(isset($_POST['Category']) && $_POST['Category']!="") {
            $iterator = $client->getIterator('Scan', array(
                'TableName' => 'TrainingRegistration',
                'FilterExpression' => 'UserName = :filter1 and Category= :filter2',
                 "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName),
                                                      ":filter2"=>array("S"=>$_POST['Category']) ) ));
           }
           elseif(isset($_POST['CompletedDate']) && $_POST['CompletedDate']!="") {
                          
                $strCompletedDate = str_replace('/', '-',$_POST['CompletedDate']);

              $iterator = $client->getIterator('Scan', array(
                  'TableName' => 'TrainingRegistration',
                  'FilterExpression' => 'UserName = :filter1 and contains(CompletedDate,:filter2)',
                   "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName),
                                                ":filter2"=>array("S"=>$strCompletedDate)) ));
             
           }
           else {
            $iterator = $client->getIterator('Scan', array(
                'TableName' => 'TrainingRegistration',
                'FilterExpression' => 'UserName = :filter',
                 "ExpressionAttributeValues" => array(":filter"=>array("S"=>$strUserName))
                 ));

           }
         
        }
        else {
          
		  $iterator = $client->getIterator('Scan', array(
         'TableName' => 'TrainingRegistration',
         'FilterExpression' => 'UserName = :filter',
          "ExpressionAttributeValues" => array(":filter"=>array("S"=>$strUserName))
          ));
        }

		$str = "<table>".
		"<tr>" .
		"<th>User Name</th>" .
		"<th>Course Name</th>" .
		"<th>Category</th>" .
		"<th>Completed Date</th>" .
        "</tr>";
        
    foreach ($iterator as $itr) {
        $CompletionDate = date("d-m-y H:i", $itr["CompletedDate"]['S']);

        $str .= "<tr>";
        $str .= "<td>" . $itr["UserName"]['S'] . "</td>";
        $str .= "<td>" . $itr["CourseName"]['S']  . "</td>";
        $str .= "<td>" . $itr["Category"]['S']  . "</td>";
        $str .= "<td>" . $itr["CompletedDate"]['S']  . "</td>";
        $str .= "</tr>";
     
     }
		$str .= '</table></div>';

        echo $str;

   #EndRegion     
	?>
    </div>
    <script type="text/javascript">
     $(function () {
     $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy",
                onClose: function (dateText, inst) {
                    $(this).datepicker('option', 'dateFormat', 'dd/mm/yy').change();
                }
            });

     });
</script>
</body>
</html>