<?php 
if (isset($_POST['login'])){// check login, if logged
	$useremail = $_POST['useremail']; // get the email information
	$password =	$_POST['password'];// get password information
	require ("search.inc.php");// include the search include to read database
	$result = LogincheckPassword($useremail, $password);// read the user database
	if($result->rowCount()>0){// if the email and password match with a existed user
		session_start(); // start the session
		$_SESSION['isLoggedIn']=true; // login is true and store into session
		foreach ($result as $key) {
			$_SESSION['user_name']=$key['Username'];// also record the user name
		}
		if (isset($_GET['from'])){// identify the previous page
			if($_GET['from']=="search"){// back to search page
				header("Location: search.php");
			}elseif($_GET['from']=="results"){// back to result page, with the searching key words,show same result
				$searchname=$_GET['searchname'];
				$searchtype=$_GET['searchtype'];
				$haveUserlocation=$_GET['haveUserLocation'];
				header("Location: results_sample.php?searchname=$searchname&searchtype=$searchtype&haveUserLocation=$haveUserlocation");
			}elseif($_GET['from']=="individual"){// back to individual page with the id information, show same result
				$idnumber = $_GET['id'];
				header("Location: individual_sample.php?id=$idnumber");
			}elseif($_GET['from']=="submission"){// back to submission
				header("Location: submission.php");
			}
		}
	}
	// if not successfully login, stay at this page
}  
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; //include the common head, contains metas and common css?>
		<title> Login</title>
		<link href="registration_ver1.css"  rel="stylesheet" type="text/css"/>
	</head>

	<body>
		<header>
			<h1>Login</h1>
		</header>
		<!-- header part, make the header of the page -->
		
		<?php include 'menu.inc.php'; ?>
		<!-- The login form
		User use their email and password to login-->
	  <div class="registration_form" >
		<form action="" method="POST"> <!-- post to this page-->
		  <label for ="useremail">User Email:</label><br/> 
		  <input type ="email" id="useremail" class= "type_input" name="useremail" placeholder="User Email Ex abc@abc.com"/><br/>
		  <label for="password">Password : </label><br/>
		  <input type="password" id="password" class= "type_input" name="password" placeholder="Password"><br/>
		   <input type="submit" name ="login" class ="button" value="Login">
		</form>
	  </div>
    <?php include 'footer.inc.php'; //include the footer ?>
	<!-- footer part of the page. It has a link can back to top of the page -->
</body>
	
</html>