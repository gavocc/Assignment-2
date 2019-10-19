<?php
/* This is the main page for the Employee Induction Portal. 
   User will be redirected to this page once login is successful.
*/

//#Region Import API
ob_start();
session_start();
require_once 'php/google-api-php-client/vendor/autoload.php';
require 'aws/aws-autoloader.php';
use Aws\DynamoDb\DynamoDbClient;
//#End Region
?>

<html>
<head>
<!-- [START css] -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link type="text/css" rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://use.fontawesome.com/932e416e69.js"></script>
    <!-- [END css] -->

<script type="text/Javascript">

 $(document).ready(function () {
    $('.nav ul li:first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.nav ul li a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
        $("#pnlInductionHistory").addClass('hidden');
        $("#pnlProfile").addClass('hidden');
        $("#pnlUserAdministration").addClass('hidden');
        $("#pnlStatistic").addClass('hidden');
        $("#pnlContact").addClass('hidden');
    });


   $("#lnkHistory").click(function(event) {
    $('.tab-content').hide();
    $("#pnlStatistic").addClass('hidden');
    $("#pnlProfile").addClass('hidden');
    document.getElementById('InductionHistory').contentWindow.location.reload();
     $("#pnlInductionHistory").removeClass('hidden');
     $("#pnlUserAdministration").addClass('hidden');
     $("#pnlContact").addClass('hidden');
   });

    $("#lnkStatistic").click(function(event) {
    $('.tab-content').hide();
    $("#pnlInductionHistory").addClass('hidden');
    $("#pnlProfile").addClass('hidden');
    document.getElementById('InductionStatistic').contentWindow.location.reload();
     $("#pnlStatistic").removeClass('hidden');
     $("#pnlUserAdministration").addClass('hidden');
     $("#pnlContact").addClass('hidden');
   });

    $("#lnkAdministration").click(function(event) {
    $('.tab-content').hide();
    $("#pnlInductionHistory").addClass('hidden');
    $("#pnlStatistic").addClass('hidden');
    $("#pnlProfile").addClass('hidden');
    document.getElementById('UserAdministration').contentWindow.location.reload();
     $("#pnlUserAdministration").removeClass('hidden');
     $("#pnlContact").addClass('hidden');
   });

 $("#lnkProfile").click(function(event) {
    $('.tab-content').hide();
    $("#pnlInductionHistory").addClass('hidden');
    $("#pnlStatistic").addClass('hidden');
    document.getElementById('MyProfile').contentWindow.location.reload();
     $("#pnlProfile").removeClass('hidden');
     $("#pnlUserAdministration").addClass('hidden');
     $("#pnlContact").addClass('hidden');
   });

$("#lnkContact").click(function(event) {
    $('.tab-content').hide();
    $("#pnlInductionHistory").addClass('hidden');
    $("#pnlStatistic").addClass('hidden');
    document.getElementById('Contact').contentWindow.location.reload();
     $("#pnlContact").removeClass('hidden');
     $("#pnlUserAdministration").addClass('hidden');
     $("#pnlProfile").addClass('hidden');
   });
});
</script>

<style type="text/css">
 .content {
    background-color:#F4F4F4!important;
}
.frame{
	border-width: 0px!important;
    width:100%!important;
    height:70%!important;
   }
   .PopupPanel{
        margin-top:-13px!important;
    }

    H2{
     color:#3C3C3C!important;   
    }
      </style>
    </head>
<body >

<?php
//#Region Variable Declaration
   $strUserName = $_GET["UserName"];
  $_SESSION['UserName'] = $strUserName;

  $client = new DynamoDbClient([
    'region'  => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
        'key'    => 'AKIAIOU7ZFE3Q235L6AQ',
        'secret' => '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'
     ]
    ]);   

    $styleStatistic='';
    $styleAdmin='';

        $iterator = $client->getIterator('Scan', array(
        'TableName' => 'User',
        'FilterExpression' => 'UserName = :filter1',
         "ExpressionAttributeValues" => array(":filter1"=>array("S"=>$strUserName))
                                      ));
   
        foreach ($iterator as $itr) {
           $strSecurityRole = $itr["SecurityRole"]['S'];

           if ($strSecurityRole=='Administrator'){
             $styleStatistic='Display:inline';
             $styleAdmin='Display:inline';
           }
           elseif($strSecurityRole=='Manager') {
            $styleStatistic='Display:inline';
            $styleAdmin='Display:none';
           }
           else {
            $styleStatistic='Display:none';
            $styleAdmin='Display:none';
           }

        }

