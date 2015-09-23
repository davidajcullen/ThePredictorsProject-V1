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
</head>

<style type="text/css">
table{ width: 780px; text-align: center; background-color: #99ccff; }
th{ border-left: 2px solid  #fff;border-bottom: 2px solid  #fff;background-color: #bbeeff;}
td{ border-left: 2px solid #fff;border-bottom: 2px solid #fff;}
h2{background-color: #5588ff;padding: 10px;}
#ED_column{padding: 2px;}
</style>

<body>
<div class="wrapper">
	<a href="index.php"> <div class="header"></div></a>
		<!-- include navbar -->
        <div class="left">
			<?php include("includes/ADMINnavbar.php"); ?>
    	</div>
    <!-- dispaly user progress-->
	<div class="view_sessions">
		<center>
		<table>
			<tr>
				<td colspan = "8"><h2>View User Progress</h2></td>
				<br>
			</tr>
			<tr>
				<!-- session columns-->
				<th>User Course</th>
				<th>User Code</th>
				<th>Session ID</th>
				<th>Exercise saved point</th>
			</tr>

			<?php
			//query to select all from user_current_session
			$get_progress = "select * from user_current_session, users where user_current_session.user_id = users.user_id ORDER BY user_current_session.session_id";
			$run_progress = mysqli_query($con, $get_progress);

			//fetch results as array
			while ($row_progress = mysqli_fetch_array($run_progress)){
				//declare variables
				$session_id = $row_progress ['session_id'];
				//plus 1 so not starting at array's 0 exercise 1= array 0
				$session_saved = $row_progress ['session_saved']+1;
				$user_code = $row_progress ['user_code'];
				$user_course = $row_progress ['course_id'];
			?>
			<tr>
				<td>
				<?php
				//dispalys db results
				//changes course 1 or 2 to course A or B
				if($user_course != '1'){
				echo "Course B"; 
				}else{
					echo "Course A";
				} ?>
				</td>
				<td><?php echo $user_code; ?></td>
				<td><?php echo $session_id; ?></td>
				<td>Exercise : <?php echo $session_saved; ?></td>
			</tr>
			<!-- end of while-->
			<?php } ?>
		</table>
		</center>
	</div>
</body>
</html>
<!-- end of else from the top-->
<?php } ?>