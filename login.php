<?php
	//include database connection and sesion start
	include("includes/database.php");
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf=8">
<title>Login | Predictors Project</title>
<link rel="stylesheet" href="styles/style_login.css" media="all" />
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
</head>

<body>
<div class="login">
	<center>
	<!-- $_SERVER holds information about headers, paths, and script locations -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    	<div id='logo'>
			<img id ="logo" src ='images/logo.png' />
		</div>

		<div id="user_login">
			<h2>User Login</h2>
		</div>
		<!-- hold user input html-->
		<h4>You must log into </br> The Predictors Project</br> Interactive Training</h4>
    	<input type="text" id="user_input" name="user_code" placeholder="User Code" required="required" />
    	<br>
    	<br>
        <input type="password" id="user_input" name="password" placeholder="Password" required="required" />
        <br>
        <input type="submit" id="login_btn" name="login" value="User Login" />
    </form>
</center>
</div>
<h2 style="color:#FFF; text-align:center"><?php echo @$_GET['not_authorize']; ?></h2>
<!-- end of body and html -->
</body>
</html>

<?php

	//unset/destroy any previous sessions
	unset($_SESSION["currentUser"]);
	unset($_SESSION["currentUserID"]);
	unset($_SESSION["currentCourse"]);
	unset($_SESSION["currentSession"]);


	//if login button pressed then:
	if(isset($_POST['login'])){
		
		//escapes special characters in a string for use in an SQL statement
		$user_code = mysqli_real_escape_string($con,$_POST['user_code']);
		$password = mysqli_real_escape_string($con,$_POST['password']);
		//encrypts password
		$encrypt = md5($password);
		//query to select user
		$select_user = "select * from users where user_code='$user_code' AND password='$password'";
		//run query
		$run_user = mysqli_query($con,$select_user);
		//fetch result row as numeric array
		$dbRow = mysqli_fetch_array($run_user);
		//returns rows as resutl set
		if(mysqli_num_rows($run_user)>0){
			
			//session varibles declared
			$_SESSION["currentUser"]=$user_code;
			$_SESSION["currentUserID"]=$dbRow["user_id"];
			$_SESSION["currentCourse"]=$dbRow["course_id"];
			$_SESSION["login_status"] = "true";
			//send to use_loggedin if sucessful
			header("Location:user_loggedin.php");
		} else {
			//echo incorrect login details
			echo "<script>alert('User Name or Password is incorrect')</script>";
			}
		}
?>