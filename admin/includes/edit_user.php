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
<link rel="shortcut icon" type="image/ico" href="../images/faviconn.ico" />
<link rel="stylesheet" href="styles/style.css" />
<title>edit user</title>

<script>
		//possible entries for password
		var keylist="abcdefghijklmnopqrstuvwxyz123456789"
		var temp=''
		//function for length
		function generatepass(plength){
		temp=''
		//for loop which goes through key randomly picking a character until 7 is reached
		for (i=0;i<plength;i++)
		temp+=keylist.charAt(Math.floor(Math.random()*keylist.length))
		return temp
		}
		//enter length of password
		function populateform(enterlength){
		document.pgenerate.user_password.value=generatepass(enterlength)
		}
		</script>
</head>

<body>
	<?php
	//if edit user is set the run query and while
	if(isset($_GET['edit_user'])){
		//gets edit_id form url
		$edit_id = $_GET['edit_user'];
		//query to select all from users where edit id is the same as user_id
		$select_user = "SELECT * FROM users WHERE user_id = '$edit_id'";
		//run query
		$run_users = mysqli_query($con, $select_user);
		//results array
		while ($row_users = mysqli_fetch_array($run_users)){
			//variables
			$user_id = $row_users ['user_id'];
			$user_courses = $row_users ['course_id'];
			$user_code = $row_users ['user_code'];
			$user_password = $row_users ['password'];
		}
	} ?>
	<!--display edit user for as populated-->
	<form name="pgenerate" action="" method="post" enctype="multipart/form-data">
		<table class = "user_table">
            <tr>
				<td width= "70%"; colspan = "9" id= "table_header" align = "center"><h2>Edit user</h2></td>
				<br>
			</tr>
			<tr>
				<td><strong> User Code:</strong></td>
				<!-- display user_code-->
				<td><input type="text" name="user_code"  value="<?php echo $user_code; ?>" size="30" /></td>
			</tr>
			<br>
			<tr>
				<td><strong> User Course:</strong></td>
				<td>
				<select name="cor">
					<?php
					//gets current course for selection
					$get_cors = "select * from courses where cor_id ='$user_courses'";
					//runs query
					$run_cors = mysqli_query($con, $get_cors);
		
					//fetches result as array
					while ($cors_row=mysqli_fetch_array($run_cors)){
						//variables
						$cor_id=$cors_row['cor_id'];
						$cor_title=$cors_row['cor_title'];
						//display current course title
						echo "<option value='$cor_id'>$cor_title</option>";

						//query to get all courses
						$get_more_cors = "select * from courses";
						//run query
						$run_more_cors = mysqli_query($con, $get_more_cors);
						//fetches result as array
						while ($row_more_cors=mysqli_fetch_array($run_more_cors)){
							//variables
							$cor_id=$row_more_cors['cor_id'];
							$cor_title=$row_more_cors['cor_title'];
							//display other course title's
							echo "<option value='$cor_id'>$cor_title</option>";
						}
					} ?>
				</select>
				
			</tr>
			<tr></tr>
			<tr>
				<td><strong> User Password:</strong></td>
				<td>
				<!--genreate password input onClick populates form-->
				<input type="text" size="18" value="<?php echo $user_password; ?>" name="user_password"/>
				<input id = "user_btn3"type="button" value="Generate Password" onClick="populateform(this.form.thelength.value)"><br />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input name="thelength" size=3 value="7" type ="hidden">
				</td>
			</tr>
		</table>
		<!-- button for php to submit data when pressed -->
		<button id= 'user_btn2'input type="submit" name="Update" value="Update Now">Update user now</button>
		</p>
	</div>
	</center>
<!-- end of body and html-->
</body>
</html>

<?php
//if update is set/pressed then:
if(isset($_POST['Update'])){

	//upate idea is user id
	$update_id = $user_id;
	//variables
	$user_code = $_POST['user_code'];
	//cor from select
	$user_courses1 = $_POST ['cor'];
	$user_password= $_POST['user_password'];


	//input validation, checks if user input details are empty, if so run js alert
	if(empty($_POST['cor']) OR $user_code =='' OR $user_password ==''){
		echo "<script>alert('ERROR: To create a user you need to enter all the details')</script>";
		exit();

	//else submit data to form
	} else {
		
		//update users where user_id = update id
		$update_users = "update users set user_code = '$user_code', password = '$user_password', course_id = '$user_courses1' where user_id ='$update_id'";
		//run query
		$run_update = mysqli_query($con, $update_users); 
		//JS alert confirming user has been updated
		echo "<script>alert('User has been updated!')</script>";
		//end user back to manage_users.php
		echo "<script>window.open('manage_users.php','_self')</script>";			
	} //end of else
//end of if & else from top

}
} ?>



