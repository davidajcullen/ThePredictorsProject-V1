<?php
	//include database connection and sesion start
	include("includes/database.php");
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf=8">
<title> Admin Login </title>
<link rel="stylesheet" href="styles/style_login.css" media "all" />
<link rel="shortcut icon" type="image/ico" href="../images/faviconn.ico" />
</head>

<body>
	<center>
	<div class="login">
		<div>
			<!-- get not authorised-->
			<h2 id='not_authorize'><?php echo @$_GET['not_authorize']; ?></h2>
		</div>
		<br>
		<!-- login input form-->
		<form method="post" action="login.php">
			<h2>The Predictors Project</h2>
			<h4>Admin Login</h4>
			<br>
			<input type="text" id= "user_input" name="admin_username" placeholder="Username" required="required" />
			<br><br>
			<input type="password" id= "user_input" name="admin_password" placeholder="Password" required="required" />
			<br>
			<!-- inpute for php -->
			<input type="submit" id= "login_btn" class="btn btn-primary btn-block btn-large" name="login" value="Admin Login" />
		</form>
	</div>
	</center>

</body>
</html>

<?php
	//if login button pressed
	if(isset($_POST['login'])){
		//escapes special characters in a string for use in an SQL statement
		$admin_username = mysqli_real_escape_string($con,$_POST['admin_username']);
		$admin_password = mysqli_real_escape_string($con,$_POST['admin_password']);
		//encrypts password
		$encrypt = md5($admin_password);
		//query to select user
		$select_admin = "select * from admin where admin_username='$admin_username' AND admin_password='$admin_password'";
		//run query
		$run_admin = mysqli_query($con,$select_admin);
		//returns rows as resutl set
		if(mysqli_num_rows($run_admin)>0){
			//session varibles declared
			$_SESSION['admin_username']=$admin_username;
			//go in index.php, you have sucessfully logged in!
			echo "<script>window.open('index.php?logged=You have Successfully Logged In!','_self')</script>";
		}else{
			//else, invalid password or username
			echo "<script>alert('User Name or Password is incorrect')</script>";
		} //end of else
	}//end of if and PHP
?>