<!--database inclusion-->
<?php  include("includes/database.php"); ?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Interactive Training</title>
<link rel="stylesheet" href="../styles/style.css" type="text/css" />
<style >
.course_SubHead{color: #304674;}
.row{margin-right: 50px; margin-left: 50px; font-size: 20px;}
</style>
</head>

<body>
   <?php
   //session variables depending on the current user ID  which gives the current course 
   //(course they have been assigned)
   $courseID = $_SESSION["currentCourse"];
   $currentUser = $_SESSION['currentUserID'];
   $get_session = "SELECT * FROM `sessions` WHERE `course_id` = $courseID";
   $run_session = mysqli_query($con, $get_session);

   //make new arrat to hold data
   $c_sessions_array = array();
   //fetches result row which match query
   //row sessions an associative array
   while ($row_sessions = mysqli_fetch_assoc($run_session)) {
      $c_sessions_array[] = $row_sessions;
   }
   //c_sessions_array is the associative array being looped
   //as the loop runs it selects the key value pair from the array storing the key as $key and vlaue as row data
   foreach ($c_sessions_array as $key => $value) {
      $session_id = $value['session_id'];
      $session_title = $value['session_title'];
      $session_date = $value['session_date'];
      $session_author = $value['session_author'];
      $session_image = $value['session_image'];
      $session_info = $value['session_info'];
      //close php for html
      ?>
   <!-- html code in forloop, interchangably
   Displays/echos the sessions and its session variables from the 
   foreach loop according to current course ID and session ID-->
   <div class="row" >
      <div class="session_info1">
         <text id='session_title1'><?php  echo "$session_title"  ?> </br></text>
         <text> <span><i>Created by</i> <b><?php  echo"$session_author"  ?></b></span> </text>
         <!-- displays the date the session was created -->
         <text id = "session_date"><?php  echo"$session_date"  ?> </text>
         </br>
         <br>
         <!-- echos session info -->
         <?php  echo"$session_info"  ?>
      </div>
      <div class="col">
         <table>
            <tr >
               <td id= 'title1' width='100%' class='course_subHead'>Exercises Completed &nbsp; </td>
               <td width='100%' class='course_SubHead'> <span>0</span>/5</td>
            </tr>
            <tr height='25px'>
               <td id= 'title1' width='0%' class='course_subHead'>Quiz score </td>
               <td width='0%' class='course_SubHead'><span>0</span>/0</td>
            </tr>
            <tr height='25px'>
               <td id= 'title1' width='0%' class='course_subHead'>Complete</td>
               <td width='0%' class='course_SubHead'> 0%</td>
            </tr>
         </table>
      </div>
      <!-- div for displaying the $session_image saved at the content_images directory -->
      <div class="session_img">
         <td> 
            <img id='img' src="admin/content_images/<?php  echo $session_image; ?>" alt="Session" width='130' height='130'/>
         </td>
      </div>

      <?php
         //stored session query from user_current_session where user_id = $current user 
         $get_stored_session_q = "SELECT * FROM `user_current_session` WHERE `user_id` = $currentUser";
         $get_stored_session = mysqli_query($con, $get_stored_session_q);
         
         //tracker
         $a = 0;

         //takes data from query and brings the user to the last saved session
         while ($row = mysqli_fetch_assoc($get_stored_session)) {
            if($row['session_id'] == $session_id){
            $a=1;
         ?>
         <!-- passes session_id, current session_number and session saved through the url and brings user
         to last exercise saved -->
         <a id='button' href="exercise.php?session_id=<?php echo $row['session_id']; ?>&current_exercise_number=<?php echo $row['session_saved'];?>">Proceed to Session </a>
         <?php break;
         }
         }
         //if tracker =0 then proceed to first  exercise of session
         if($a == 0){ ?>
         <a id='button' href="exercise.php?session_id=<?php echo $session_id; ?>&current_exercise_number=0">Proceed to Session </a>
      <?php } ?>
      <div style="clear:both"></div>
   </div>
   <br/>

   <!-- end of for each -->
   <?php  } ?>
   <!-- for loop JS function which hides all images which have error/no source so user won't see broken icon -->
   <script type="text/javascript">
   (function() {
       var images_no_src = document.images;
       for (var i = 0; i < images_no_src.length; i++) {
           images_no_src[i].onerror = function() {
               this.style.visibility = "hidden"; // Other elements aren't affected. 
           }//end 2nd function
       }//end of for
   })();// end of 1st function
   </script>


<!-- end of body and html -->
</body>
</html>