<?php
	session_start();//start session
	// if not login, redirect to login page
	if (!isset($_SESSION['isLoggedIn'])){
				header("Location: login.php?from=submission");
			}
	?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; //include head?>
		<title> Post your Object</title>
		<link href="submission.css" rel="stylesheet" type="text/css"/>
		<script src="location_and_map_3.js"></script>
	</head>
	<!-- In head part, 
		Include head which use  two metas and commons.css file.
		One metas for characters, another for resizing the site when change to small size screen. 
		submission.css file to control style for this page
		Insert location_and_map_3.js for using geolocation API.
		Also give this page a title.-->
	<body>
		<header>
			<h1>Post Restaurant</h1>
		</header>

		<div class = "menu">
				<ul class="header_list" >
                  <li><a href="#home"><strong>Home</strong></a></li>
                  <li><a href="search.php"><strong>Search</strong></a></li>
                  <li><a class="current_page" href="submission.php"><strong>Post</strong></a></li>
                  <li><a href="#contact"><strong>Contact us</strong></a></li>
                </ul>
		</div>
		<!-- This part will create a navigation bar. 
			 There are four links here in a list. One to website home page, which is a sample link.
			 The second one connects with search.php page.
			 The third one connet to submission.php which is the current page. 
			 Hence, give it class to identify the current page in navigation bar.
			 The last link is contact us, which is a sample link. -->
		
		<div class="post_object">
		<?php 
		echo '<form action="submission_process.php?user='.$_SESSION['user_name'].'" method="POST" enctype="multipart/form-data">';
		//form to submit the submission to submission_proces.php , which contain the user name information
		// enctype is used for file upload
		?>
		
				  <label for="restaurant_name">Restaurant Name:</label><br/>
				  <input type ="text" id="restaurant_name" class= "type_input" name="Restaurant_Name" placeholder="Restaurant Name" <?php if(isset($errors['Restaurant_Name'])){echo 'style="border-color:red"';} if(isset($_POST['Restaurant_Name'])) {echo 'value="'.htmlspecialchars($_POST['Restaurant_Name']).'"';} ?> required /><br/>
				  <!--  input field for rrestaurant name
				  has html validation, php make the border red when error occur
				  php also save the value when validation is fail
					-->
				 <?php 
				 if(isset($errors['Restaurant_Name'])){
				 	echo '<span style="color:red">';// when error occur, show error message
				 	echo $errors['Restaurant_Name'];
				 	echo '</span><br>';
				 } 
				 ?>
				  <label for="location">Location:</label><br/>
				  <input type ="text" id="setlocation" class= "type_input" name="Restaurant_Location" placeholder="Location Ex 43.2573166,-79.929775" pattern="^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$" <?php if(isset($errors['Restaurant_Location'])){echo 'style="border-color:red"';}if(isset($_POST['Restaurant_Location'])) {echo 'value="'.htmlspecialchars($_POST['Restaurant_Location']).'"';}  ?> required /><br/>
				   <!--  input field for rrestaurant locaiton
				   it html pattern check
				  has html validation, php make the border red when error occur
				  php also save the value when validation is fail
					-->
				  <?php 
				 if(isset($errors['Restaurant_Location'])){
				 	echo '<span style="color:red">';// when error occur, show error message
				 	echo $errors['Restaurant_Location'];
				 	echo '</span><br>';
				 } 
				 ?>
				  <input type="button" id="update_location" class="button" value ="Current Location" onclick="updateLocation()">
				  <br/><!-- There is a button can quickly get user's current location by geolocation api and upload into location input field.
							Easy for user to input location value when they are insdie the restaurant.-->
				  <label for="address">Address:</label><br/>
				  <input type ="text" id="address" class= "type_input" name="Restaurant_Address" placeholder="Restaurant_Address (Optional)" <?php if(isset($errors['Restaurant_Address'])){echo 'style="border-color:red"';}if(isset($_POST['Restaurant_Address'])) {echo 'value="'.htmlspecialchars($_POST['Restaurant_Address']).'"';}  ?> /><br/>
				   <!--  input field for rrestaurant address
				  php make the border red when error occur
				  php also save the value when validation is fail
					-->
				   <?php 
				 if(isset($errors['Restaurant_Address'])){
				 	echo '<span style="color:red">';// error message
				 	echo $errors['Restaurant_Address'];
				 	echo '</span><br>';
				 } 
				 ?>
				  <!-- Use text type input to let user enter restaurant name, latitude-longitude location, and address.
					   Each havetheir own label, class,id value. They also hold information by placeholder.
					   Restaurant_Name and location are required, they can't be empty-->
					   
				  Type of the restaurant:<br/>
				  <?php include 'type_selection.inc.php'; //include the type selection check box?>
				  <span>(Optional, can choose one or more)</span>
				  <br/>
				  <!-- Use checkbox type input to let user select one or more type for the restaurant.
					   What is the restaurant style.
					   Is the restaurant cheap or expensive.
					   Each one has own label, class, id, value. -->
				  <label for ="description">Description:</label><br/>
				  <textarea id="description" placeholder="Describe the restaurant" required name="Description" <?php if(isset($errors['Description'])){echo 'style="border-color:red"';}?>><?php if(isset($_POST['Description'])) {echo $_POST["Description"];}?></textarea><br/>
				   <!--  input field for rrestaurant name
				   php make the border red when error occur
				  save the value when error occur
					-->
				   <?php 
				 if(isset($errors['Description'])){
				 	echo '<span style="color:red">';// error message
				 	echo $errors['Description'];
				 	echo '</span><br>';
				 } 
				 ?>
				  <!-- Use textarea to let user enter sentences or paragraphs they want to describe the restaurant.
					   Give specifice label and leave message to user by placeholder
					   It require input, cannot be empty-->
				  <label for ="load_image">Upload one or more images:</label><br/><span>(Optional)</span>
				  <input type="file" id="load_image" class="img_files" name="myImage" accept="image/*" multiple><br/>
				    <?php 
				 if(isset($errors['myImage'])){
				 	echo '<span style="color:red">';// error message
				 	echo $errors['myImage'];
				 	echo '</span><br>';
				 } 
				 ?>
				  <!-- use file type input to let user upload image to website.
					   Only accept image files includes .png .jpg etc.
					   Allow user to upload mutiple files at same time.-->
				  <input type="submit" class ="button" value="Submit" name="submitPost">
				  <!-- submit button with submit string on the button.-->
			</form>
		</div>
		
		<?php include 'footer.inc.php'; ?>
		<!-- footer part of the page. It has a link can back to top of the page -->
		
	</body>
</html>