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
table{width: 780px;text-align: center;background-color: #99ccff;}
th{ border-left: 2px solid  #fff;border-bottom: 2px solid  #fff;background-color: #bbeeff;}
td{ border-left: 2px solid #fff;border-bottom: 2px solid #fff;}
h2{background-color: #5588ff;padding: 10px;}
#ED_column{padding: 2px;}
</style>

<body>
<!-- nav bar-->
<div class="wrapper">
	<a href="index.php"> <div class="header"></div></a>

	<!-- include navbar-->
	<div class="left">
		<?php include("includes/ADMINnavbar.php"); ?>
	</div>

	<div class="view_sessions">
		<center>
		<table>
			<tr>
				<td colspan = "8"><h2>View User Quiz results</h2></td>
				<br>
			</tr>
			<tr>
				<!-- table columns-->
				<th>User Code</th>
				<th>Session ID</th>
				<th>Score</th>
				<th>User Comment about the session</th>
			</tr>

			<?php
			//query to get quizzes, order by user_id
			$get_progress = "SELECT * FROM quiz_results LEFT JOIN users on quiz_results.user_id = users.user_id ORDER BY users.user_id";
			//run query
			$run_progress = mysqli_query($con, $get_progress);
			//iterator
			$i=1;
			//fetch result rows as array
			while ($row_progress = mysqli_fetch_array($run_progress)){
				//declare varaibles
				$user_code = $row_progress ['user_code'];
				$session_id = $row_progress ['session_id'];
				$score = $row_progress ['score'];
				$user_comment = $row_progress ['user_comment'];
			?>
			<tr>
				<!-- display results-->
				<td><?php echo $user_code; ?></td>
				<td><?php echo $session_id; ?></td>
				<td>Quiz Score : <?php echo $score; ?></td>
				<td width = "50%"><?php echo $user_comment; ?></td>
			</tr>
			<?php } ?>
		<!-- end of table-->
		</table>
		</center>
	</div>
<!-- end of html, body for else from the top -->
</body>
</html>
<?php } ?>