<?php
	session_start();
	//start session
	?>
<?php
	require("search.inc.php"); //include the serach inc php to read database
	$result;
	$boolofuserlocation=false; // false if unser choose don't show result around their current location, true for user choose to show the location on map
			if(isset($_POST['aroundUser']) || (isset($_GET['haveUserLocation']) && $_GET['haveUserLocation'])){// if user choose to user their locaiton
				$boolofuserlocation=true;
				echo '<script>var aroundUserFromPhp = ' . json_encode($boolofuserlocation) . ';</script>';// store the bool into javascript
			}elseif (isset($_POST['notAround']) || (isset($_GET['haveUserLocation']) && !$_GET['haveUserLocation'])){// user choose not to use their location
				echo '<script>var aroundUserFromPhp = ' . json_encode($boolofuserlocation) . ';</script>';
			}
	$GLOBALS['haveUserLocation'] = $boolofuserlocation;// store the boolean into global for later php block

	if(isset($_POST['searchbyname']) && isset($_POST['searchbytype'])){// get the value posted from search.php
		$searchname=$_POST['searchbyname'];
		$searchtype=$_POST['searchbytype'];
		$haveUserlocation=$boolofuserlocation;
		header("Location: results_sample.php?searchname=$searchname&searchtype=$searchtype&haveUserLocation=$haveUserlocation");
		// redirect to this page and carray the values restaurant name and type
	}elseif(isset($_GET['searchname']) && isset($_GET['searchtype'])){
		$result = search_page($_GET['searchname'], $_GET['searchtype']);// use the name and type of restaurant to seach database
	}
	$i=0;
	$locations=array();//array prepare to store location informations of each object
	$contents=array();// array prepare to store content of each object. 
	if($result ->rowCount()>0){// data exists
	foreach ($result as $key) {// fetch out each selected row in database
		$locations[$i]=$key['Location'];//get location
		$contents[$i]='<div id = "content">'.
					'<h1>'.$key['RestaurantName'] .'</h1>'.
					'<p> rate: '.$key['rating'].'</p>'.
					'<p> <a href="individual_sample.php?id='.$key['ID'].'">See more details by clicking here</a> </p>'.
					'</div>';// get details and make them to a big information, store into content, it is used to fill the content of markers on live map
		$i++; // increment of i, used to manage array
	}
	echo '<script>var locationarrayFromPhp = ' . json_encode($locations) . ';</script>';// store locations into javascript
	echo '<script>var connectarrayFromPhp = ' . json_encode($contents) . ';</script>';// store connent into javascript
	$noresult =false;
	echo '<script>var noresultFromPhp = ' . json_encode($noresult) . ';</script>';// store bool into javascript, tell the map api to generate map
}else{
	$noresult =true;// no results tell the map api don't draw map
	echo '<script>var noresultFromPhp = ' . json_encode($noresult) . ';</script>';
	$GLOBALS['noresult'] = true;
}
	
	//$location_json = json_encode($locations);
	
	//echo $location_json;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; ?>
		<title> Search Results</title>
		<link href="results_ver1.css"  rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="location_and_map_3.js"></script>
		
	</head>
	<!-- In head part, 
	    Include head which use  two metas and commons.css file.
		One metas for characters, another for resizing the site when change to small size screen. 
		Insert result_ver1.css file to control style for this page.
		Insert the living map by location_and_mapping_3.js
		Also give this page a title.-->
		
		<body>
		<header>
			<h1>Results</h1>
			<div class ="log">
			<?php
			// not login, open login and singup
			// carray information , after login  keep same result
			if (!isset($_SESSION['isLoggedIn'])){
				echo '<a href="login.php?from=results&searchname='.$_GET['searchname'].'&searchtype='.$_GET['searchtype'].'&haveUserLocation='.$GLOBALS['haveUserLocation'] .'"><strong>Log in</strong></a>';
				echo '/';
				echo '<a href="registration.php"><strong>Sign Up</strong></a>';
			}else{// after login, show user name,and logout, carray information, after logout have same result
				echo '<span>Welcome,'.$_SESSION['user_name'].'. </span>';
				echo '<a href="logout.php?from=results&searchname='.$_GET['searchname'].'&searchtype='.$_GET['searchtype'].'&haveUserLocation='.$GLOBALS['haveUserLocation'] .'"><Strong>Logout</strong></a>';
			}
			?>
			</div>
		</header>
		<!-- Create the header for this page, Post Restaurant.
			 Also create log in and sign up links, while login is a sample link and sign up links to the registration.php page. -->
		
		<?php include 'menu.inc.php'; //include menu?>
		
		<div class = "result_list">
			<div id="map" >
				<?php
					if(isset($GLOBALS['noresult']) && $GLOBALS['noresult']){
						// if no results, give the message
						echo '<h2>No results found, please try another search</h2>';
					}
				?>
				<!-- map api -->
				<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg2biupOk_V13n7RR1guoiWfUfDuK79to&callback=initMap">
				</script>
				<!-- create a living map which include user location and the search result -->
			</div>
			<div class ="table">
			<!--create a table -->
				<table>
					<tr id="general_infomation">
						<th id="name">Restaurant Name</th>
						<th id="type">Type</th>
						<th id="rates">Likes</th>
						<th id="links"></th>
					</tr>
					
					
					<?php
							$result;
							//genearte table depends on the searching result
							$result = search_page($_GET['searchname'], $_GET['searchtype']);
							if ($result->rowCount()>0){// if data exists
							foreach ($result as $restaurant) {
								echo "<tr>";
								echo '<th>'.$restaurant['RestaurantName'].'</th>';// restaurant name
								echo '<th>'.$restaurant['RestaurantType'].'</th>';// type
								echo '<th>'.$restaurant['rating'].'</th>';//rating
								echo '<th><a href="individual_sample.php?id='.$restaurant['ID'].'">details</a></th>';//link to see details
								 echo "</tr>";
							}
						}
					   
					?>
				</table>
			</div>
		</div>
		<!-- There use table tag to create a sample result table.
		4 cols in total and represent restaurant name, type, rating and link respectively.
		First row is the title.
		 -->
	
		<?php include 'footer.inc.php'; //include footer?>
		<!-- footer part of the page. It has a link can back to top of the page -->
	</body>
	
	
</html>