//#EndRegion
 ?>

<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <ul class="nav navbar-nav navbar-left navbar-logout">
    <li><a href=""><i class="fa fa-connectdevelop fa-3x"></i></a></li>
    </ul>
    <div class="TextCenter">
    <a class="navbar-brand" href="#">Employee Induction Portal</a>
    </div>
    <ul class="nav navbar-nav navbar-right navbar-logout">
    <li><span><i class="fa fa-user"></i> <?php echo $strUserName; ?></span><a href="/login.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </div>
</nav>

 <div class="navbar navbar-inverse navbar-fixed-left">
  <a class="navbar-brand" href="#"></a>
  <ul class="nav navbar-nav">
   <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-id-card"></i> Induction Category<span class="caret"></span></a>
     <ul class="dropdown-menu" role="menu">
     <li><a href="#section-drivers"><i class="fa fa-truck"></i> Fleet Drivers</a></li>
      <li><a href="#section-hr"><i class="fa fa-user-circle"></i> HR</a></li>
      <li><a href="#section-warehouse"><i class="fa fa-building"></i> Warehouse</a></li>
           
      </ul>
   </li>
   <li><a id="lnkHistory" href="#pnlInductionHistory"><i class="fa fa-list-alt"></i> Induction History</a></li>
   <li style="<?php echo $styleStatistic; ?>"><a id="lnkStatistic" href="#pnlStatistic"><i class="fa fa-info-circle"></i> Training Statistic</a></li>
   <li style="<?php echo $styleAdmin; ?>"><a id="lnkAdministration" href="#pnlAdministration"><i class="fa fa-info-circle"></i> User Administration</a></li>
   <li><a id="lnkProfile" href="#pnlProfile"><i class="fa fa-list-alt"></i> My Profile</a></li>
   <li><a id="lnkContact" href="#pnlContact"><i class="fa fa-inbox"></i> Contact</a></li>
   </ul>
</div>
<div id="section-drivers" class="tab-content">
    <h2>Fleet Drivers Induction Modules</h2>
    <div class="row">
                    <div class="tilediv">
                        <div id="tileIncidents" class="tile red" title=" Falls Prevention"  onclick="showDialog('FallsPrevention')">
                        <i class="fa fa-medkit fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Falls Prevention</span><br/>
                        </div>
                    </div>
                    <div id="tileRequests" class="tile navy" title=" Loading and Unloading Exclusion Zones"  onclick="showDialog('ExclusionZones')">
                        <i class="fa fa-truck fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Loading/Unloading Exclusion Zones</span><br/>
                          </div>
                    </div>
                    <div id="divAged" runat="server" class="tile yellow"  title=" Safe Vehicle Parking"  onclick="showDialog('SafeVehicleParking')">
                        <i class="fa fa-newspaper-o fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Safe Vehicle Parking</span><br/>
                            </div>
                    </div>
                    <div id="tileOpen" class="tile purple" title="Top of Trailer"  onclick="showDialog('TopOfTrailer')">
                        <i class="fa fa-archive fa-4x" ></i> 
                        <div class="tile-content">
                            <span class="tile-label">Top of Trailer</span><br/>
                            </span>
                        </div>
                    </div>
                   
                  </div>
                </div>
