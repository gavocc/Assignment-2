<?php
/* This is the Induction History page that will allow users to search for their completed induction records. 
   There will be 4 search criterias - UserName (for Administrator and Manager role only), Course Name, Category and Completed Date.
*/

//#Region Import API
   ob_start();
   session_start();
   require_once 'php/google-api-php-client/vendor/autoload.php';
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
 
 $strSecurityRole ='';
 $strSearchUserName = '';
 $strUserName = $_SESSION['UserName'];
 $styleUserName='';
 $awsclient = new DynamoDbClient([
  'region'  => 'us-east-1',
  'version' => 'latest',
  'credentials' => [
      'key'    => 'AKIAIOU7ZFE3Q235L6AQ',
      'secret' => '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'
   ]
  ]);   
  
  $iterator = $awsclient->getIterator('Scan', array(
      'TableName' => 'User',
      'FilterExpression' => 'UserName = :filter1',
       "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName))
                                    ));
 
      foreach ($iterator as $itr) {
         $strSecurityRole = $itr["SecurityRole"]['S'];

         if ($strSecurityRole=='Administrator'){
           $styleUserName='Display:inline';
        }
         elseif($strSecurityRole=='Manager') {
          $styleUserName='Display:inline';
        }
         else {
          $styleUserName='Display:none';
         }

      }

      if(isset($_POST['Search'])) {
     
        if (isset($_POST['UserName']) && $_POST['UserName']!="") {
            $strSearchUserName = $_POST['UserName'];
       
        }
       
    }
         
  ?>
