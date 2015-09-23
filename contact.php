<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Contact | Predictors Project</title>
<link rel="stylesheet" href="styles/style_contact.css" media="all" />
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
<style type="text/css">
.footer_area{vertical-align:middle; font-family: arial;text-align: center; width:1000px; height:50px; background:#52afe2; color:#FFF; clear:both;padding-top: 15px;}
</style>
</head>
<body>

<!-- Main Container start-->
<div class="container">

	<!-- Head start-->
	<div class = "head">
		<img id ="logo" src ='images/logo.png' />
		<img id = "banner" src ='images/banner.png' />	
	</div>
	

	<!-- Nav start-->
	<div class = "navbar">
		<?php include("includes/navbar.php"); ?>
	</div>
	<!-- Nav end-->
	
    <div id="contact">
		<h1>Get in touch with us!</h1>
		<h4 class= "contact_text1">We are happy to answer any questions you may have. 
		<br> Just send us a message by filling in the form below.</h4>

		<!--if contact submit button it pressed-->
		<?php
		if (isset($_POST['contact_submit'])) {
			
			//set variables
			$name=$_REQUEST['name']; 
		    $email=$_REQUEST['email']; 
		    $message=$_REQUEST['message'];

		    //validation
		    if (($name=="")||($email=="")||($message=="")) { 
		        echo "All fields are required, please fill <a href=\"\">the form</a> again."; 
		    	}else{         
			        $from="From: $name<$email>\r\nReturn-path: $email"; 
			        $subject="Message sent from Predictors Project"; 
			        mail("dcullen620@qub.ac.uk", $subject, $message, $from);
			        //echo 
					echo "<script>alert('Message Has been sent!')</script>";
					echo "<script>window.open('contact.php','_self')</script>";
       			}
			} else { ?>
		<!-- Send an message via an email form code-->
		<table id = "contact_form">
			<form method="post" action="contact.php" id="contact-form">
				<tr>
					<td><label class= "contact_text" for="name">Your name:</label></td>
					<td class = "form_input"><input type="text" id="name" name="name"></td>
				</tr>
				<tr>
					<td><label class= "contact_text" for="email">Your email:</label></td>
					<td class = "form_input"><input type="email" id="email" name="email"></td>
				</tr>
				<tr>
					<td><label class= "contact_text" for="message">Your message:</label></td>
					<td class = "form_input"><textarea id="message" name="message" rows="10" cols="30"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" id = "button1" name="contact_submit" value="Send Message"></td>
				</tr>
			</form>
		</table>
		<?php } ?>
<!-- HTML code for the Researchers contact information-->
<table id= "contact_content">
	<tr id ="contact_info1">
		<td>
			<h3 class= "contact_text">Dr.Kate Woodcock - School of Psychology - Lecturer</h3>
			<br>
			<h4 class= "contact_text3">Email:&ensp;&ensp;k.woodcock@qub.ac.uk</h4>
			<h4 class= "contact_text3">Telephone:&ensp;&ensp;028 90974886</h4>
			<h4 class= "contact_text3">Rep of Ireland:&ensp;&ensp;004 428 90974623</h4>
			<br>
			<img id = "image" src ='images/dr.kate.woodcock.jpeg' alt="Contact Info" style="width:150px;height:150px;" />
			<br><br>
		</td>
	</tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr id ="contact_info1">
		<td>
			<h3 class= "contact_text">Dr.Clare McGeady - School of Psychology - Lecturer</h3>
			<br>
			<h4 class= "contact_text3">Email:&ensp;&ensp;c.mcgeady@qub.ac.uk</h4>
			<h4 class= "contact_text3">Telephone:&ensp;&ensp;028 90974623</h4>
			<h4 class= "contact_text3">Rep of Ireland:&ensp;&ensp;004 428 90974623</h4>
			<br>
			<img id ="image" src ='images/dr.clare.mcgeady.jpg' alt="Contact Info" style="width:140px;height:180px;" />
		</td>
	</tr>
	</table>
	<!-- Java script code no my own, source: http://maps-generator.com/ -->
 	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false">
	</script>
	<div id= "map" style="overflow:hidden;height:350px;width:400px;">
		<div id="gmap_canvas" style="height:350px;width:400px;"></div>
			<style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
				<a class="google-map-code" href="http://www.map-embed.com" id="get-map-data">map-embed.com</a>
		</div>
			<script type="text/javascript"> 
				function init_map(){var myOptions = {zoom:14,center:new google.maps.LatLng(54.581473985149316,-5.935851844458057),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), 
				myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(54.581473985149316, -5.935851844458057)});infowindow = new google.maps.InfoWindow({content:"<b>David Keir Building</b><br/>Queen's University Belfast<br/>BT7 1NN "
				});google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);
			</script>
 		</div>
	<!-- Post area end-->
	</div>
	<center>
	<div class="footer_area">
		<h3>&copy; All Rights Reserved 2015 - PredictorsProject</h3>
	</div><!--Footer ends-->
	</center>

<!-- end of body and html-->   
</body>
</html>