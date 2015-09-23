<!--Start session and include database-->
<?php session_start(); 
include("includes/database.php");
//checks expiry
if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { 
    //redirect to login.php
    header('Location: login.php');
} else{ //if we haven't expired:
    $_SESSION['last_activity'] = time(); // last activity.
} ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Exercise | Predictors Project</title>
<link rel="stylesheet" href="styles/style_exercise.css" media="all" />
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
<style type="text/css">
.footer_area{vertical-align:middle; font-family: arial;text-align: center; width:1000px; height:20px; background:#52afe2; color:#FFF; clear:both;padding-top: 5px;}
</style>
</head>

<body>

<!-- Main Container start-->
<div class="container">
	<!-- Head start-->
	<div class = "head">
			<img id ="logo" src ='images/logo.png' />
			<img id = "banner" src ='images/banner.png' />
		<form id="form1" name ="form 1" method = "post" action = "logoff.php">
			<input type="submit" name="logoffBtn" id = "logoffBtn" value ="Log Off" />
		</form>	
	</div>
	<!-- Head end-->
	
	<!-- Nav start-->
	<div class = "navbar">
		<?php include("includes/ITnavbar.php"); ?>
	</div>
	<!-- Nav end-->

	<!-- Post area startm-->
	<div class="post_area1">
	<?php
		//sends user to course home page if the session id is not set
		//or sends them to the login page if login status is not set
		if(!isset($_GET['session_id'])) {
			header("location:interactive_training.php");
		}elseif(!$_SESSION['login_status']) {
			header("location:login.php");
		}
		
		//gets varibles, current user from the session
		$currentUserID = $_SESSION['currentUserID'];
		$session_id = $_GET['session_id'];
		$checkpoint = $_GET['current_exercise_number'];
		// checkpoint = current exercise number
		$next_page = $checkpoint;
		$current_page = $checkpoint+=1;
		//query to get the exercises related to the session from the exercise table 
		$get_exercise = "SELECT * FROM `exercises` WHERE `session_id` = $session_id LIMIT $next_page,$current_page";
		//runs exercise query
		$run_exercise = mysqli_query($con, $get_exercise);
		$ex_info = mysqli_fetch_assoc($run_exercise);
		//counter to monitor where the user is in the session
		$counter = mysqli_query($con, "SELECT count(*) as count FROM `exercises` WHERE `session_id` = $session_id");
		$run_counter1 = mysqli_fetch_assoc($counter);
		?>
		<!-- Exercise HTML layout-->
		<br>
		<center>
		<div class="exercise_layout">
			<table width = 60%; >
				<tr height='50px'>
					<td><!--echo the exercise title from the assoicative array-->
						<h2 id = "exercise_title"><?php  echo $ex_info['exercise_title'] ; ?></h2>
					</td>
				</tr>
				<br>
				<!-- Display the image from images folder-->
				<tr height='350px'>
					<td>
						<img src="admin/exercise_content/<?php  echo $ex_info['exercise_image'] ?>" alt="Exercise" width="500">

						<!-- hide pre laoded video template-->
						<?php  if (!empty($ex_info['exercise_video'])): ?>
							<video id = "video" width="640" height="360" controls = "controls" src="admin/exercise_content/<?php  echo $ex_info['exercise_video'] ?>" alt="Exercise" type="video/mp4"> Your browser does not support the video tag. </video>
						<?php  endif ; ?>
					</td>
				</tr>
				<td>
					<div id= "ex_info">
						<h3 id = "info">information: </h3>
						<text id = "exercise_info">
						<!--echo the exercise text from the array-->
						<?php  echo $ex_info['exercise_text'] ?>
						</text>
					</div>	
				</td>
			</table>
		</center>
		<br>
		<center>
		<div id= "ex_buttons">

			<?php
				//if current exercise number not equal to "0" then go back to the previous exercise.
				if ($_GET['current_exercise_number'] != "0") {	?>
				<a id='button1' href="session.php?session_id=<?php echo $_GET['session_id']; ?>&current_exercise_number=<?php echo $_GET['current_exercise_number'];?>&button=back"> < Back </a>
			<?php }
				//else stop the user from going back any further. array starts at 0
				else { ?>
					<a id='button1' href="#"> < Back </a>
				<?php } ?>
					<!--Save button gets the session id, current_exercise_number from the url and sends it to session.php 
					in which the current users position is saved-->
					<a  id='button1' href="session.php?session_id=<?php echo $_GET['session_id']; ?>&current_exercise_number=<?php echo $_GET['current_exercise_number'];?>&button=save"> Save </a>	
			
				<?php 
					// if current exercise number is the last exercise before the last then retrieve it
					if( $_GET['current_exercise_number'] < $run_counter1['count']-1 ) { ?>
					<a id='button1' href="session.php?session_id=<?php echo $_GET['session_id']; ?>&current_exercise_number=<?php echo $_GET['current_exercise_number'];?>&button=next"> Next > </a>
				<?php }
					//else display the quiz button to send the user to the session quiz
					else { ?>
					<?php 
						//build up array as iterate through while loop
						$sessions_quiz_array = array();
						//query to get the quiz.
						$get_quiz = mysqli_query($con, "SELECT * FROM `quiz_list` WHERE `session_id` = $session_id");
						//fetches result row as an associative array
						while ($row_quizes = mysqli_fetch_assoc($get_quiz)) {
							$sessions_quiz_array[] = $row_quizes;
						}
						//for each to loop through and get the quiz details
						foreach ($sessions_quiz_array as $key => $value) {
						$quiz_id = $value['quiz_id'];
						$quiz_title = $value['quiz_title'];
						$quiz_author = $value['quiz_author'];
						?>
						<!--Passes the varibles which allow the quiz to be recored for the current user and the session its in.
						passed through URL-->
						<a id='button1' href="quiz.php?session_id=<?php echo $_GET['session_id']; ?>&quiz_id=<?php echo $quiz_id; ?>">Quiz</a>
					<?php } ?>	
				<?php }?>
		</div>
		</center>

	<!--Footer starts-->
	<div class="footer_area">
		<h3 style="padding:20px; text-align:center"></h3>
	</div><!--Footer ends-->
	<!--Hides images if no src. allimgs varible takes all the images and where there is an error
	it hides them to the user -->
	<script type="text/javascript">
	(function() {
		var allimgs = document.images;
		for (var i = 0; i < allimgs.length; i++) {
			allimgs[i].onerror = function() {
			this.style.visibility = "hidden"; // Other elements aren't affected. 
			}//end of function
		} //end of for
	})(); //enf of function
	</script>
	<center>
	<div class="footer_area">
		<h3>&copy; All Rights Reserved 2015 - PredictorsProject</h3>
	</div><!--Footer ends-->
	</center>
<!-- end og body and html -->
</body>
</html>