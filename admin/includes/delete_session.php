<?php 
//include database connection
include("database.php");
	//if delete session was pressed run:
	if(isset($_GET['delete_session'])){
		//creates delete id varible as session schossen to be deleted
		$delete_id = $_GET['delete_session'];
		//makes query to delete session and exercises linked with the session
		$delete_session = "DELETE FROM sessions, exercises USING sessions LEFT JOIN exercises ON sessions.session_id = exercises.session_id WHERE sessions.session_id= '$delete_id'";
		//runs delete session query
		$run_delete = mysqli_query($con,$delete_session); 
		//alerts admin the session has been deleted
		echo "<script>alert('SUCCESS: A session and session exercises have been deleted')</script>";
		//returns admin to view sessions page
		echo "<script>window.open('../view_sessions.php','_self')</script>";
		} //end of IF
//end of PHP
?>