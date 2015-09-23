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

<!-- Java script function from tinymce.cachefly.net/4.2/tinymce.min.js not coded by developer -->
<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>

<!-- shows session or exercise div on selction -->
<script>
function showDiv(el1,el2){
	document.getElementById(el1).style.display = 'block';
	document.getElementById(el2).style.display = 'none';
}
</script>
</head>

<body>
	<div class="wrapper">
		<a href="index.php"> <div class="header"></div></a>
		<!-- includes admin naviagation bar -->
		<div class="left">
			<?php include("includes/ADMINnavbar.php"); ?>
		</div>

		<!-- div for the buttons on the right hand side of the page, buttons display the content in the div 'right'
	    onClick functions for divs is(insert session) and ie(insert exercise)
	    onClick function which brings user to create_quiz_B.php page
	     -->
		<div class="right" >
			<center>
			<h2 id = 'course_admin_titleB'>Course B</h2>
			<button id= 'create_btn1' onClick="showDiv('is', 'ie')">Create new session</button>
			<button id= 'create_btn2' onClick="showDiv('ie', 'is')">Create new exercise</button>
			<button id= 'create_btn1' onClick="location.href='includes/create_quiz_B.php';">Create new quiz</button>
			</center>
		</div>
		<!-- block of code which displays the insert session (is) div and insert exercise(ie) div. takes input from the admin
		inputs have names which will be used for idenifying what to add into the database when the 
		insert session button has been pressed and php code ran.
		 -->
		<div id = "right_content">
			<center>
			<div id= "is">
				<!-- input form for admin -->
				<form action="courseB.php" method="post" enctype="multipart/form-data"> 
					<table class = "table_sessionB">
						<tr>
							<td id = "create_s_headerB"colspan="6"><h1>Create New Session:<h1></td>
						</tr>
						<tr>
							<td id = "session_titlesB"><strong> Session Title:</strong></td>
							<td><input type="text" name="session_title" size="60" /></td>
						</tr>
						<tr>
							<td id = "session_titlesB"><strong> Session Course:</strong></td>
							<td>
							<div>
								Course B
							</div>		
						</tr>
						<tr>
							<td id = "session_titlesB"><strong> Session Author:</strong></td>
							<td><input type="text" name="session_author" size="60" /></td>
						</tr>
						<tr>
							<td id = "session_titlesB"><strong> Session Image:</strong></td>
							<td><input type="file" name="session_image" size="50" /></td>
						</tr>
						<tr>
							<td id = "session_titlesB"><strong> Session Info:</strong></td>
							<td><textarea name="session_info" rows="30" cols="50" ></textarea></td>
						</tr>
					</table>
					<!-- button with input type 'submit' which is referenced by the php code -->
					<button id= 'create_btn1'input type="submit" name="submit" > Publish Session Now</button>
					<input type="hidden" value="is" name="type">
				</form>
			</div>
			</center>

			<center>
			<!-- insert exercise div (ie) -->
			<div id= "ie">
			<!-- input form for admin -->
				<form action="courseB.php" method="post" enctype="multipart/form-data"> 
					<table class = "table_exerciseB">
						<tr>
							<td colspan="6" id = "create_e_headerB"><h1>Create New Exercise:<h1></td>
						</tr>
						<tr>
							<td id = "exercise_titlesB"><strong> Exercise Title:</strong></td>
							<td><input type="text" name="exercise_title" size="60" /></td>
						</tr>
						<tr>
							<td id = "exercise_titlesB"><strong> Exercise Session:</strong></td>
							<td>
								<select name="ses">
									<!-- select fuction for admin to selection which session the exercise is going to -->
									<option value="0"> Select a Session </option>
									<?php
									//gets session querys and runs query from database where course = 2 aka course B
									$get_sess = "select * from sessions where course_id='2'";

									$run_sess = mysqli_query($con, $get_sess);
									//while loop to get all the sessions wher course id = 2
									while ($sess_row=mysqli_fetch_array($run_sess)){
									//local variable = table row
									$ses_id=$sess_row['session_id'];
									$ses_title=$sess_row['session_title'];
									//displays list of session title's to admin
									echo "<option value='$ses_id'>$ses_title</option>";
									} ?>
								</select>
						</tr>
						<tr>
							<!-- input type file opens up file directory so admin can select an video from their local documents -->
							<td id = "exercise_titlesB"><strong> Exercise Video:</strong></td>
							<td><input type="file" name="exercise_video" size="100" /></td>
						</tr>
						<tr>
							<td id = "exercise_titlesB"><strong> Exercise Image:</strong></td>
							<td><input type="file" name="exercise_image" size="100" /></td>
						</tr>
						<tr width="100">
							<!-- input text area for admin to type exercise content -->
							<td id = "exercise_titlesB"><strong> Exercise Text:</strong></td>
							<td><textarea name="exercise_text" rows="15" cols="50" ></textarea></td>
						</tr>
					</table>
					<!-- button with input type 'submit' which is referenced by the php code -->
					<button id= 'create_btn2'input type="submit" name="submit1" > Publish Exercise Now</button>
					<!-- Hide if not clicked -->
					<input type="hidden" value="ie" name="type">
				</form>
			</div>
			</center>
		<!-- close wrapper div, body and html -->
		</div>