<form action="/history.php" name="form1" method="post">
<div class="container-fluid padding">
        <div class="row">
          <div class="col-md-2" style="<?php echo $styleUserName; ?>">
                <label>User Name</label>
            </div>
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
          <div class="col-md-2" style="<?php echo $styleUserName; ?>">
                <input type="text" name="UserName" value="<?php echo $strSearchUserName; ?>" class="form-control" placeholder="User Name" >
            </div>
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
  
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Bigquery::BIGQUERY);
        $bigquery = new Google_Service_Bigquery($client);
        $projectId = 's3809839-cc2019';
        $datasetId = 'InductionTraining';
        $tableId   = 'TrainingRegistration';
        $ReadRequest = new Google_Service_Bigquery_QueryRequest();
        $ReadRequest->setUseLegacySql(false);
   
        if(isset($_POST['Search'])) {
            //  $strCourseName = $_POST['CourseName'];
            //  $strCategory = $_POST['Category'];
            if (isset($_POST['UserName']) && $_POST['UserName']!="") {
                $strUserName = $_POST['UserName'];
           
            }
            else {
                if ($strSecurityRole=='Administrator' || $strSecurityRole=='Manager'){
                    $strUserName ='';
                }
            }

            if (isset($_POST['CourseName']) && $_POST['CourseName']!="") {
                      
              if( $strUserName !='') {
               $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName)='". strtolower($strUserName) ."' AND LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%';");
              }
              else {
               $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%';");                
              }
               $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);

            if (isset($_POST['Category']) && $_POST['Category']!="") {
               
                if( $strUserName !='') {
                  $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName)='". strtolower($strUserName) ."' AND LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%' AND Category='". $_POST['Category'] ."';");
                }
                else {
                  $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%' AND Category='". $_POST['Category'] ."';");
                    
                }
                $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
              
            }
            
            if ($_POST['Category']!="" && $_POST['CompletedDate']!="") {
                $strCompletedDate = date("Y-d-m", strtotime($_POST['CompletedDate']));

                if( $strUserName !='') {
                $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName)='". strtolower($strUserName) ."' AND LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%' AND Category='". $_POST['Category'] ."' AND FORMAT_DATE('%d-%m-%Y', Date(CompletedDate))='". $strCompletedDate ."';");
                }
                else {
                $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%' AND Category='". $_POST['Category'] ."' AND FORMAT_DATE('%d-%m-%Y', Date(CompletedDate))='". $strCompletedDate ."';");              
                }
                $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
           
            }
            
            if ($_POST['Category']=="" && $_POST['CompletedDate']!="") {
                $strCompletedDate = date("Y-d-m", strtotime($_POST['CompletedDate']));

                if( $strUserName !='') {
                 $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName)='". strtolower($strUserName) ."' AND LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%' AND FORMAT_DATE('%d-%m-%Y', Date(CompletedDate))='". $strCompletedDate ."';");
                }
                else {
                   $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(CourseName) LIKE '%". strtolower($_POST['CourseName']) ."%' AND FORMAT_DATE('%d-%m-%Y', Date(CompletedDate))='". $strCompletedDate ."';");                    
                }
               $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
           
           }


           }
           elseif(isset($_POST['Category']) && $_POST['Category']!="") {
            if( $strUserName !='') {
              $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName)='". strtolower($strUserName) ."' AND Category='". $_POST['Category'] ."';");
            }
            else {
              $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE Category='". $_POST['Category'] ."';");
                
            }
              $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
         
           }
           elseif(isset($_POST['CompletedDate']) && $_POST['CompletedDate']!="") {
                     
          
            $strCompletedDate = str_replace('/','-',$_POST['CompletedDate']);
          
           if( $strUserName !='') {      
                $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName)='". strtolower($strUserName) ."' AND FORMAT_DATE('%d-%m-%Y', Date(CompletedDate))='". $strCompletedDate ."';");
           }
           else {
            $ReadRequest->setQuery("SELECT UserName, CourseName, Category, FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE FORMAT_DATE('%d-%m-%Y', Date(CompletedDate))='". $strCompletedDate ."';");
               
           }
                $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
                      
           }
           else {
            if( $strUserName !='') {   
            $ReadRequest->setQuery("SELECT UserName, CourseName, Category,FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration WHERE LOWER(UserName) LIKE '%". strtolower($strUserName) ."%';");
            }
            else {
            $ReadRequest->setQuery("SELECT UserName, CourseName, Category,FORMAT_DATE('%d-%m-%Y', Date(CompletedDate)) FROM InductionTraining.TrainingRegistration;");
                
            }
            $ReadResponse = $bigquery->jobs->query($projectId, $ReadRequest);
           
           }
         
        }
      
        $ReadRows = $ReadResponse->getRows();

       
		$str = "<table class='table table-striped table-bordered' id='tblResult'>".
        "<thead>" .
        "<tr>" .
        "<th></th>" .
		"<th>User Name</th>" .
		"<th>Course Name</th>" .
		"<th>Category</th>" .
		"<th>Completed Date</th>" .
        "</tr></thead>";
        
        foreach ($ReadRows as $ReadRow)
        {
          
                $UserName = "'". $ReadRow->f[0]->v ."'";
                $CourseName ="'". $ReadRow->f[1]->v ."'";
                $CompletedDate="'". $ReadRow->f[3]->v ."'";
             
                   $str .= '<tr>';
                   $str .= '<td><a href="#" onclick="window.parent.PrintCertificate('. $UserName .','.$CourseName.','.$CompletedDate.');">Print</a></td>';
                    $str .= '<td>' . $ReadRow->f[0]->v .'</td>';
                    $str .= '<td>' . $ReadRow->f[1]->v .'</td>';
                    $str .= '<td>' . $ReadRow->f[2]->v .'</td>';
                    $str .= '<td>' . $ReadRow->f[3]->v .'</td>';
                    $str .= '</tr>';
                    
        }
    
		$str .= '</table></div>';

        echo $str;

   #EndRegion     
	?>

    <div id="pnlPrintCertificate" class="ui-dialog-full" >
           <iframe id="PrintCertificatePage" src="about:blank" class="hidden"></iframe>
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

function PrintCertificate(strUserName,strCourseName,strCompletedDate){
    $(function () {
      var url = "printcertificate.php?strUserName="+strUserName+"&strCourseName='"+strCourseName+"'&strCompletedDate="+strCompletedDate;
      $("#pnlPrintCertificate").dialog({
                autoOpen: false,
                width: 1000,
                title: 'Print Certificate',
                show:"fade",
                hide:"fade",
                height: 580,
                modal: true,
                open: function () {
                                                    
                    $('#PrintCertificatePage').attr('src',url);
                    $("#PrintCertificatePage").removeClass("hidden");
                },
                close: function () {
                    $("#PrintCertificatePage").attr('src', 'about:blank');
                    $("#PrintCertificatePage").addClass("hidden");
                }
            });

        
             $("#pnlPrintCertificate").dialog("open");

            return false;
    });
}
</script>
</body>
</html>