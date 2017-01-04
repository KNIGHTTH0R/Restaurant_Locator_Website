<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; //include head inc?>

		<title> Complete submit</title>
		<link href="registration_ver1.css"  rel="stylesheet" type="text/css"/>
	</head>
	<!-- In head part, 
	    Include head which use  two metas and commons.css file.
		One metas for characters, another for resizing the site when change to small size screen. 
		Also give this page a title.-->

	<body>
		<header>
			<h1>Completed!</h1>
		</header>
		<!-- header part, make the header of the page -->
		
		<?php include 'menu.inc.php';//include the menu?>
		
	  <div>
	  	<?php 
	  	if(isset($_GET['from'])){//if user complete registration
	  		if($_GET['from'] == 'registration'){
	  			echo '<h2> Welcome! You have successfuly signed up!</h2>';
	  		}elseif ($_GET['from'] == 'submission') {// if user complete submission
	  			echo '<h2> Thank you! You have successfuly posted a new object!</h2>';
	  		}
	  	}
	  	?>
	  </div>
    <?php include 'footer.inc.php'; //include footer?>
	<!-- footer part of the page. It has a link can back to top of the page -->
</body>
	
</html>