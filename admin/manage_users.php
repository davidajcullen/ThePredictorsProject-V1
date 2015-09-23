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

<!-- JS to hide and display divs -->
<script>
	function showDiv(el1,el2){
	document.getElementById(el1).style.display = 'block';
	document.getElementById(el2).style.display = 'none';
}
</script>

<!-- JS to generate a password for the admin -->
<script>
	//possible entries for password
	var key="abcdefghijklmnopqrstuvwxyz123456789"
	var temp=''
	//function for length
	function generatepass(plength){
	temp=''
	//for loop which goes through key randomly picking a character until 7 is reached
	for (i=0;i<plength;i++)
	temp+=key.charAt(Math.floor(Math.random()*key.length))
	return temp
	}
	//enter length of password
	function populateform(enterlength){
		document.pgenerate.user_password.value=generatepass(enterlength)
	}
</script>
</head>

<!-- start of body-->
<body>
<div class="wrapper">
	<a href="index.php"> <div class="header"></div></a>

	<!-- nav bar-->
	<div class="left">
		<?php include("includes/ADMINnavbar.php"); ?>
	</div>

	<div class="right" >
	<center>
		<h2 id = 'course_admin_titleB'>Manage Users</h2>
		<!-- hide or show div on click buttons -->
		<button id= 'user_btn1' onClick="showDiv('vu', 'au')">View Users</button>
		<button id= 'user_btn2' onClick="showDiv('au', 'vu')">Add Users</button>
	</center>
	</div>

	<div id = "right_content">
		<center>
		<!-- add user div-->
		<div id= "au">
			<form name="pgenerate" action="manage_users.php" method="post" enctype="multipart/form-data"> 
				<table class = "user_table">

					<tr>
						<td width= "70%"; colspan = "9" id= "table_header" align = "center"><h2>Add new user:</h2></td>
						<br>
					</tr>

					<tr>
						<td><strong> User Code:</strong></td>
						<!-- user_code php input-->
						<td><input type="text" name="user_code" size="30" /></td>
					</tr>
					<br>
					<tr>
						<td><strong> User Course:</strong></td>
						<td>
							<select name="cor">
								
								<option value="0"> Select a Course </option>
								<?php
								//select what course to add user too gets all from courses
								$get_cors = "select * from courses";
								//runs query
								$run_cors = mysqli_query($con, $get_cors);
								//fetches courses
								while ($cors_row=mysqli_fetch_array($run_cors)){
									$cor_id=$cors_row['cor_id'];
									$cor_title=$cors_row['cor_title'];
									//displays courses
									echo "<option value='$cor_id'>$cor_title</option>";
								} ?>

							</select>
					</tr>
					<tr></tr>
					<tr>
						<td><strong> User Password:</strong></td>
						<td>
							<!-- password php input-->
							<input type="text" size=18 name="user_password"/>
							<input id = "user_btn3"type="button" value="Generate Password" onClick="populateform(this.form.thelength.value)"><br />
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="hidden" name="thelength" size=3 value="7">
						</td>
					</tr>
				</table>
				<!-- submit button for php input-->
				<button id= 'user_btn2'input type="submit" name="submit" > Add User Now</button>
			</form>
			
			<!-- hide if not pressed-->
			<input type="hidden" value="au" name="type">
		</div>
		</center>

		<center>
		<div id= "vu">
			<!-- search from/button-->
			<form action="manage_users.php" method="post" enctype="multipart/form-data"> 
				<form name = "search_users" method="POST" action="manage_users.php">
					<input id='search_btn' type = "text" name="search_box" value="" />
					<input id ="search" type="submit" name = "search" value = "Search for user...">
				</form>

				<!-- makes the table scrollable-->
				<div id = "scrollable">
					<!-- table to view all users-->
					<table class = "user_table1";>
						<tr>
							<td width= "70%"; colspan = "9" id= "table_header"><h2>View all Users</h2></td>
						<br>
						</tr>

						<!-- column headers-->
						<tr id = "column_headers">
							<th>ID</th>
							<th>User Course</th>
							<th>User Code</th>
							<th>User Password</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>


						<?php
						//geta all users query
						$get_users = "SELECT * FROM users";
						$run_users = mysqli_query($con, $get_users);
						//iterator
						$i=1;
						while ($row_users = mysqli_fetch_array($run_users)){
							//declaring variables
							$user_id = $row_users ['user_id'];
							$user_course = $row_users ['course_id'];
							$user_code = $row_users ['user_code'];
							$user_password = $row_users ['password'];
						?>

						<div class = "inner_table">
							<tr>
								<!-- user starts at 1 -->
								<td><?php echo $i++; ?></td>
								<td>
									<?php
									//change course code to more readable course A or course B
									if($user_course != '1'){
									echo "Course B"; 
									}else{
										echo "Course A";
									} ?>
								</td>
								<!-- display usercode and password-->
								<td><?php echo $user_code; ?></td>
								<td><?php echo $user_password; ?></td>
								<td id="ED_column"><a href="index.php?edit_user=<?php echo $user_id; ?>"><img src="../images/edit.png" width="30" height ="30" ></a></td>
								<td id="ED_column"><a href="includes/delete_user.php?delete_user=<?php echo $user_id; ?>"><img src="../images/delete.png" width="30" height ="30"></a></td>
							</tr>
						</div>
						<!-- end of while-->
						<?php } ?>

						<?php
						//search users
						if(isset($_POST['search'])){
							$search_term = mysqli_real_escape_string($con, $_POST['search_box']);
							$get_users .="WHERE user_code = '{$search_term}'";
						} ?>
					</table>
				</div>
				<!-- hide div if not pressed-->
				<input type="hidden" value="vu" name="type">
			</form>
		</div>
		</center>
	</div>
<!-- end of body and html-->
</body>
</html>

<?php
//if submit button for add user pressed then:
if(isset($_POST['submit'])){

	//declare variables
	$user_id = $row_users ['user_id'];
	$user_code = $_POST['user_code'];
	$user_password= $_POST['user_password'];
	$session_cor = $_POST['cor'];

	//input validation, checks if user input details are empty, if so run js alert
	if(empty($_POST['cor']) OR $user_code =='' OR $user_password ==''){
		echo "<script>alert('ERROR: To create a user you need to enter all the details')</script>";
		exit();


	//else add the form content to the database
	} else {

		//query to check if user_code entered has already been taken
		$user_taken = "SELECT users.user_code FROM users WHERE user_code = '$user_code'";
        $run_user_taken = mysqli_query($con, $user_taken);
        if(mysqli_num_rows($run_user_taken)){
            echo "<script>alert('ERROR: User code already taken, record was not added!')</script>";
        }else{
		//query to add user
		$insert_user = "INSERT INTO users (user_code, password, course_id) 
		VALUES ('$user_code','$user_password','$session_cor')";
		//run query
		$run_users = mysqli_query($con, $insert_user); 
		//JS to admin user had been added
		echo "<script>alert('SUCCESS: User has been added!')</script>";
		//bring admin back to manage users.php
		echo "<script>window.open('manage_users.php?', '_self')</script>";
	}
		} //end of else
}//end of if
}//end of else at top and php
?>


