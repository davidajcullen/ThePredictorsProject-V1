<!--database inclusion-->
<?php 
include("includes/database.php");
session_start();
//checks if user authorised, if not bring them to the login page.
if(!isset($_SESSION['admin_username'])){
	echo "<script>window.open('login.php?not_authorize=You are not authorized to access!','_self')</script>";
	} else { ?>
<!--Declare HTML-->
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Predictors Project | Admin</title>
<link rel="stylesheet" href="styles/style.css" />
<link rel="shortcut icon" type="image/ico" href="../images/faviconn.ico" />
<style type="text/css">
#content{margin-top: 50px;}
</style>
</head>

<body>
<div class="wrapper">
	<a href="index.php"> <div class="header"></div></a>
	<div class="left">
		<?php include("includes/ADMINnavbar.php"); ?>
	</div>

	<div class="admin_home">
	<div id='admin_content'>
		<center>
		<h2 style="color:#C33;"><?php echo @$_GET['logged']; ?></h2>
		<br>
			<span style="font-size:18px;">Welcome:</span><h2 style="color:#03C;"><?php echo $_SESSION['admin_username']; ?></h2>
		</br>
	</div>

	<center>
	<div id = 'content'>
		<?php
		//global get edit session if set and include editsession.php otherwise hide 
		if(isset($_GET['edit_session'])){
			include("includes/edit_session.php");
			?>
			<script type="text/javascript">document.getElementById('admin_content').style.display = 'none';
			</script>
		<?php }

		//get edit user form url if set and include editsession.php otherwise hide
		if(isset($_GET['edit_user'])){
			include("includes/edit_user.php");
			?>
			<script type="text/javascript">document.getElementById('admin_content').style.display = 'none';
			</script>
		<?php } 

		//get edit exercise if set and include editsession.php otherwise hide
		if(isset($_GET['edit_exercise'])){
			include("includes/edit_exercise.php");
			?>
			<script type="text/javascript">document.getElementById('admin_content').style.display = 'none';
			</script>
		<?php } ?>
	</div>
	</center>

<!-- end of php, body and html-->
</body>
</html>
<?php } ?> 