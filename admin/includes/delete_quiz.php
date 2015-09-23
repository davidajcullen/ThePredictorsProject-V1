<?php
//include database connection
include("database.php");
	//if delete quiz was pressed run:
	if(isset($_GET['delete_quiz'])){
		//creates delete id varible as session schossen to be deleted
		$delete_id = $_GET['delete_quiz'];
		//makes query to delete quiz from table
		$delete_quiz = "DELETE FROM quiz_list, quiz_questions USING quiz_list LEFT JOIN quiz_questions ON quiz_list.quiz_id = quiz_questions.quiz_id WHERE quiz_list.quiz_id = '$delete_id'";

		//"DELETE from quiz_list where quiz_id='$delete_id'";
		//run query
		$run_delete = mysqli_query($con,$delete_quiz); 
		//alerts researcher the quiz has been deleted
		echo "<script>alert('A quiz has been deleted')</script>";
		//returns admin to view quiz page
		echo "<script>window.open('../view_quiz.php','_self')</script>";
	} //end of IF
//end of PHP
?>

