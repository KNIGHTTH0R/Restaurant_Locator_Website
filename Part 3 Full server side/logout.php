<?php
session_start();// start session
unset($_SESSION['isLoggedIn']); // clean the login session, session value of isLoggedIn not exist
unset($_SESSION['user_name']); // clean the user name
// identify where coming from and back to previous page
if (isset($_GET['from'])){// if has the information of prvious page
			if($_GET['from']=="search"){// back to search page
				header("Location: search.php");
			}elseif($_GET['from']=="results"){// back to result_sample page, still has same results
				$searchname=$_GET['searchname'];
				$searchtype=$_GET['searchtype'];
				$haveUserlocation=$_GET['haveUserLocation'];
				header("Location: results_sample.php?searchname=$searchname&searchtype=$searchtype&haveUserLocation=$haveUserlocation");
			}elseif($_GET['from']=="individual"){// back to individual result page, and still has same results
				header("Location: individual_sample.php?id=".$_GET['id']);
			}
		}
?>