</div>
<div id="section-hr" class="tab-content">
    <h2>Human Resource Induction Modules</h2>
  
                  <div class="row">
                    <div class="tilediv">
                        <div id="tileIncidents" class="tile blue" title=" Drug Alcohol Policy"  onclick="showDialog('DrugAlcohol')">
                        <i class="fa fa-beer fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Drug Alcohol Policy</span><br/>
                            </div>
                    </div>
                    <div id="tileRequests" class="tile gold" title=" Equal Employment Policy"  onclick="showDialog('EqualEmployment')">
                        <i class="fa fa-users fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Equal Employment Policy</span><br/>
                           
                        </div>
                    </div>
                    <div id="divAged" runat="server" class="tile red"  title=" Social Media Policy"  onclick="showDialog('SocialMedia')">
                        <i class="fa fa-facebook-square fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Social Media Policy</span><br/>
                           
                        </div>
                    </div>
                    <div id="tileOpen" class="tile green" title="Mobile Phone Policy"  onclick="showDialog('MobilePhone')">
                        <i class="fa fa-mobile fa-4x" ></i> 
                        <div class="tile-content">
                            <span class="tile-label">Mobile Phone Policy</span><br/>
                            
                            </span>
                        </div>
                    </div>
                   
                  </div>
                </div>

</div>
<div id="section-warehouse" class="tab-content">
    <h2>Warehouse Induction Modules</h2>
    <div class="row">
                    <div class="tilediv">
                        <div id="tileEmergency" class="tile red" title=" Emergency Preparedness"  onclick="showDialog('EMER')">
                        <i class="fa fa-ambulance fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Emergency Preparedness</span><br/>
                           
                        </div>
                    </div>
                    <div id="tileHazard" class="tile purple" title=" Hazard Inspections"  onclick="showDialog('Hazard')">
                        <i class="fa fa-exclamation-triangle fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Hazard Inspections</span><br/>
                           
                        </div>
                    </div>
                    <div id="tilePS" runat="server" class="tile orange"  title=" Pedestrian Safety"  onclick="showDialog('PS')">
                        <i class="fa fa-road fa-4x"></i> 
                        <div class="tile-content">
                            <span class="tile-label">Pedestrian Safety</span><br/>
                          
                        </div>
                    </div>
                    <div id="tileTake3" class="tile green" title="Take 3"  onclick="showDialog('Take3')">
                        <i class="fa fa-cube fa-4x" ></i> 
                        <div class="tile-content">
                            <span class="tile-label">Take 3</span><br/>
                           
                            </span>
                        </div>
                    </div>
                   
                  </div>
                </div>
</div>


<div id="pnlInductionHistory" class="tab-history PopupPanel hidden" >
    <h2>Induction History</h2>
        <iframe id="InductionHistory" src="history.php" class="frame"></iframe>
</div>
<div id="pnlStatistic" class="tab-history PopupPanel hidden" >
    <h2>Training Statistic</h2>
        <iframe id="InductionStatistic" src="statistic.php" class="frame"></iframe>
</div>
<div id="pnlInductionDetails" class="ui-dialog-full" >
           <iframe id="InductionPage" src="about:blank" class="hidden"></iframe>
</div>
<div id="pnlUserAdministration" class="tab-history PopupPanel hidden" >
    <h2>User Administration</h2>
        <iframe id="UserAdministration" src="userlist.php" class="frame"></iframe>
</div>
<div id="pnlProfile" class="tab-history PopupPanel hidden" >
    <h2>My Profile</h2>
        <iframe id="MyProfile" src="profile.php?strUserName=<?php echo $strUserName; ?>" class="frame"></iframe> 
             
</div>
<div id="pnlContact" class="tab-history PopupPanel hidden">
           <iframe id="Contact" src="contact.php" class="frame"></iframe>
        </div>
    </div>
<div id="pnlEditUser" class="ui-dialog-full" >
           <iframe id="EditUser" src="about:blank" class="hidden"></iframe>
        </div>
    </div>
<div id="pnlPrintCertificate" class="ui-dialog-full" >
           <iframe id="PrintCertificatePage" src="about:blank" class="hidden"></iframe>
        </div>
