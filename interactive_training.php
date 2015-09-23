<?php 
//include session start and database
session_start(); 
include("includes/database.php");

$currentUser=$_SESSION[ "currentUser"];
//inactivity timer
if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
    //redirect to login.php
    header('Location: login.php');
} else{
 	//the last last activity.
    $_SESSION['last_activity'] = time();
  }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Interactive Training | Predictors Project</title>
<link rel="stylesheet" href="styles/style.css" media="all" />
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
<style type="text/css">
	#course_session_title{color: #003b6f; text-align: center; margin-top: 10px;}
	.session_area { background-color: #fff; width: 1000px; float:left;text-decoration:none;font-size:16px;font-family:"Arial", cursive;}
	.session_area img {padding-top:10px; padding-left:10px; padding-right:10px; float:right;}
	.session_area p {margin-bottom:10px; text-align:center;}
	.session_area h2 {padding-bottom:10px;}
	.footer_area{vertical-align:middle; font-family: arial;text-align: center; width:1000px; height:50px; background:#52afe2; color:#FFF; clear:both;padding-top: 15px;}
	#user_name{ margin: -20px; margin-right: 150px; font-size: 20px; font-family: arial; color: #fff; float: right;}
</style>
</head>

<body>
<!-- Main Container start-->
<div class="container">
	<!-- Head start-->
	<div class = "head">
			<img id ="logo" src ='images/logo.png' />
			<img id = "banner" src ='images/banner_IT.png' />
		<!--<div><?php //include("login.php"); ?></div>-->
		<form id="form1" name ="form 1" method = "post" action = "logoff.php">

			<input type="submit" name="logoffBtn" id = "logoffBtn" value ="Log Off" />
		</form>
		
	</div>
	<div>
		<text id='user_name'>Welcome, <?php  echo "$currentUser"  ?> </br></text>
	</div>
	
	<!-- Nav start-->
	<div class = "navbar">
		<?php include("includes/ITnavbar.php"); ?>
	</div>
	<!-- Nav end-->

	<!-- Post area start-->
	<div class="session_area">
		<h2 id='course_session_title'>Course Sessions:</h2>
		<?php
		//if login status is set then show course sessions
		if (isset($_SESSION['login_status'])) {
			include("includes/course_sessions.php");
		 } else { ?>
		 <!-- unresgitered user display message -->
		<h2 id = 'public_message'>Need user code and password for interactive training, please login here:</h2>
		<br>
		<div  class='login_btn'>
			<div style="text-align:center;">
				<!-- go to login page-->
				<a id= 'login_btn' href="login.php"> Login </a>
			</div>
		</div>
		<!-- end of else-->		
		<?php } ?>
	<!--end of session area-->
    </div>
<!-- end of conatiner div--> 	
</div>
   <!--Footer starts-->
	<center>
	<div class="footer_area">
		<h3>&copy; All Rights Reserved 2015 - PredictorsProject</h3>
	</div><!--Footer ends-->
	</center>
</body>
</html>