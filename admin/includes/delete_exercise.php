<?php 
//include database connection
include("database.php");
	//if delete quiz was pressed run:
	if(isset($_GET['delete_exercise'])){
		//creates delete id varible as session schossen to be deleted
		$delete_id = $_GET['delete_exercise'];
		//makes query to delete exercise from table
		$delete_exercise = "DELETE from exercises where exercise_id='$delete_id'";
		//run query
		$run_delete = mysqli_query($con,$delete_exercise); 
		//alerts admin the exercise has been deleted
		echo "<script>alert('A exercise has been deleted')</script>";
		//returns admin to view exercises page
		echo "<script>window.open('../view_exercises.php','_self')</script>";
	} //end of IF
//end of PHP
?>

