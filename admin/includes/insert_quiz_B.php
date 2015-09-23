<?php
//include database 
include("database.php");
//starts admin session
session_start();
//check if admin username not set.
if(!isset($_SESSION['admin_username'])){
  echo "<script>window.open('login.php?not_authorize=You are not authorized to access!','_self')</script>";
  }
else { ?>
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
    <a href="index.php"> <div class="header"></div></a>
    <!-- inculde nav bar-->
    <div class="left">
        <?php include("ADMINnavbar2.php"); ?>
    </div>

    <div class="quiz_right">
        <center>
        <!-- form for inserting quiz-->
        <form method="post" action="insert_quiz_A.php">
            <h1 id="table_header">Creating Quiz Questions For Course B: </h1>
            <br>
                <div>
                    <?php
                    //query to get lastest quiz for quiz_list table in the database
                    $get_quiz = "SELECT * FROM quiz_list ORDER BY quiz_id DESC LIMIT 1;";
                    //run query
                    $run_quiz = mysqli_query($con, $get_quiz);
                    while ($quiz_row=mysqli_fetch_array($run_quiz)){
          
                        $quiz_title=$quiz_row['quiz_title'];

                        //session for quiz_id
                        $_SESSION["quiz_id"] = $quiz_row['quiz_id'];
                        //show quiz title
                        echo $quiz_title;
                    }//end of while
                    ?>  
                </div>

            <br>
            <br>
            <!-- text area for question to be wrote-->
            <textarea rows="2" cols="80" placeholder="Enter New Quiz Questions." name="Question"></textarea><br><br>
            <!-- answer input as radio button -->
            <input type="radio" name="correct_answer" value="A"><input type="text"  placeholder="Answer A" name="answerA" ><br><br>
            <input type="radio" name="correct_answer" value="B"><input type="text"  placeholder="Answer B" name="answerB" ><br><br>
            <input type="radio" name="correct_answer" value="C"><input type="text"  placeholder="Answer C" name="answerC" ><br><br>
            <input type="radio" name="correct_answer" value="D"><input type="text"  placeholder="Answer D" name="answerD" ><br><br>
            <!-- save question and publish quiz buttons -->
            <input id= "user_btn2" type="submit" name="save_question" value="Save Question">
            <input id= "user_btn1" type="submit" name="publish_quiz" value="Publish Quiz">
        </form>
        </center>
    </div>
<!-- end of wrapper body and html-->
</div>
</body>
</html>

    <?php
    //if save_question was pressed
    if(isset($_POST['save_question'])) {
        //decalre variables
        $quiz_ses = $_SESSION["quiz_id"];
        $quiz_question=$_POST["Question"];
        $quiz_answerA=$_POST["answerA"];
        $quiz_answerB=$_POST["answerB"];
        $quiz_answerC=$_POST["answerC"];
        $quiz_answerD=$_POST["answerD"];
        //correct answer variable
        //hides error
        error_reporting(E_ALL ^ E_NOTICE);
        //correct answer local varaible
        $quiz_correct_answer_Value=$_POST["correct_answer"];
        //if else's for whats the correct answer
        if ($quiz_correct_answer_Value == 'A') { 
            $right_answer = $quiz_answerA;
        }
        elseif ($quiz_correct_answer_Value == 'B') { 
            $right_answer = $quiz_answerB;
        }
        elseif ($quiz_correct_answer_Value == 'C') { 
            $right_answer = $quiz_answerC;
        }
        elseif ($quiz_correct_answer_Value == 'D') { 
            $right_answer = $quiz_answerD;
        } else{
                echo "<script>alert('ERROR: Answer was not selected therefore question was not saved!')</script>";
            exit();
        }

        // query to insert question into quiz_question table in the database
        $insert_quiz_questions = "INSERT INTO quiz_questions (question_id, quiz_id, question, answerA, answerB, answerC, answerD, correctValue) 
            VALUES (null, '$quiz_ses','$quiz_question','$quiz_answerA','$quiz_answerB','$quiz_answerC', '$quiz_answerD', '$right_answer')";
        //run query     
        $run_quiz_questions = mysqli_query($con, $insert_quiz_questions); 
        $right_answer;
    }

    //if publish_quiz was pressed
    if(isset($_POST['publish_quiz'])) {

        //decalre variables
        $quiz_ses = $_SESSION["quiz_id"];
        $quiz_question=$_POST["Question"];
        $quiz_answerA=$_POST["answerA"];
        $quiz_answerB=$_POST["answerB"];
        $quiz_answerC=$_POST["answerC"];
        $quiz_answerD=$_POST["answerD"];
          //correct answer variable
        //hides error
        error_reporting(E_ALL ^ E_NOTICE);
        //correct answer local varaible
        $quiz_correct_answer_Value=$_POST["correct_answer"];
        //if else's for whats the correct answer
        if ($quiz_correct_answer_Value == 'A') { 
            $right_answer = $quiz_answerA;
        }
        elseif ($quiz_correct_answer_Value == 'B') { 
            $right_answer = $quiz_answerB;
        }
        elseif ($quiz_correct_answer_Value == 'C') { 
            $right_answer = $quiz_answerC;
        }
        elseif ($quiz_correct_answer_Value == 'D') { 
            $right_answer = $quiz_answerD;
        } else{
             echo "<script>alert('ERROR: Answer was not selected therefore question was not saved!')</script>";
            exit();
        }

        // query to insert question into quiz_question table in the database
        $insert_quiz_questions = "INSERT INTO quiz_questions (question_id, quiz_id, question, answerA, answerB, answerC, answerD, correctValue) 
            VALUES (null, '$quiz_ses','$quiz_question','$quiz_answerA','$quiz_answerB','$quiz_answerC', '$quiz_answerD', '$right_answer')";
        //run query      
        $run_quiz_questions = mysqli_query($con, $insert_quiz_questions); 
        $right_answer;

        //JS to tell researcher questions have been added to quiz and quiz published
        echo "<script>alert('SUCCESS: Quiz questions have been added to quiz and the quiz has been published')</script>"; 
        //sends researcher back to course A page 
        echo "<script>window.open('../courseB.php','_self')</script>";
            
    } //end of if 
} //end of if at the top
?>


