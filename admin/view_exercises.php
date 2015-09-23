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
.left{height: 1500px;}
.view_exercises {font-family: "Arial";margin: 2px;font-size: 18px;color: #000;background-color: #fff;float: right;width: 795px; height: 1500px;}
table{ width: 780px; text-align: center; background-color: #99ccff; }
th{ border-left: 2px solid  #fff;border-bottom: 2px solid  #fff;background-color: #bbeeff;}
td{ border-left: 2px solid #fff;border-bottom: 2px solid #fff;}
h2{	background-color: #5588ff;padding: 10px;}
#ED_column{padding: 2px;}

</style>

<!-- start of body-->
<body>
	<div class="wrapper">
		<a href="index.php"> <div class="header"></div></a>
		<!-- include navbar-->
		<div class="left">
			<?php include("includes/ADMINnavbar.php"); ?>
		</div>

	<div class="view_exercises">
		<center>
		<!-- table to display exercises from course A-->
		<table>
			<tr>
				<td colspan = "8"><h2>View all Exercises from Course A</h2></td>
				<br>
			</tr>
			<tr>
				<!-- column headers-->
				<th>Exercise ID</th>
				<th>Session Title</th>
				<th>Title</th>
				<th></th>
				<th></th>
			</tr>

			<?php
			//gets exercises from exercises table joins sessions to get session title
			$get_exercises = "SELECT * FROM exercises LEFT JOIN sessions on exercises.session_id = sessions.session_id WHERE course_id ='1' ORDER BY sessions.session_id";
			//run query
			$run_exercises = mysqli_query($con, $get_exercises);
			//iterator
			$i =1;
			//while loop fetches results as an array
			while ($row_exercises = mysqli_fetch_array($run_exercises)){
				//variables
				$exercise_id = $row_exercises ['exercise_id'];
				$session_id = $row_exercises ['session_id'];
				$session_title = $row_exercises ['session_title'];
				$exercise_title = $row_exercises ['exercise_title'];
			?>

				<tr>
					<!-- displays results-->
					<td><?php echo $i++; ?></td>
					<td><?php echo $session_title; ?></td>
					<td><?php echo $exercise_title; ?></td>
					<!-- edits and delete icon which runs edit_exercise.php form index and delete_exercise.php carrys exercise id through url-->
					<td id="ED_column"><a href="index.php?edit_exercise=<?php echo $exercise_id; ?>"><img src="../images/edit.png" width="30" height ="30"></a></td>
					<td id="ED_column"><a href="includes/delete_exercise.php?delete_exercise=<?php echo $exercise_id; ?>"><img src="../images/delete.png" width="30" height ="30"></a></td>
				</tr>
			<!-- end of while loop-->
			<?php } ?>
		</table>
		</center>
		<br>
		<br>


		<center>
		<!-- table to view all exercises from course B-->
		<table>
			<tr>
				<td colspan = "8"><h2>View all Exercises from Course B</h2></td>
				<br>
			</tr>
			<tr>
				<!-- column headers-->
				<th>Exercise ID</th>
				<th>Session Title</th>
				<th>Title</th>
				<th></th>
				<th></th>
			</tr>

			<?php
			//query to get exercies as join with session for course_id 2 ie course B
			$get_exercises = "SELECT * FROM exercises LEFT JOIN sessions on exercises.session_id = sessions.session_id WHERE course_id ='2' ORDER BY sessions.session_id";
			//run query
			$run_exercises = mysqli_query($con, $get_exercises);
			//iterator
			$i =1;
			//whiel loop for result array
			while ($row_exercises = mysqli_fetch_array($run_exercises)){
				//varaibles	
				$exercise_id = $row_exercises ['exercise_id'];
				$session_id = $row_exercises ['session_id'];
				$session_title = $row_exercises ['session_title'];
				$exercise_title = $row_exercises ['exercise_title'];
			?>

			<tr>
				<!-- display results in table -->
				<td><?php echo $i++; ?></td>
				<td><?php echo $session_title; ?></td>
				<td><?php echo $exercise_title; ?></td>
				<!-- edit and delete exercise, calls files, exercise_id passed thorugh url-->
				<td id="ED_column"><a href="index.php?edit_exercise=<?php echo $exercise_id; ?>"><img src="../images/edit.png" width="30" height ="30"></a></td>
				<td id="ED_column"><a href="includes/delete_exercise.php?delete_exercise=<?php echo $exercise_id; ?>"><img src="../images/delete.png" width="30" height ="30"></a></td>
			</tr>
			<!-- end of while-->
			<?php } ?>
		</table>
		</center>
	<!-- end of wrapper-->
	</div>
<!--end of body and html-->
</body>
</html>
<!-- end of else from the top-->
<?php } ?>