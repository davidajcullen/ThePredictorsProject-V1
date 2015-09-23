<?php session_start();
    //include database
    include("includes/database.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Exercise | Predictors Project</title>
<link rel="stylesheet" href="styles/style.css" media="all" />
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />

<style type="text/css">
#uc{margin-left: 10px; }
#quiz_title1{ font-size: 30px; margin-left: 30px; margin-top: 10px; font-family: arial; font-weight: bold; color: #003b6f; }
#question_no{ float: left; font: 15px; margin-left: 20px; font-family: arial; margin-left: 30px; margin-top: 10px; color: #52afe2; }
.result{ margin-left: 30px; font-family: arial; font-size: 20px;color: #003b6f; }
table, td, tr{ background-color: #F0F5F5; margin-left: 100px; }
</style>
</head>

<body>
<!-- Main Container start-->
<div class="container">
  <!-- Head start-->
    <div class = "head">
        <img id ="logo" src ='images/logo.png' />
        <img id = "banner" src ='images/banner.png' />
        <form id="form1" name ="form 1" method = "post" action = "logoff.php">
            <input type="submit" name="logoffBtn" id = "logoffBtn" value ="Log Off" />
        </form>  
    </div>
      
    <!-- Nav start-->
    <div class = "navbar">
        <?php include("includes/ITnavbar.php"); ?>
    </div>
    <!-- Nav end-->
      
    <!-- Post area startm-->
    <div class="post_area">
        <hr>
        <div id="quiz_title1">Quiz Result:</div> 
        <hr><br>

        <?php
        //declare session variables
        $correct = $_SESSION['right_answers'];
        $questions = $_SESSION['question_number'];
        //work out percent
        $percent = $correct/$questions;
        $percent_friendly = number_format( $percent * 100, 0 ) . '%';
        //percent in readable form
        $_SESSION['percent']=$percent_friendly;
        ?>
        <!-- displaying results via session variables -->
        <div class="result">Quiz ID:             <?php echo $_SESSION['quiz_id'];?></div><br>
        <div class="result">Questions Answered:  <?php echo $_SESSION['question_number'];?></div><br>
        <div class="result">Correct Answers:     <?php echo $_SESSION['right_answers'];?></div><br>
        <div class="result">Incorrect Answers:   <?php echo $_SESSION['wrong_answers'];?></div><br>
        <div class="result">Result Percentage:   <?php echo $_SESSION['percent'];?></div>

        <hr>
        
        <!-- from for user text input and save quiz button-->
        <form method="post" action="">
            <textarea id= "uc" name = "user_comment" rows="15" cols="50" placeholder="Please give a brief personal opinion on the session you just completed"></textarea>
            <br>
            <br>
            <input id ="button1" type="submit" name="home" value="Home">
            <input id ="button1" type="submit" name="save_quiz" value="Save Quiz">
        </form>
    </div>

</body>
</html> 

<?php 
    //if save button is pressed add session id, user comment, percent and current user to quiz_results table
    if(isset($_POST['save_quiz'])) {
        //declare variables
        $currentUserID = $_SESSION['currentUserID'];
        $session_id = $_SESSION['session_id'];
        $percent_friendly = $_SESSION['percent'];
        $user_comment = $_POST['user_comment'];
        //results query
        $insert_results= "insert into `quiz_results`(user_id, session_id, score, user_comment) 
                        values ('$currentUserID','$session_id','$percent_friendly', '$user_comment')";
        //run query
        $run_results = mysqli_query($con, $insert_results); 
        //JS alert for user
        echo "<script>alert('Quiz results have been recorded!')</script>";
    } ?>
