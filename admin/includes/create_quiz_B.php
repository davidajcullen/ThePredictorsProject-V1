<?php
//include database 
include("database.php");
//starts admin session
session_start();
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
<title>Create A Quiz</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="shortcut icon" type="image/ico" href="../images/faviconn.ico" />
</head>

<body>
<div class="wrapper">
    <a href="index.php"> 
        <div class="header"></div>
    </a>
    <div class="left">
        <?php include("ADMINnavbar2.php"); ?>
    </div>
    <!-- div class to html table to display form-->
    <div class="quiz_right">
        <center>
        <form action="" method="post">
            <table class = "user_table">
                <tr>
                    <td width= "70%"; colspan = "9" id= "table_header" align = "center">
                        <h2>Add new Quiz (for Course B Sessions):</h2>
                    </td>
                    <br>
                </tr>
                <br>
                <tr>
                    <td>
                        <strong> Quiz title:</strong>
                    </td>
                    <td>
                        <input type="text" name="quiz_title" class="name" size = "30" />
                    </td>
                </tr>
                <br>
                <tr>
                    <td>
                    <strong> Which session is the quiz for?</strong>
                    </td>
                    <td>
                        <select name="ses">
                            <option value = "0"> Select a Session </option>
                            <?php
                            //query to show and get sessions for course 2 
                            $get_sess = "select * from sessions where course_id='2'";
                            $run_sess = mysqli_query($con, $get_sess);
                                while ($sess_row=mysqli_fetch_array($run_sess)){
                                    $ses_id=$sess_row['session_id'];
                                    $ses_title=$sess_row['session_title'];
                                    echo "<option value='$ses_id'>$ses_title</option>";
                                } ?>
                        </select>
                </tr>
                <tr></tr>
                <tr>
                    <td><strong>  Quiz Author :</strong> </td>
                <td>
                    <input type="text" name="quiz_author" class="name" size = "30" />
                </td>
                </td>
                </tr>
            </table>
            <br>
            <!-- quiz buttons -->
            <input id="user_btn2" type="submit" name="exit_quiz" value="Exit" class="exit">
            <input id="user_btn1" type="submit" name="create_questions" value="Create Questions" class="create">
        </form>
      </center>
    </div>
<!-- end of wrapper div, body and html -->
</div>
</body>
</html>

    <?php
    //if eexit quiz pressed go back to course B
    if(isset($_POST['exit_quiz'])) {
        header("location:../courseB.php");
      }

    //if create_questions pressed set varaibles
    if(isset($_POST['create_questions'])) {
        $quiz_title=$_POST["quiz_title"];
        $quiz_author=$_POST["quiz_author"];
        $quiz_ses=$_POST['ses'];

        if(empty($_POST['ses'])){
            echo "<script>alert('ERROR: Please make sure quiz has a session')</script>";
        }else{

            //query to check session selected already has a quiz
            $session_has_quiz = "SELECT quiz_list.session_id FROM quiz_list WHERE session_id = '$quiz_ses'";
            $run_session_has_quiz = mysqli_query($con, $session_has_quiz);
            if(mysqli_num_rows($run_session_has_quiz)){
                echo "<script>alert('ERROR: Session alredy has a quiz, please delete previous quiz if you wish to make a new one!')</script>";
            }else{
                if(empty($_POST['quiz_title']) OR empty($_POST['quiz_author'])){
                //variables
                $quiz_title = "Session quiz";
                $quiz_author = "The Predictors Project";  
                }
            //insert quiz data into table
            $insert_quiz = "INSERT INTO quiz_list (quiz_title, quiz_author, session_id, course_id) 
                            VALUES ('$quiz_title','$quiz_author','$quiz_ses', '2')";
            $run_quiz = mysqli_query($con, $insert_quiz);
            //JS alert, quiz has been created! 
            echo "<script>alert('SUCCESS: Quiz Has been created!')</script>";
            //send user to insert quiz to create questions
            echo "<script>window.open('insert_quiz_B.php?quiz_id','_self')</script>";
        }//end of else
    } //end of if
} 
}//end of if at the top of the page and php
?>
