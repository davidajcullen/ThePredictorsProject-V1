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
	<div class="wrapper">
		<a href="index.php"> <div class="header"></div></a>
	<div class="left">
		<?php include("includes/ADMINnavbar.php"); ?>
	</div>

	<div class="view_sessions">
		<center>
		<!--table to view quizzes-->
		<table>
			<tr>
				<td colspan = "8"><h2>View all Quizes</h2></td>
				<br>
			</tr>
			<tr>
				<!--table headers-->
				<th>Course</th>
				<th>Quiz title</th>
				<th></th>
			</tr>

			<?php
			//query to get quizzes from quiz list
			$get_quizes = "SELECT * FROM quiz_list ORDER BY course_id";
			//run query
			$run_quizes = mysqli_query($con, $get_quizes);
			//whiel loop for fetched results
			while ($row_quizes = mysqli_fetch_array($run_quizes)){
				//varaibles as rows
				$quiz_id = $row_quizes ['quiz_id'];
				$course_id = $row_quizes ['course_id'];
				$quiz_title = $row_quizes ['quiz_title'];
			?>
			<tr>
				<!-- if else which changes course 1 to course A and vcourse 2 to course B -->
				<td>
				<?php 
				if($course_id != '1'){
				echo "Course B"; 
				}else{
					echo "Course A";
				} ?>
				</td>
				<!--echo quiz title and delete quiz for reseacher-->
				<td><?php echo $quiz_title; ?></td>
				<td id="ED_column"><a href="includes/delete_quiz.php?delete_quiz=<?php echo $quiz_id; ?>"><img src="../images/delete.png" width="30" height ="30"></a></td>
			</tr>
			<!-- end of while -->
			<?php } ?>
		</table>
		</center>
	</div>
<!-- end of body html and php else form top of script-->
</body>
</html>
<?php } ?>