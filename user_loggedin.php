<?php session_start();
include( "includes/database.php"); 
//session varaibles
$courseID=$_SESSION[ "currentCourse"];
$currentUser=$_SESSION[ "currentUser"];
//session login time created
$_SESSION["login_status"] = true;
//your last activity was now, having logged in.
$_SESSION['last_activity'] = time(); 
 //expire time in seconds: 15minutes
$_SESSION['expire_time'] = 60*15;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf=8">
    <title> Login Success | Predictors Project </title>
    <link rel="stylesheet" href="styles/style_loggedin.css" media="all" />
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
</head>

<?php 
    //gets course id from database
	$dbQuery="SELECT * FROM `courses` WHERE `cor_id` = $courseID";
	$dbResult=mysqli_query($con, $dbQuery);
	$dbRow=mysqli_fetch_array($dbResult);
    //couse name = course title from db
	$coursename=$dbRow[ "cor_user_title"]; 
?>

<body >
    <center>
        <div class="login">
            <form method="post" action="interactive_training.php">
                <div id='logo'>
                    <img id="logo" src='images/logo.png' />
                </div>
                <br>
                <br>
                <!-- displays current users code  and course name -->
                <h2> Weclome <?php echo "$currentUser" ?>  to your course :<br><br><?php echo "$coursename" ?> </h2>
                <br>
                <br>
                <!-- button to proceed to interactive training -->
                <button id='proceed'>Proceed</button>
            </form>
        </div>
   
    </center>
</body>
</html>