<?php
//create error array
$errors =array();
if (isset($_POST['submitPost'])){// if input is posted
	$target_dir = "img/"; //for local storage
	$rename= sha1($_GET['user']);// get user name and hash it
	$date = date_create();	// create timestamp
	$date =date_timestamp_get($date);
	$target_file = $target_dir .$date. $rename.basename($_FILES["myImage"]["name"]); //for xampp local 
	//$target_file = $date.$rename.basename($_FILES["myImage"]["name"]);// create new image file name timestamp+hashed user naem +original name
	$uploadOk = 0;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);// get the image type 
	
	if ($_FILES["myImage"]["error"]==4){// if file is empty, don't upload
		 $uploadOk = 0;
	}
	// Check if image file is a actual image or fake image
	if(isset($_POST["submitPost"]) && $_FILES["myImage"]["error"]!=4) {//if file input is not empty
		    $check = getimagesize($_FILES["myImage"]["tmp_name"]);//check the file type
		    if($check !== false) {// check pass, available to upload
		        $uploadOk = 1;
		    } else {// not pass, can't uplaod
		        $errors['myImage'] = "File is not an image.";// error message for image
		        $uploadOk = 0;
		    }

		    if (file_exists($target_file)) {// check whether file is existed, very unlikely
		    $errors['myImage'] = "Sorry, file already exists.";// error message
		    $uploadOk = 0;
		}

		// check extension name, only jpg file, png file, jpeg file, gif file are availble
		if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
		&& strtolower($imageFileType) != "gif" ) {
		    $errors['myImage'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";//error message
		    $uploadOk = 0;
		}
	
	}

	// Check if file already exists
	
	// include validation php to get validation function
	require 'validation.php';
	if (($result =checkRestaurantName( $_POST, 'Restaurant_Name')) !=false){// check name
		$errors['Restaurant_Name']=$result; // error message
	}
	if (($result =checkRestaurantLocation( $_POST, 'Restaurant_Location')) !=false){// check location 
		$errors['Restaurant_Location']=$result; // error message
	}
	if (($result =checkRestaurantAddress( $_POST, 'Restaurant_Address')) !=false){// check address
		$errors['Restaurant_Address']=$result; //error message
	}
	if (($result =checkDescription( $_POST, 'Description')) !=false){// check description
		$errors['Description']=$result; // error message
	}


	if(count($errors)>0){// if error exist
	    if (!isset($errors['myImage'])){
	    	$errors['myImage'] = "Please upload again if you want";
	    	// if no other error with image file 
	    	// remind user to reupload, since the old file will be erased after validation 
	    }
		include 'submission.php';// include the submissioin php to let user continue and fix their submission
	}else{// if no error happen
		require ('update.inc.php');// include update php to get function update or insert value into database
		if($uploadOk ==1){// allowed to upload
		move_uploaded_file($_FILES["myImage"]["tmp_name"], $target_file); //xampp local 
		
		}
		// get the type user checked, concatenate all to one string
		$types ="";
		$choices =array('FastFood', 'Western', 'Chinese', 'Buffet', 'Expensive', 'Cheap');
		foreach ($choices as $key) {
			if(isset($_POST[$key])){
				$types=$_POST[$key].','.$types;
			}
		}
		$url=null;// initiate the url of image
		if($uploadOk==1){// if need to upload something
		$url =$target_file;// create address for fetching file
	}
	//insert everything into restaurant database, create a new object
		insertSubmission($_GET['user'], $_POST['Restaurant_Name'], $_POST['Restaurant_Location'], $_POST['Restaurant_Address'], $types, $_POST['Description'], $url);
		header("Location: success.php?from=submission");// redirect to success page to tell user their finish submission
	}
}
?>