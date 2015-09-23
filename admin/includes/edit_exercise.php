<?php
//include database 
include("database.php");
//check if admin username not set.
if(!isset($_SESSION['admin_username'])){
	echo "<script>window.open('login.php?not_authorize=You are not authorized to access!','_self')</script>";
	} else { ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edit exercise</title>
<link rel="shortcut icon" type="image/ico" href="../images/faviconn.ico" />
</head>

<body>

	<?php
	//if get edit exercise is set
	if(isset($_GET['edit_exercise'])){
		//gets edit exercise from url
		$edit_id = $_GET['edit_exercise'];
		//query to select data from exercises where exercise id = edit id
		$select_exercise = "SELECT * FROM exercises WHERE exercise_id = '$edit_id'";
		//run query
		$run_query = mysqli_query($con, $select_exercise);
		//fetch result as an array
		while($row_exercise = mysqli_fetch_array($run_query)){

			//variables
			$exercise_id = $row_exercise['exercise_id'];
			$exercise_sess = $row_exercise['session_id'];
			$title = $row_exercise['exercise_title'];
			$video = $row_exercise['exercise_video'];
			$image = $row_exercise['exercise_image'];
			$text = $row_exercise['exercise_text'];
		}
	}?>
	<!-- form for populating exercise data pulled from while -->
	<form action="" method="post" enctype="multipart/form-data"> 
		<table class = "table_edit">	
			<tr>
				<td colspan="6" id = "edit_s_header"><h1>Update this Exercise:<h1></td>
			</tr>
			
			<tr>
				<!-- echos title-->
				<td id ="edit_titles" ><strong> Exercise Title:</strong></td>
				<td><input type="text" name="exercise_title" size="60" value="<?php echo $title; ?>"/></td>
			</tr>
			
			<tr>
				<td id = "exercise_titles"><strong> Exercise Session:</strong></td>
				<td>
				<!-- select named ses-->
				<select name="ses">
					<?php
					//gettign and displaying current exercise session
					$get_sess = "select * from sessions where session_id='$exercise_sess'";
					//run query
					$run_sess = mysqli_query($con, $get_sess);
					//put results as array
					while ($sess_row=mysqli_fetch_array($run_sess)){

						//varibles
						$ses_id=$sess_row['session_id'];
						$ses_title=$sess_row['session_title'];
						//display title
						echo "<option value='$ses_id'>$ses_title</option>";
						//get and run remaining sessions
						$get_more_sess = "select * from sessions";
						$run_more_sess = mysqli_query($con, $get_more_sess);
						//while to fetch as array
						while ($row_more_sess=mysqli_fetch_array($run_more_sess)){
							$ses_id=$row_more_sess['session_id'];
							$ses_title=$row_more_sess['session_title'];
							//display remaining sessions
							echo "<option value='$ses_id'>$ses_title</option>";
						} //end of whiles
					} ?>
				</select>
			</tr>
			<tr>
				<td id ="edit_titles"><strong> Exercise Video:</strong></td>
				<!-- preview of video-->
				<td><input type="file" name="exercise_video" size="50" /> <img src = "content_images/<?php echo $video; ?>" width="100" height="100"/></td>
			</tr>
			<tr>
				<!-- preview of image-->
				<td id ="edit_titles"><strong> Exercise Image:</strong></td>
				<td><input type="file" name="exercise_image" size="50" /> <img src = "content_images/<?php echo $image; ?>" width="100" height="100"/></td>
			</tr>
			<tr>
				<td id ="edit_titles"><strong> Exercise Text:</strong></td>
				<td><textarea name="exercise_text" rows="15" cols="50"><?php echo $text; ?></textarea></td>
			</tr>
		</table>
		<!-- input button for form-->
		<button id= 'update_btn'input type="submit" name="Update" > Update Now</button>
	</form>
<!--end of body and html-->
</body>
</html>

<?php
// posts inputs from form if set
if(isset($_POST['Update'])){
	//variables
	$update_id = $exercise_id;
	$exercise_title = $_POST['exercise_title'];
	$exercise_sess1 = $_POST['ses'];
	$exercise_video = $_FILES['exercise_video'] ['name'];
	$exercise_video_tmp = $_FILES['exercise_video']['tmp_name'];
	$exercise_image = $_FILES['exercise_image'] ['name'];
	$exercise_image_tmp = $_FILES['exercise_image']['tmp_name'];
	$exercise_text = $_POST['exercise_text'];

	//input validation, if exercise title empty, rename it to "Session Exercise"
	if(empty($_POST['exercise_title'])){
		$exercise_title = "Session Exercise";
		echo "<script>alert('SUCCESS: Session has been Published! (default title: Session Exercise)</script>";
	}
	//input validation, checks for empty exercise_title, checks if admin selected a session
	// and entered text, run js alert	
	if(empty($_POST['ses']) OR $exercise_text=='' OR $_FILES['exercise_video']['name'] == "" && $_FILES['exercise_image']['name'] == ""){

		echo "<script>alert('ERROR: Please make sure the exercise has a title, session selected and exercise info')</script>";
		exit();

	//if validation ok then:
	} else {
		//move temp files
		move_uploaded_file($exercise_video_tmp,"content_images/$exercise_video");
		move_uploaded_file($exercise_image_tmp,"content_images/$exercise_image");
		//update exercises where exercise_id = update_id
		$update_exercises = "update exercises set session_id = '$exercise_sess1', exercise_title = '$exercise_title', exercise_image = '$exercise_image', exercise_text = '$exercise_text' where exercise_id='$update_id'";
		//run query
		$run_update = mysqli_query($con, $update_exercises); 
		
		//JS echo telling admin exercise has been updated
		echo "<script>alert('Exercise Has been updated!')</script>";
		//send admin back to view exercises
		echo "<script>window.open('view_exercises.php','_self')</script>";
	} //end of else	
} //end of if and else from the top
} ?>