</div>
    <script type="text/javascript">
      //Loads content and open dialog
      function showDialog(RequestType) {
            var request = '';
            var url = '';

            if (RequestType == 'DrugAlcohol') {
                request = 'Drug and Alcohol Policy';
                url = "/TrainingFiles/HR/DrugAlcohol.php";
            }
            if (RequestType == 'EqualEmployment') {
                request = 'Equal Employment Policy';
                url = "/TrainingFiles/HR/EqualEmployment.php";
            }
            if (RequestType == 'SocialMedia') {
                request = 'Social Media Policy';
                url = "/TrainingFiles/HR/SocialMedia.php";
            }

            if (RequestType == 'MobilePhone') {
                request = 'Mobile Phone Policy';
                url = "/TrainingFiles/HR/MobilePhone.php";
            }

            if (RequestType == 'FallsPrevention') {
                request = 'Falls Prevention';
                url = "/TrainingFiles/FleetDrivers/FallsPrevention.php";
            }
            if (RequestType == 'ExclusionZones') {
                request = 'Loading/Unloading Exclusion Zones';
                url = "/TrainingFiles/FleetDrivers/ExclusionZones.php";
            }
            if (RequestType == 'SafeVehicleParking') {
                request = 'Safe Vehicle Parking';
                url = "/TrainingFiles/FleetDrivers/SafeVehicleParking.php";
            }
            if (RequestType == 'TopOfTrailer') {
                request = 'Top of Trailer';
                url = "/TrainingFiles/FleetDrivers/TopOfTrailer.php";
            }
            if (RequestType == 'EMER') {
                request = 'Emergency Preparedness';
                url = "/TrainingFiles/Warehouse/EmergencyPreparedness.php";
            }
            if (RequestType == 'Take3') {
                request = 'Take 3';
                url = "/TrainingFiles/Warehouse/Take3.php";
            }
            if (RequestType == 'PS') {
                request = 'Pedestrian Safety';
                url = "/TrainingFiles/Warehouse/PedestrianSafety.php";
            }
            if (RequestType == 'Hazard') {
                request = 'Hazard Inspection';
                url = "/TrainingFiles/Warehouse/HazardInspection.php";
            }
           if (request == '') {
                request = RequestType;
            }
                               
            $("#pnlInductionDetails").dialog({  //create dialog, but keep it closed
                autoOpen: false,
                width: 1000,
                title: request,
                show:"fade",
                hide:"fade",
                height: 580,
                modal: true,
                open: function () {
                                
                    $('#InductionPage').attr('src',url);
                    $("#InductionPage").removeClass("hidden");
                },
                close: function () {
                    $("#InductionPage").attr('src', 'about:blank');
                    $("#InductionPage").addClass("hidden");
                }
            });

            var complete = function () {
                $(".issuedetails-spinner").removeClass("hidden");
                $("#InductionPage").attr('src', url);
            };

             $("#pnlInductionDetails").dialog("open");

            return false;
        }

    function EditUser(strUserName){
    $(function () {
    //    alert(strUserName);
      var url = "edituser.php?strUserName="+strUserName;
   //   alert($("#pnlInductionDetails"));

     $("#pnlEditUser").dialog({  //create dialog, but keep it closed
                autoOpen: false,
                width: 1000,
                title: 'Edit User',
                show:"fade",
                hide:"fade",
                height: 580,
                modal: true,
                open: function () {
                                                    
                    $('#EditUser').attr('src',url);
                    $("#EditUser").removeClass("hidden");
                },
                close: function () {
                    $("#EditUser").attr('src', 'about:blank');
                    $("#EditUser").addClass("hidden");
                }
            });

        
             $("#pnlEditUser").dialog("open");

            return false;
    });
}

function PrintCertificate(strUserName,strCourseName,strCompletedDate){
    $(function () {
      var url = "printcertificate.php?strUserName="+strUserName+"&strCourseName='"+strCourseName+"'&strCompletedDate="+strCompletedDate;
   //   alert($("#pnlInductionDetails"));

     $("#pnlPrintCertificate").dialog({  //create dialog, but keep it closed
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