</body>
</html>

<?php
//if submit button is set i.e 'publish session now' pressed then:
if(isset($_POST['submit'])){
	//local variables taking the input names from the html forms above
	$session_title = $_POST['session_title'];
	//takes current date
	$session_date = date('m-d-y');
	$session_cor = '2';
	$session_author = $_POST['session_author'];
	$session_image = $_FILES['session_image'] ['name'];
	//places image into a temp file
	$session_image_tmp = $_FILES['session_image']['tmp_name'];
	$session_info = $_POST['session_info'];

		//input validation, checks if session title is empty, if so rename
		if(empty($_POST['session_title'])){
			$session_title = "Session";
		}
		//input validation
		if(empty($_POST['session_author'])){
			$session_author = "Predictors Project";
		}
		//input validation
		if(empty($_POST['session_info'])){
			$session_info = "Course Session";
		}
		
		
	//moves temp image to admins content images
	move_uploaded_file($session_image_tmp,"content_images/$session_image");
	//query to insert into the sessions table the admins input from the form as local variables
	$insert_sessions = "INSERT INTO sessions (course_id, session_title, session_date, session_author, session_image, session_info) 
	VALUES ('$session_cor','$session_title','$session_date','$session_author', '$session_image', '$session_info')";
	//runs query
	$run_sessions = mysqli_query($con, $insert_sessions); 
	//JS to tell user session has been published
	echo "<script>alert('SUCCESS: Session Has been Published!')</script>";
	//returns to courseA page on the admin panel
	echo "<script>window.open('courseB.php', '_self')</script>";

} ?>
<?php
//if submit button is set i.e 'publish session now' pressed then:
if(isset($_POST['submit1'])){
	//local variables taking the input names from the html forms above
	$exercise_title = $_POST['exercise_title'];
	$exercises_ses = $_POST['ses'];
	$exercise_video = $_FILES['exercise_video'] ['name'];
	//places video into a temp file
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
			echo "<script>alert('ERROR: Please make sure the exercise has a session selected, image or video and exercise info')</script>";
			exit();
		} else  {
			//moves temp files to admins content images
			move_uploaded_file($exercise_video_tmp,"exercise_content/$exercise_video");
			move_uploaded_file($exercise_image_tmp,"exercise_content/$exercise_image");
			//quiery to insert the form data from the admin into the exercises table
			$insert_exercises = "insert into exercises (session_id,exercise_title, exercise_video, exercise_image,exercise_text) 
			values ('$exercises_ses','$exercise_title', '$exercise_video','$exercise_image','$exercise_text')";
			//runs query
			$run_exercises = mysqli_query($con,$insert_exercises); 
			//JS to tell user exercise has been published
			echo "<script>alert('SUCCESS: Exercise Has been Published!')</script>";
			//returns to courseA page on the admin panel
			echo "<script>window.open('courseB.php','_self')</script>";
			} //end of else	
		} //end of IF
	//end of if & end of PHP
} ?> 