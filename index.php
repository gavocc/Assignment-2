<html>
<head>
      <!-- [START css] -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/932e416e69.js"></script>
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
    <!-- [END css] -->

<script>
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
    });
});
</script>

     <style type="text/css">
     .navbar-fixed-left {
  width: 182px;
  position: fixed;
  border-radius: 0;
  height: 100%;
  background-color:#17252A!important;
}

.navbar-fixed-left .navbar-nav > li {
  float: none;  /* Cancel default li float: left */
  width: 180px;
}

.navbar-default .navbar-nav>li>a { 
  color:#DEF2F1!important;
}

.navbar-fixed-left .navbar-nav > li > a {
  color:#DEF2F1!important;
}

.navbar-fixed-left + .container {
  padding-left: 180px;
}
.tab-content {
  padding-left: 180px;
  text-align:center;
  padding:10px;
}
/* On using dropdown menu (To right shift popuped) */
.navbar-fixed-left .navbar-nav > li > .dropdown-menu {
  margin-top: -50px;
  margin-left: 182px;
  background-color:#17252A;
}

.navbar-fixed-left .navbar-nav > li > .dropdown-menu > li > a {
    color:#fff;
}
.navbar-fixed-left .navbar-nav > li > .dropdown-menu > li > a:hover {
    color:#000;
}
.navbar {
    margin-bottom:3px!important;
}
.navbar-logout {
  margin-top:-15px!important;
  color:#DEF2F1!important;
}
.navbar-header {
    float: left;
    padding: 15px;
    text-align: center;
    background-color:#17252A!important; 
    width: 100%;
  }
 .active {
    font-weight:bold;
}
.navbar-brand {float:none;color:#DEF2F1!important;font-size: 25px !important;}
      </style>
    </head>
<body >
<?php
  $UserID = $_GET["UserID"];
 ?>
<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <ul class="nav navbar-nav navbar-left navbar-logout">
    <li><a href=""><i class="fa fa-connectdevelop fa-2x"></i></a></li></ul>
    <a class="navbar-brand" href="#">Employee Induction Portal</a>
    <ul class="nav navbar-nav navbar-right navbar-logout">
    <li><a href=""><i class="fa fa-sign-out"></i> Logout</a></li>
    <!--<span class="glyphicon glyphicon-log-out"></span> -->
                   <!--  <li class="dropdown">
                         <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Gavin<b class="caret"></b></a>
                         <div class="dropdown-menu">
                             <a href='' Class="dropdown-item">
                                 <i class="fa fa-user"></i> Profile
                             </a>
                             <a href='' Class="dropdown-item">
                                 <i class="fa fa-sign-out"></i> Logout
                             </a>
                         </div>
                     </li> -->
                 </ul>
  </div>
</nav>
<!--<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Employee Induction Website</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="services.html">Services</a></li>
      </ul>
    </div>
  </div>
</nav> -->

  <!--<nav class="navbar navbar-dark bg-dark navbar-expand-md">
                   <div id="myMenuBar" class="d-none d-md-block">
                    <ul class="navbar-nav ml-auto">
                     
                        <li class="dropdown text-center">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Gavin<b class="caret"></b></a>
                            <div class="dropdown-menu">
                                <a href='#' Class="dropdown-item">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                                <a href='#' Class="dropdown-item">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
   
    </nav> -->
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
   <li><a href="#"><i class="fa fa-list-alt"></i> Induction History</a></li>
   <li><a href="#"><i class="fa fa-info-circle"></i> Company Information</a></li>
   <li><a href="#"><i class="fa fa-inbox"></i> Enquiry</a></li>
   </ul>
</div>
<div id="section-hr" class="tab-content">
    <h2>Human Resource Induction Modules</h2>
    <p>London is the capital city of England. It is the most populous city in the United Kingdom, with a metropolitan area of over 13 million inhabitants.</p>
</div>
<div id="section-warehouse" class="tab-content">
    <h2>Warehouse Induction Modules</h2>
    <p>Paris, France's capital, is a major European city and a global center for art, fashion, gastronomy and culture. Its picturesque 19th-century cityscape is crisscrossed by wide boulevards and the River Seine. </p>
</div>
<div id="section-drivers" class="tab-content">
    <h2>Fleet Drivers Induction Modules</h2>
    <p>Paris, France's capital, is a major European city and a global center for art, fashion, gastronomy and culture. Its picturesque 19th-century cityscape is crisscrossed by wide boulevards and the River Seine. </p>
</div>
<div id="section-IT" class="tab-content">
    <h2>IT Induction Modules</h2>
    <p>Paris, France's capital, is a major European city and a global center for art, fashion, gastronomy and culture. Its picturesque 19th-century cityscape is crisscrossed by wide boulevards and the River Seine. </p>
</div>

<div class="container" style="display:none">
 <div class="row">
   <h2>Employee Induction Home Page</h2>
   
   <p>This portal will allow employees to do their induction training as required.</p>
 </div>
</div> 
</body>
</html>