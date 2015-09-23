<?php 
//include databse
include("database.php");
	//if delete user has been set then:
	if(isset($_GET['delete_user'])){
		
		//get delete user from url
		$delete_id = $_GET['delete_user'];
		//query to delete user where user_id = delete_id
		$delete_user = "DELETE from users where user_id='$delete_id'";
		//run query
		$run_delete = mysqli_query($con,$delete_user); 
		//JS alert saying user has been deleted
		echo "<script>alert('SUCCESS: A user has been deleted')</script>";
		//send admin back to manage users
		echo "<script>window.open('../manage_users.php','_self')</script>";
		} //end of if
//end of php
?>