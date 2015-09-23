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

<!-- start of body-->
<body>
	<div class="wrapper">
	
		<a href="index.php"> <div class="header"></div></a>
		
		<!-- include Nav bar-->
		<div class="left">
			<?php include("includes/ADMINnavbar.php"); ?>
		</div>

		<div class="view_sessions">
			<center>
			<!-- table to view all sessions -->
			<table>
				<tr>
					<td colspan = "8"><h2>View all Sessions</h2></td>
					<br>
				</tr>

				<tr>
					<!--table headers-->
					<th>Course ID</th>
					<th>Session</th>
					<th>Title</th>
					<th>Author</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
					<?php
					//query to get sessions order by course_ide
					$get_sessions = "SELECT * FROM sessions ORDER BY Course_id";
					//run query
					$run_sessions = mysqli_query($con, $get_sessions);
					//iterator
					$i=1;
					//while loop for result set
					while ($row_sessions = mysqli_fetch_array($run_sessions)){
						//varaibles = row data
						$session_id = $row_sessions ['session_id'];
						$course_id = $row_sessions ['course_id'];
						$session_title = $row_sessions ['session_title'];
						$session_author = $row_sessions ['session_author'];
					?>
					<tr>
						<!-- changes course 1 and 2 to course A and B if else-->
						<td>
						<?php 
						if($course_id != '1'){
						echo "Course B"; 
						}else{
							echo "Course A";
						} ?>
						</td>
						<!-- iterates through and displays data-->
						<td><?php echo $i++;?></td>
						<td><?php echo $session_title; ?></td>
						<td><?php echo $session_author; ?></td>
						<!-- edit session and delete session buttons which laod edit_session.php from index and delete_session.php
						pulls through session id to url-->
						<td id="ED_column"><a href="index.php?edit_session=<?php echo $session_id; ?>"><img src="../images/edit.png" width="30" height ="30"></a></td>
						<td id="ED_column"><a href="includes/delete_session.php?delete_session=<?php echo $session_id; ?>"><img src="../images/delete.png" width="30" height ="30"></a></td>
					</tr>
				<!-- end of while-->
				<?php } ?>
			</table>
			</center>
		<!-- end of view sessions and wrapper div-->
		</div>
	</div>
<!--end of body, html and else php from top-->
</body>
</html>
<?php } ?>