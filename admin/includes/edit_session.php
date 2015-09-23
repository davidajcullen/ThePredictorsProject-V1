<?php
//include database 
include("database.php");
//check if admin username not set.
if(!isset($_SESSION['admin_username'])){
	echo "<script>window.open('login.php?not_authorize=You are not authorized to access!','_self')</script>";
	}
else {
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edit session</title>
<link rel="shortcut icon" type="image/ico" href="../images/faviconn.ico" />
</head>

<body>
	<?php
	//if edit_session is set GET from url
	if(isset($_GET['edit_session'])){
		//local variables
		$edit_id = $_GET['edit_session'];
		//select session details where session_id = session selected from view sessions table
		$select_session = "SELECT * FROM sessions WHERE session_id = '$edit_id'";
		//run select session query
		$run_query = mysqli_query($con, $select_session);
		//while loop for query
		while($row_session = mysqli_fetch_array($run_query)){
		//local variables = row data for while
		$session_id = $row_session['session_id'];
		$title = $row_session['session_title'];
		$session_cors = $row_session['course_id'];
		$author = $row_session['session_author'];
		$image = $row_session['session_image'];
		$info = $row_session['session_info'];
		}//end of while
	//end of IF
	}?>

	<!-- form to display session data from database, ready to be edited -->
	<form action="" method="post" enctype="multipart/form-data"> 
		<!-- layed out in html table -->
		<table class = "table_edit">
            <tr>
				<td colspan="6" id = "edit_s_header"><h1>Update this Session:<h1></td>
			</tr>
			<tr>
				<td id ="edit_titles" ><strong> Session Title:</strong></td>
				<!-- echos previous $title from database table -->
				<td><input type="text" name="session_title" size="60" value="<?php echo $title; ?>"/></td>
			</tr>
			<tr>
			<td id ="edit_titles">
				<strong> Session Course:</strong>
			</td>
			<td>
				<!-- select name = cor = session course -->
				<select name="cor">
				<?php
				//query to get current course
				$get_cors = "select * from courses where cor_id ='$session_cors'";
				//run query
				$run_cors = mysqli_query($con, $get_cors);
					
					//while loop to get the course
					while ($cors_row=mysqli_fetch_array($run_cors)){
						//local variable
						$cor_id=$cors_row['cor_id'];
						$cor_title=$cors_row['cor_title'];
						//display course title
						echo "<option value='$cor_id'>$cor_title</option>";

					//query to get courses to select from course A or course B
					$get_more_cors = "select * from courses";
					$run_more_cors = mysqli_query($con, $get_more_cors);
					//while loop to get all the remaining courses
					while ($row_more_cors=mysqli_fetch_array($run_more_cors)){
						$cor_id=$row_more_cors['cor_id'];
						$cor_title=$row_more_cors['cor_title'];
						//display course titles
						echo "<option value='$cor_id'>$cor_title</option>";
					} //end of first while
					//end of 2nd while and php
					} ?>
				</select>
			</td>
			</tr>
			<tr>
				<td id ="edit_titles"><strong> Session Author:</strong></td>
				<td><input type="text" name="session_author" size="30" value="<?php echo $author; ?>" /></td>
			</tr>
			<tr>
				<td id ="edit_titles"><strong> Session Image:</strong></td>
				<!-- shows previous of current image -->
				<td><input type="file" name="session_image" size="50" /> <img src = "content_images/<?php echo $image; ?>" width="100" height="100"/></td>
			</tr>
			<tr>
				<td id ="edit_titles"><strong> Session Info:</strong></td>
				<td><textarea name="session_info" rows="15" cols="50"><?php echo $info; ?></textarea></td>
			</tr>
		</table>
		<!-- update button for form -->
		<button id= 'update_btn'input type="submit" name="Update" > Update Now </button>
	<!-- end of form -->
	</form>
<!-- end of body and html -->
</body>
</html>

<?php
//if update has been pressed then:
if(isset($_POST['Update'])){
		//update id = new session id
		$update_id = $session_id;
		//local varaibles to take the new admin input takes $_post form input name
		$session_title = $_POST['session_title'];
		$session_date = date('m-d-y');
		$session_cor1 = $_POST['cor'];
		$session_author = $_POST['session_author'];
		$session_image = $_FILES['session_image'] ['name'];
		$session_image_tmp = $_FILES['session_image']['tmp_name'];
		$session_info = $_POST['session_info'];


			//input validation, if exercise title empty, rename it to "Session Exercise"
		if(empty($_POST['session_title'])){
			$session_title = "Course Session";
			echo "<script>alert('SUCCESS: Session has been Published! (default title: Course Session)</script>";
		}
		//input validation, checks for empty exercise_title, checks if admin selected a session
		// and entered text, run js alert	
		if(empty($_POST['cor'])){

			echo "<script>alert('ERROR: Please make sure the session has a course')</script>";
			exit();
			
		//if validation ok then update sessiosn table in database
		} else {
			move_uploaded_file($session_image_tmp,"content_images/$session_image");
			//sql query to update table where $update_id = $session_id;
			$update_sessions = "update sessions set course_id = '$session_cor1', session_title = '$session_title', session_date = '$session_date',
			session_author='$session_author', session_image = '$session_image', session_info = '$session_info' where session_id='$update_id'";
			//run query
			$run_update = mysqli_query($con, $update_sessions); 
			//JS alert to say session has been updated
			echo "<script>alert('SUCCESS: Session Has been updated!')</script>";
			//return too view sessions page.
			echo "<script>window.open('view_sessions.php','_self')</script>";
		} // end of else	
		} //end of if
} //end of IF from the top
?>

