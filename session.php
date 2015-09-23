<?php session_start();
	//session start and include database
	include("includes/database.php");
		//gets the check point session_id and button from the URL
		$session_id = $_GET['session_id'];
		$checkpoint = $_GET['current_exercise_number'];
		$button_selected = $_GET['button'];
		//session_variables
		$currentUserID = $_SESSION['currentUserID'];
		//query to get and run current user's saved session
		$saved_session_query = "select session_saved from user_current_session where session_id=$session_id AND user_id=$currentUserID" ;
		$get_saved_session = mysqli_query($con,$saved_session_query);
		$saved_record = mysqli_fetch_assoc($get_saved_session);
		
		//if saved record is greater than 0 (starting point of array)
		if(count($saved_record) > 0) {
			//if button pressed is next then current users new save point will be the current exercise +1
			if ($button_selected=="next") {
				$new_checkpoint1 = $_GET['current_exercise_number']+1;
			}
			//if button pressed is back then current users new save point will be the current exercise -1	
			elseif ($button_selected=="back") {
				$new_checkpoint1 = $_GET['current_exercise_number']-1;
			}
			//if button pressed is save then current users new save point will remain the same
			elseif ($button_selected=="save") {
				$new_checkpoint1 = $_GET['current_exercise_number'];
			}
			//update the user_current_session setting the session id to the current session_id, session saved = new check point. overrides current checkpoint.
			$q1 = "update user_current_session set session_id=$session_id,session_saved=$new_checkpoint1 where session_saved=$checkpoint AND session_id=$session_id AND user_id = $currentUserID" ;
			echo $q1;
			//updates old user_current_session
			$update_old1 = mysqli_query($con,$q1);
		
		}else{
			//if button pressed is next then current users new save point will be the current exercise +1
			if ($button_selected=="next") {
				$new_checkpoint2 = $_GET['current_exercise_number']+1;
			}
			//if button pressed is next then current users new save point will be the current exercise -1	
			elseif ($button_selected=="back") {
				$new_checkpoint2 = $_GET['current_exercise_number']-1;
			}
			//if button pressed is save then current users new save point will remain the same
			elseif ($button_selected=="save") {
				$new_checkpoint2 = $_GET['current_exercise_number'];
			}
			//insers into the user_current_session values current user id, new checkpoint 2	
			$q2 = "insert into user_current_session(user_id,session_saved,session_id) values($currentUserID,$new_checkpoint2,$session_id)";
			echo $q2;
			$update_old2 = mysqli_query($con,$q2);
		}
		//tracks through navigation operates bakc and next
		if ($button_selected=="next") {
			$back_checkpoint = $_GET['current_exercise_number']+1;
		}	
		elseif ($button_selected=="back") {
			$back_checkpoint = $_GET['current_exercise_number']-1;
		}
		elseif ($button_selected=="save") {
			$back_checkpoint = $_GET['current_exercise_number'];
		}
		else{
			session_destroy();
			header("location:index.php");
		}
		
		header("location:exercise.php?session_id=$session_id&current_exercise_number=$back_checkpoint&button=$button_selected");
?>