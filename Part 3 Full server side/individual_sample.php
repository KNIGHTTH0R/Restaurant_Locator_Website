<?php
	session_start(); // start session
	// if user not loged, they are not allowed to write comment or rate
	require("search.inc.php");// get the search include file to read infomation from database
	require ('update.inc.php'); // get update functions to update or insert value into database
	?>
<?php

	$id=$_GET['id'];// get the id of this page
	if (isset($_POST['leaveComment'])){//if user submit comment
		updatecomment($id, $_SESSION['user_name'], $_POST['user_reviews']);
		//update comments
		header ("Location: individual_sample.php?id=$id");
		// redirect to same page and clean post
	}
	if (isset($_POST['rating'])){// if submit rate
		$ratecheck =searchRate($id, $_SESSION['user_name']);
		// check if the rating database
		if($ratecheck->rowCount()==0){//if rate of user towards the object doesn't exist
			createRate($id, $_SESSION['user_name']); // create a one 
		}
		updaterates($id, $_POST['rating']); // update rate value to restaurants database
		modifyratingrate($id, $_SESSION['user_name'], $_POST['rating']);// update to rating database, this user has rated this object
		header ("Location: individual_sample.php?id=$id");// redirect to this page, clear all posts
	}
?>
<?php
	if (isset($_GET['id'])){
		$RestaurantID = $_GET['id'];
		// accroding the id, determine which object should be open
		$result=individual_page($RestaurantID);
		// read from restaurant database
		foreach($result as $key){
			$GLOBALS['restaurant_details'] = $key;
			// store a glbal value about this object
		}
		$location = $GLOBALS['restaurant_details']['Location'];
		//get the location
		echo '<script>var locationFromPhp = ' . json_encode($location) . ';</script>';
		// store the lcoation into Javascript for the live map 
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; ?>
		<title> Individual Result</title>
		<link href="individual_result_1.css"  rel="stylesheet" type="text/css"/>
		<script src="p3_individual_mapping.js"></script>
	</head>
	<!-- In head part, 
	    Include head which use  two metas and commons.css file.
		One metas for characters, another for resizing the site when change to small size screen. 
		Insert individual_result.css file to control style for this page.
		Insert the individual map for the sample by p3_individual_mapping.js 
		Also give this page a title.-->
	<body>
		<header>
			<h1>Search Your Restaurant</h1>
			<div class ="log">
			<?php
				if(!isset($_SESSION['isLoggedIn'])){// if user not log in, have two links to let user login or sign up
					echo '<a href="login.php?from=individual&id='.$_GET['id'].'"><strong>Log in</strong></a>'; 
					// go to login page, carry id information, after login can automaticlly back to this page
					echo '/';
					echo '<a href="registration.php"><strong>Sign Up</strong></a>';
					// go to sign up pate
				}else{
					echo '<span>Welcome,'.$_SESSION['user_name'].'. </span>'; // after login, welcome the user
					echo '<a href="logout.php?from=individual&id='.$_GET['id'].'"><strong>Logout</strong></a>';
					//go to logout page, carry id information, after logout can back this page
				}
			?>
			</div>
			<!-- Create the header for this page, Post Restaurant.
			 Also create log in and sign up links, while login is a sample link and sign up links to the registration.php page. -->
		</header>
		<?php include 'menu.inc.php'; //include the navigation menu into the page?>
		
		<div class="individual_result">
			<div id ="map">
				<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg2biupOk_V13n7RR1guoiWfUfDuK79to&callback=initMap">
				</script>
				<!-- insert a living map which show the sample's location -->
			</div>
			<!-- insert information of object into page-->
			<div class="restaurant">
			<?php 
				if (isset($_GET['id'])){// find the id of the object
					echo '<h2>'.$GLOBALS['restaurant_details']['RestaurantName'].' Restaurant </h2>';// get the restaurant name
					echo '<h3 class = "post_user">Post by '.$GLOBALS['restaurant_details']['ownername'].'</h3>'; // display the name of user who post the object
					echo '<p class = "description">'.$GLOBALS['restaurant_details']['Description'].'</p>'; // post the descriptions of this restaurant
					echo '<div class="center_picture">'; // contain of the picture
					if(isset($GLOBALS['restaurant_details']['PicturePath']) && !empty($GLOBALS['restaurant_details']['PicturePath'])){ 
						// if user originally posted a picture
						echo '<img src="'.$GLOBALS['restaurant_details']['PicturePath'].'"alt ="picture of '.$GLOBALS['restaurant_details']['RestaurantName'].'">';
					}
					// display the image, find the S3 bucket path from restaurant database
					echo '</div>';
					echo '<p>Likes:'.$GLOBALS['restaurant_details']['rating'].'</p>';// show the rates of this object
				}else{
					echo '<h2>Nothing here</h2>';// if the object not exist
				}
			?>
					<!-- rating system 
					post to this page -->
					<form method="POST" action="" class = "like_rating">
						 
					<?php
						if(!isset($_SESSION['isLoggedIn'])){//only logged user can click the rating button
							echo '<input type="submit" name ="rating" class ="button" value="Like" disabled>';
							echo '<input type="submit" name ="rating" class ="button" value="Dislike" disabled>';
						}else{ // after login
								$ratecheck =searchRate($_GET['id'], $_SESSION['user_name']);// define whether this user rate this object before
								if($ratecheck->rowCount()>0){// rated before
									foreach ($ratecheck as $key) {
										$ratevalue =$key['rate'];
									}
									// each user for one object can only have +1/0/-1.
									// not allowed to infinitely rate the object
									if ($ratevalue ==1){// if clicked like before, can only dislkie give a -1
										echo '<input type="submit" name ="rating" class ="button" value="Like" disabled>';
										echo '<input type="submit" name ="rating" class ="button" value="Dislike" >';
									}elseif($ratevalue ==(-1)){// if clicked dislike before, only can give a +1
										echo '<input type="submit" name ="rating" class ="button" value="Like" >';
										echo '<input type="submit" name ="rating" class ="button" value="Dislike" disabled>';
									}else{// when the user's rate for this object is 0, can click both like or dislike
										echo '<input type="submit" name ="rating" class ="button" value="Like" >';
										echo '<input type="submit" name ="rating" class ="button" value="Dislike" >';
									}
								}else{// never rate before, can click like or dislike
								echo '<input type="submit" name ="rating" class ="button" value="Like" >';
								echo '<input type="submit" name ="rating" class ="button" value="Dislike" >';
							}
						}
					?>
					</form>
			</div>
			
			<div class ="comment">
			<!-- area let user to leave own review comment 
			     User need to log in first, then they can leave valid review-->
			     <br>
			     <?php
			     	if(!isset($_SESSION['isLoggedIn'])){// check if logged
			     		echo '<span> Please </span>';// ask user to login first
			     		echo '<a href="login.php?from=individual&id='.$_GET['id'].'"><strong>login</strong></a>';// direct to login page with id information
			     		echo '<span> first before write comment </span>';
					}
			     ?>
				<form method="POST" action=""> 
				<!-- submit reviews
				if not login first, can't write reviews 
				post to this page-->
				<label for="give_comment">Comment:</label><br/>
				<?php
					if(!isset($_SESSION['isLoggedIn'])){// check the log
			     		echo '<textarea disabled name="user_reviews" id="give_comment" placeholder="Login and leave your comment."></textarea>';
			     		// disabled textarea
			     		echo '<br>';
			     		echo '<input type="submit" class ="button" value="Submit" disabled>';
			     		// disabled button
					}else{//after login
						echo '<textarea name="user_reviews" id="give_comment" placeholder="Leave your comment."></textarea>';
						// write comment into textarea
			     		echo '<br>';
			     		echo '<input type="submit" class ="button" name="leaveComment" value="Submit">';
			     		//can submit
					}
				?>
				</form>
			</div>

			<div class ="user_review">
			<!-- area to show the previous reviews of other users -->
			<?php
				$result = individual_reviews( $_GET['id']);// read the reviews database
				if ($result->rowCount()>0){// if there exists reviews for this object
					foreach($result as $key){
					echo '<div class ="review">';// create review container
					echo '<h3 class = "review_user"> <label for="review1">Posted by '.$key['name']. '</label></h3>';// display owner of the review
					echo '<textarea  id="review1" readonly>'.$key['comments'].'</textarea>';// display the content of review
					echo '</div>';
					}
				}
			?>
			</div>
			
		</div>
	 <?php include 'footer.inc.php'; // include the foot?>
	 <!-- footer part of the page. It has a link can back to top of the page -->
	</body>
</html>