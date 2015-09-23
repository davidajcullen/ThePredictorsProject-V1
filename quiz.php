<?php 
session_start();
include("includes/database.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Exercise | Predictors Project</title>
<link rel="stylesheet" href="styles/quiz_style.css" media="all" />
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />

<style type="text/css">
#quiz_title{ margin-left: 30px; margin-top: 10px; font-family: arial; color: #003b6f; }
#quiz_author { font-family: arial; margin-left: 30px; margin-top: -10px; color: #52afe2; }
#question{font-family: arial; font-size: 25px; color: #003b6f; }
#question_no{ float: left; font: 15px; margin-left: 20px; font-family: arial; margin-left: 30px; margin-top: 10px; color: #52afe2; }
#number{ color: #52afe2; font: 15px; font-family: arial;}
#possible_answers{font-family: arial; font-size: 20px; color: #52afe2; padding: 5px; }
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
        <!-- goes to logoff.php-->
        <form id="form1" name ="form 1" method = "post" action = "logoff.php">
            <input type="submit" name="logoffBtn" id = "logoffBtn" value ="Log Off" />
        </form> 
    </div>
  
    <!-- Nav start-->
    <div class = "navbar">
        <?php include("includes/ITnavbar.php"); ?>
    </div>
  
    <!-- Post area startm-->
    <div class="post_area">
        <?php 
            //gets current
            $session_id = $_GET['session_id'];
            $_SESSION['session_id'] = $session_id;
            //validation
            if(!isset($session_id)){
                exit('Session ID is missing');
            }
            $get_quiz = "SELECT * FROM `quiz_list` WHERE `session_id` = $session_id";
            $run_quiz = mysqli_query($con, $get_quiz);
            $quiz_info = mysqli_fetch_assoc($run_quiz);
        ?>
    <div>
    <h1 id = "quiz_title">Quiz: <?php echo $quiz_info["quiz_title"]; ?> </h1>
    <br>
    <p id = "quiz_author"><strong>By: <?php echo $quiz_info["quiz_author"]; ?></strong></p>
    
</div>
<div id = "content">
    <hr>
    <?php 
            
        
        if(isset($_POST['check_result'])) {
            //tracker
            $a=$_POST['a'];
      

            $quiz_id=$_SESSION['quiz_id'];
            $index=$_SESSION['index'];

        	// Below SQL query gets the correct answer from the database so it can be checked against the users answer.
        	// also determined by the $index which keeps the query in correlation with the question answered 
        	// Allowing for the correct answer to be found for the question, this used during the comparison of answers. 
            $result_query = mysqli_query($con, "SELECT `correctValue` FROM quiz_questions WHERE quiz_id = '$quiz_id' LIMIT 1 OFFSET $index");

            $cor=0;
            $incorrect=0;

            //If the user answer is equal to the database answer then the session variable for correct answers is incremented   
            //for the use in the following results page. 
            while ($correct = mysqli_fetch_array($result_query)) { 
                
                if ($_POST['answer'] == $correct[0]) { 
                    $_SESSION['right_answers']+=1; 	   
                }

                //If the user answer is not equal to the database answer then 									   		
                //the session variable for the incorrect answers is incremented 
                //for the use in the following results page.
                if ($_POST['answer'] != $correct[0]) { 
                    $_SESSION['wrong_answers']+=1;     
                }     								  

            }

            //Once the last question has been successfully checked this changes the page to the results page were it carries the session variable such a
            //correct answers, incorrect answers, quiz id, number of questions answered. 
            if($a==$_SESSION['no_of_questions']){
                header("Location: quiz_result.php"); 
            }                                       
        }                                            

        // same as the above but is used up until the last questions.
        if(isset($_POST['check_quiz'])) { 
        								  
            $a=$_POST['a'];				   
      

            $quiz_id=$_SESSION['quiz_id'];
            $index=$_SESSION['index'];

        
            $result_query = mysqli_query($con,"SELECT `correctValue` FROM quiz_questions WHERE quiz_id = '$quiz_id' LIMIT 1 OFFSET $index");

            $cor=0;
            $incorrect=0;

        
            while ($correct = mysqli_fetch_array($result_query)){ 

                if (empty($_POST['answer']) || $_POST['answer'] != $correct[0]) { 
                    $_SESSION['wrong_answers']+=1;   
                } elseif ($_POST['answer'] == $correct[0]) {  
                    $_SESSION['right_answers']+=1;
                }     
                } 
        } 
        // Sets/Resets below variables back to default zero.
        if(!isset($a)){  
      
            $a=0;
            $_SESSION['right_answers']=0;
            $_SESSION['wrong_answers']=0;
        
        }

        $quiz_id = $_GET['quiz_id'];
        $_SESSION['index']=$a;

        $question_number = $a+1; 
          
        $_SESSION['quiz_id']=$quiz_id;

        //query is run to determine how many questions are contained within the database. 
        $no_of_questions_query = mysqli_query($con, "SELECT COUNT(quiz_id) AS no_of_questions FROM quiz_questions WHERE quiz_id ='$quiz_id'");
        $no_of_questions_result = mysqli_fetch_object($no_of_questions_query);

        //Session Variable to maintain number of questions each time a new question is being generated. 
        $_SESSION['no_of_questions']=$no_of_questions_result->no_of_questions;


        $no_quiz_questions=$_SESSION['no_of_questions'];

        // Query in used to generate each quiz question. Note that this query gets one question at a time
        //and is offset using the $a variable to increment/access the next quetion within the database.
        $query = mysqli_query($con, "SELECT * FROM quiz_questions WHERE quiz_id = '$quiz_id' LIMIT 1 OFFSET $a");
        
        // while loop allows the questions to be displayed one at a time 
        while ($result = mysqli_fetch_array($query)) { ?>
          
            <form id="question_no" ><div class="left"></div>  
                <div class="right">No. of questions: <?php  echo $no_of_questions_result->no_of_questions; ?> </div> 
            </form> 
            <br><br><br> 
          
            <form method="post" action="" class="form complete">

                <table>
                    <td>
                        <td width = "50" id="question"><?php echo $result['question'] . "<br>"; ?></td> <!--Question Outputted-->
                    </td>

                    <tr height = "10"></tr>

                    <!-- This provides the users input and and will then be used when checking if the answer is correct.-->
                    <td id= "number" width = "20" class="number"><?php echo $question_number ?>)</td> 
                    <td id = "possible_answers" height = "100"width = "700">
                        <input type="radio" name="answer" value="<?php echo $result['answerA'] ?>"> <?php echo $result['answerA']; ?> <br>
                        <input type="radio" name="answer" value="<?php echo $result['answerB'] ?>"> <?php echo $result['answerB']; ?> <br>
                        <input type="radio" name="answer" value="<?php echo $result['answerC'] ?>"> <?php echo $result['answerC']; ?> <br>
                        <input type="radio" name="answer" value="<?php echo $result['answerD'] ?>"> <?php echo $result['answerD']; ?> <br><br>
                    </td>
                </table>
      
                <?php
                    //Session variable used to keep track of the question number throughout the quiz. 
                  $_SESSION['question_number']=$question_number; 
                }
                $a=$a+1; //Increments $a by one each time
                ?>  


                <!--Buttons to submit answers to questions. There are two buttons each determined by the number of questions answered
                For example if the total number of questions is 5 but only 4 are answered the $a variable contains the number 4.
                Therefore (IF $a < 5 the button visible contains the text Next Question)
                Therefore (IF $a = 5 the button visible contains the text Quiz Results as there are no other questions to answer.) -->
                <input type="submit" name="exitQuiz" value="Exit Quiz" id="button1"> 
                <!--variable $a is used with a type hidden so this increments accordly each a question a answer is submitted-->
                <?php
                    if ($question_number<$_SESSION['no_of_questions']) { ?>
                        <input type="submit" name="check_quiz" value="Next Question" id="button1">
                        <input type="hidden" value="<?php echo $a ?>" name="a">
                    <?php } ?>
                    <?php 
                    if ($question_number==$_SESSION['no_of_questions']) { ?>
                        <input type="submit" name="check_result" value="Quiz Result" id="button1">
                        <input type="hidden" value="<?php echo $a ?>" name="a">
                <?php } ?> <!-- end of if-->
            </form> <!-- end of form -->
        </div> <!-- end of div -->
    </div>
<!-- end of body and html-->
</body>
</html>