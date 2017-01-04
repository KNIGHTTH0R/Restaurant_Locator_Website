<?php
	session_start();
	//start the session
	?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; ?>
		<title> Search Restaurant Around You </title>
		<link href="search_ver1.css"  rel="stylesheet" type="text/css"/>
	</head>
	
	<!-- In head part.
		Include head which use  two metas and commons.css file.
		One metas for characters, another for resizing the site when change to small size screen.  
		search_ver1.css file to control style for this page.
		Also give this page a title.-->
	<body>
		<header>
			<h1>Search Your Restaurant</h1>
			<div class ="log">
			<?php
			// if user not login, let them see login and sign up
			if(!isset($_SESSION['isLoggedIn'])){
				echo '<a href="login.php?from=search"><strong>Log in</strong></a>';
				echo '/';
				echo '<a href="registration.php"><strong>Sign Up</strong></a>';
			}else{// after login, show welcome and logout
				echo '<span>Welcome,'.$_SESSION['user_name'].'. </span>';
				echo '<a href="logout.php?from=search"><Strong>Logout</strong></a>';
			}
			?>
			</div>
		</header>
		
		<div class = "menu">
			<ul class="header_list" >
			  <li><a href="#home"><strong>Home</strong></a></li>
			  <li><a class ="current_page" href="search.php"><strong>Search</strong></a></li>
			  <li><a href="submission.php"><strong>Post</strong></a></li>
			  <li><a href="#contact"><strong>Contact us</strong></a></li>
			</ul>
		</div>
		<!-- This part will create a navigation bar. 
			 There are four links here in a list. One to website home page, which is a sample link.
			 The second one connects with search.php page, which is the current page.
			 Give it class to identify the current page in navigation bar.
			 The third one connet to submission.php.
			 The last link is contact us, which is a sample link. -->
		<div class="search_structure">
			<form action="results_sample.php" method="POST">
			<!-- Start to insert the html form elements
				when click submit button, transfer to results_sample.php page.-->
				<div class = "search_by_name">
					<label for="name_search">Enter the restaurant name:</label>
					<br/>
					<input type ="search" id="name_search" name="searchbyname" placeholder ="Search the restaurant">
				</div>
				<!-- Use the search type input to create a search bar which allows user to enter typing input.
					 Search the restaurant by seaching the name.
					 Leave message to user by placeholder.
					 Create the label and give it an id.-->
				<div class = "search_by_type">
					<label for="type_search">Select the type of restaurant:</label>
					<br/>
					<select id="type_search" name="searchbytype">
						<option>choose one</option>
						<?php
							$types = array("FastFood","Western","Chinese","Buffet","Expensive","Cheap");// insert all keyword of type selection
							foreach ($types as $value) {
								echo '<option value="'.$value.'">'.$value.'</option>';// create the selecte dynamicly
							}
						?>
					<!--
					php to dynamic create select menu
					<option value="FastFood">FastFood</option>
						<option value="Western">Western</option>
						<option value ="Chinese">Chinese</option>
						<option value ="Buffet">Buffet</option>
						<option value ="Expensive">Expensive</option>
						<option value ="Cheap">Cheap</option> -->
					</select>
				</div>
				<!-- use select and option to create a dropdown to let user select the type of restaurant want to seach.
				Give it a label and id -->
				<input type ="submit" class ="button" value = "Search By Location" name="aroundUser"> 
				<br/>
				<input type ="submit" class ="button" value="Search" name="notAround">
				<!-- submit buttons user can choose search restaurant around current location ,or search by general and set the center the first result in list -->
			</form>
	
		<?php include 'footer.inc.php'; //include footer?>
		<!-- footer part of the page. It has a link can back to top of the page -->
	</body>
</html>