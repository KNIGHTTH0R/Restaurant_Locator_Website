<?php
// all function which connect to database, update or insert value
// used PDO and prepare function
function updatecomment($idnumber, $ownname, $comments){// insert comment of object into reviews database
	//inputs restaurant id, user name, and content of comments
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('INSERT INTO `reviews` values (:id, :name, :comment)');
	$result->bindValue(':id', $idnumber);
	$result->bindValue(':name', $ownname);
	$result->bindValue(':comment', $comments);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

function updaterates($idnumber, $choice){// rating of an object
	// input is the restuarnt id and rate choice
	// use id to find the corresponding restaurant, and depends on choice rating +1 or -1
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$value;
	if($choice == "Like"){
		$value =1;
	}else{
		$value =(-1);
	}
	$result = $pdo->prepare('UPDATE `restaurants` SET `rating` =`rating`+:value WHERE `ID` =:id');
	$result->bindValue(':id', $idnumber);
	$result->bindValue(':value', $value);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

function insertRegistration($Name, $Email, $Password, $Birthday, $Gender, $Type){// insert a new user into users databse
	// input has name, email, password, birthdya, gender, favoriate food type
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
		$Salt=bin2hex(openssl_random_pseudo_bytes(20));// generate a random string to make a salt
		$result = $pdo->prepare('INSERT INTO `users` VALUES (:name, :email, SHA2(CONCAT(:password, :salt ),0), :salt, :bday, :gender, :type)');
		// hash the password by salt, and save it to database
		$result->bindValue(':name', $Name);
		$result->bindValue(':email', $Email);
		$result->bindValue(':password', $Password);
		$result->bindValue(':salt', $Salt);
		$result->bindValue(':bday', $Birthday);
		$result->bindValue(':gender', $Gender);
		$result->bindValue(':type', $Type);
		$result->execute();
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}

function insertSubmission($poster, $name, $location, $address, $type, $description, $image){// insert a new object into restaurants database
	// inputs have owner of the post, name of restaurant, location, address, majority type, description, S3 url for image file
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('INSERT INTO `restaurants` (`ownername`, `RestaurantName`, `Location`, `Addresss`, `RestaurantType`, `Description`, `PicturePath`) VALUES (:poster, :name, :location, :address, :type, :description, :image)');
		$result->bindValue(':poster', $poster);
		$result->bindValue(':name', $name);
		$result->bindValue(':location', $location);
		$result->bindValue(':address', $address);
		$result->bindValue(':type', $type);
		$result->bindValue(':description', $description);
		$result->bindValue(':image', $image);
		$result->execute();
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}

function createRate($id, $name){// create a row in rating database which relate with user and restaurant
	// input is restaurant id and user name
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('INSERT INTO `rating` (`Rid`, `Theuser`) VALUES (:id, :name)');
		$result->bindValue(':id', $id);
		$result->bindValue(':name', $name);
		$result->execute();
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}
function modifyratingrate($id, $name, $choice){// update to rating database
	// input restaurant id , user name, and choice of rating
    $pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$value;
	if($choice == "Like"){// if like, +1
		$value =1;
	}else{// dislike, -1
		$value =(-1);
	}
	$result = $pdo->prepare('UPDATE `rating` SET `rate` =`rate`+:value WHERE `Rid` =:id AND `Theuser` LIKE :name');
	$result->bindValue(':id', $id);
	$result->bindValue(':name', $name);
	$result->bindValue(':value', $value);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}
?>