<?php
/* This is the user listing page that will allow administrator to search for their user records. 
   There will be 4 search criterias - UserName,  FirstName, LastName and Email.
*/

//#Region Import API
   ob_start();
   session_start();
   require 'aws/aws-autoloader.php';
   require_once 'fpdf181/fpdf.php';
   use Aws\DynamoDb\DynamoDbClient;

   date_default_timezone_set('Australia/Melbourne');
//#End Region   
?>

<html>
<head>
      <!-- [START css] -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" /> 
<link type="text/css" rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
        width:330px!important;
    }
   
    .Padding{
	  padding:10px!important;
    }
    th{
	 background-color: #EFEFEF!important;
    } 
  
    .table.dataTable tbody td { font-size: 13px!important }
    .table.dataTable thead th, table.dataTable thead td { font-size: 13px!important }
</style>
    </head>
<body>
<form action="/userlist.php" name="form1" method="post">
<div class="container-fluid padding">
        <div class="row">
                   
            <div class="col-md-2">
                <label>User Name</label>
            </div>
            <div class="col-md-2">
                <label>First Name</label>
            </div>
            <div class="col-md-2">
                <label>Last Name</label>
            </div>
            <div class="col-md-2">
                <label>Email</label>
            </div>
        </div>

        <div class="row mb-2">
           <div class="col-md-2">
                <input type="text" name="UserName" class="form-control" placeholder="User Name" >
            </div>
            <div class="col-md-2">
                <input type="text" name="FirstName" class="form-control" placeholder="First Name" >
            </div>
            <div class="col-md-2">
                <input type="text" name="LastName" class="form-control" placeholder="Last Name" >
            </div>
          
            <div class="col-md-2">
                <input type="text" name="Email" class="form-control" placeholder="Email">
                
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
      $client = new DynamoDbClient([
        'region'  => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key'    => 'AKIAIOU7ZFE3Q235L6AQ',
            'secret' => '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'
         ]
        ]);   
       
    $strLoginName = '';
  
       $TotalCount = 0;
                
        if(isset($_POST['Search'])) {
            if (isset($_POST['UserName']) && $_POST['UserName']!="") {
            
                $iterator = $client->getIterator('Scan', array(
                'TableName' => 'User',
                'FilterExpression' => 'contains(UserName,:filter1)',
                 "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['UserName']))
               ));
              
            }
            else {
            if (isset($_POST['FirstName']) && $_POST['FirstName']!="") {
                 $iterator = $client->getIterator('Scan', array(
                    'TableName' => 'User',
                    'FilterExpression' => 'contains(FirstName,:filter1)',
                     "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['FirstName']))
                                                  ));
          
                 if (isset($_POST['LastName']) && $_POST['LastName']!="") {
                      $iterator = $client->getIterator('Scan', array(
                    'TableName' => 'User',
                    'FilterExpression' => 'FirstName = :filter1 and LastName= :filter2',
                     "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['FirstName']),
                                                  ":filter2"=>array("S"=>$_POST['LastName']) ) ));
                 
                 }
                 
                 if (isset($_POST['Email']) && $_POST['Email']!="") {
                   
                    $iterator = $client->getIterator('Scan', array(
                        'TableName' => 'User',
                        'FilterExpression' => 'FirstName = :filter1 and LastName= :filter2 and Email= :filter3',
                         "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['FirstName']),
                                                      ":filter2"=>array("S"=>$_POST['LastName']),
                                                      ":filter3"=>array("S"=>$_POST['Email']) ) ));
               
                 }
                }
                elseif(isset($_POST['LastName']) && $_POST['LastName']!="") {
                    $iterator = $client->getIterator('Scan', array(
                        'TableName' => 'User',
                        'FilterExpression' => 'LastName= :filter1',
                         "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$_POST['LastName']) ) ));
           
                }
                else {
                    try {
                   $iterator = $client->getIterator('Scan', array(
                       'TableName' => 'User'
                      ));
                      }
               catch(Exception $e) {
                   echo 'error Message: ' .$e->getMessage();
               }

                }
                                
          }
        }
          
		$str = "<table class='table table-striped table-bordered' id='tblResult'>".
        "<thead>" .
        "<tr>" .
        "<th>Select</th>" .
		"<th>User Name</th>" .
		"<th>First Name</th>" .
		"<th>Last Name</th>" .
        "<th>Email</th>" .
        "<th>Security Role</th>" .
        "<th>Created Date</th>" .
        "</tr></thead>";
        
         foreach ($iterator as $itr) {
           $strUserName = "'". $itr["UserName"]['S'] . "'";
           $strLoginName = $itr["UserName"]['S'];
           $strFirstName = $itr["FirstName"]['S'];
           $strLastName = $itr["LastName"]['S'];
           $strEmail = $itr["Email"]['S'];
           $strSecurityRole = $itr["SecurityRole"]['S'];
           $CreatedDateTime = $itr["CreatedDateTime"]['S'];

                 $str .= '<tr>';
                $str .= '<td><a href="#" onclick="window.parent.EditUser('. $strUserName .');">Edit</a></td>';
                $str .= '<td>' . $strLoginName .'</td>';
                $str .= '<td>' . $strFirstName . '</td>';
                $str .= '<td>' . $strLastName . '</td>';
                $str .= '<td>' . $strEmail .'</td>';
                $str .= '<td>' . $strSecurityRole .'</td>';
                $str .= '<td>' . $CreatedDateTime .'</td>';
                $str .= '</tr>';
         }


        $str .= '</table></div>';

        echo $str;
    #EndRegion     
	?>

    <div id="pnlEditUser" class="ui-dialog-full" >
           <iframe id="EditUser" src="about:blank" class="hidden"></iframe>
        </div>
    </div>
   
    <script type="text/javascript">
     $(function () {
     $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy",
                onClose: function (dateText, inst) {
                    $(this).datepicker('option', 'dateFormat', 'dd/mm/yy').change();
                }
            });

     
   $('#tblResult').DataTable({
        responsive: true,
       "bFilter": false,
        "bInfo": false
    });

});

</script>
</body>
</html>