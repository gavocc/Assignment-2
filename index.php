<?php
/* This is the main page for the Employee Induction Portal.
   User will be redirected to this page once login is successful.
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
    });


   $("#lnkHistory").click(function(event) {
    $('.tab-content').hide();
    document.getElementById('InductionHistory').contentWindow.location.reload();
     $("#pnlInductionHistory").removeClass('hidden');
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
   .HistoryPanel{
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
//#EndRegion
 ?>

<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <ul class="nav navbar-nav navbar-left navbar-logout">
    <li><a href=""><i class="fa fa-connectdevelop fa-2x"></i></a></li>
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
      <li><a href="#section-hr"><i class="fa fa-user-circle"></i> HR</a></li>
      <li><a href="#section-warehouse"><i class="fa fa-building"></i> Warehouse</a></li>
      <li><a href="#section-drivers"><i class="fa fa-truck"></i> Fleet Drivers</a></li>
      <li><a href="#section-IT"><i class="fa fa-laptop"></i> Information Technology</a></li>
      </ul>
   </li>
   <li><a id="lnkHistory" href="#pnlInductionHistory"><i class="fa fa-list-alt"></i> Induction History</a></li>
   <li><a href="#"><i class="fa fa-info-circle"></i> Training Statistic</a></li>
   <li><a href="/contact.php"><i class="fa fa-inbox"></i> Contact</a></li>
   </ul>
</div>

<div id="section-hr" class="tab-content">
    <h2>Human Resource Induction Modules</h2>

                  <div class="row">
                    <div class="tilediv">
                        <div id="tileIncidents" class="tile blue" title=" Drug Alcohol Policy"  onclick="showDialog('DrugAlcohol')">
                        <i class="fa fa-beer fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Drug Alcohol Policy</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalIncidents" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="tileRequests" class="tile gold" title=" Equal Employment Policy"  onclick="showDialog('EqualEmployment')">
                        <i class="fa fa-users fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Equal Employment Policy</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalServiceRequests" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="divAged" runat="server" class="tile red"  title=" Social Media Policy"  onclick="showDialog('SocialMedia')">
                        <i class="fa fa-facebook-square fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Social Media Policy</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalAged" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="tileOpen" class="tile green" title="Mobile Phone Policy"  onclick="showDialog('MobilePhone')">
                        <i class="fa fa-mobile fa-4x" ></i>
                        <div class="tile-content">
                            <span class="tile-label">Mobile Phone Policy</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalOpen" runat="server"></asp:Label>
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
                        <div id="tileIncidents" class="tile red" title=" Emergency Preparedness"  onclick="showDialog('Incidents')">
                        <i class="fa fa-ambulance fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Emergency Preparedness</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalIncidents" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="tileRequests" class="tile purple" title=" Hazard Inspections"  onclick="showDialog('Service')">
                        <i class="fa fa-exclamation-triangle fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Hazard Inspections</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalServiceRequests" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="divAged" runat="server" class="tile orange"  title=" Pedestrian Safety"  onclick="showDialog('Aged')">
                        <i class="fa fa-road fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Pedestrian Safety</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalAged" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="tileOpen" class="tile green" title="Take 3"  onclick="showDialog('Open')">
                        <i class="fa fa-cube fa-4x" ></i>
                        <div class="tile-content">
                            <span class="tile-label">Take 3</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalOpen" runat="server"></asp:Label>
                            </span>
                        </div>
                    </div>

                  </div>
                </div>
</div>
<div id="section-drivers" class="tab-content">
    <h2>Fleet Drivers Induction Modules</h2>
    <div class="row">
                    <div class="tilediv">
                        <div id="tileIncidents" class="tile green" title=" Falls Prevention"  onclick="showDialog('Incidents')">
                        <i class="fa fa-medkit fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Falls Prevention</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalIncidents" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="tileRequests" class="tile navy" title=" Loading and Unloading Exclusion Zones"  onclick="showDialog('Service')">
                        <i class="fa fa-truck fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Loading/Unloading Exclusion Zones</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalServiceRequests" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="divAged" runat="server" class="tile yellow"  title=" Safe Vehicle Parking"  onclick="showDialog('Aged')">
                        <i class="fa fa-newspaper-o fa-4x"></i>
                        <div class="tile-content">
                            <span class="tile-label">Safe Vehicle Parking</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalAged" runat="server"></asp:Label></span>
                        </div>
                    </div>
                    <div id="tileOpen" class="tile purple" title="Top of Trailer"  onclick="showDialog('Open')">
                        <i class="fa fa-archive fa-4x" ></i>
                        <div class="tile-content">
                            <span class="tile-label">Top of Trailer</span><br/>
                            <span class="tile-value"><asp:Label ID="lblTotalOpen" runat="server"></asp:Label>
                            </span>
                        </div>
                    </div>

                  </div>
                </div>
</div>
<div id="section-IT" class="tab-content">
    <h2>IT Induction Modules</h2>
    <p>Paris, France's capital, is a major European city and a global center for art, fashion, gastronomy and culture. Its picturesque 19th-century cityscape is crisscrossed by wide boulevards and the River Seine. </p>
</div>

<div id="pnlInductionHistory" class="tab-history HistoryPanel hidden" >
    <h2>Induction History</h2>
        <iframe id="InductionHistory" src="history.php" class="frame"></iframe>
</div>

<div id="pnlInductionDetails" class="ui-dialog-full" >
           <iframe id="InductionPage" src="about:blank" class="hidden"></iframe>
        </div>


    <script type="text/javascript">
      //Loads content and open dialog
      function showDialog(RequestType) {
            var request = '';
            var url = '';

            if (RequestType == 'DrugAlcohol') {
                request = 'Drug and Alcohol Policy';
                url = "/TrainingFiles/DrugAlcoholPolicy/DrugAlcohol.php";
            }
            if (RequestType == 'EqualEmployment') {
                request = 'Equal Employment Policy';
                url = "/TrainingFiles/DrugAlcoholPolicy/EqualEmployment.php";
            }
            if (RequestType == 'SocialMedia') {
                request = 'Social Media Policy';
                url = "/TrainingFiles/DrugAlcoholPolicy/SocialMedia.php";
            }

            if (RequestType == 'MobilePhone') {
                request = 'Mobile Phone Policy';
                url = "/TrainingFiles/DrugAlcoholPolicy/MobilePhone.php";
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
    </script>
</body>
</html>
