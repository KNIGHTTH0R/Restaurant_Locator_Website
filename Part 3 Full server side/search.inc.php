<?php
// this file include all the function to search database for all kind purposes
//used PDO and prepare
function search_page($name, $type){// find the restaurants database to find the restaurant base on name and type
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `restaurants` WHERE `RestaurantName` LIKE :Restaurant_Name AND `RestaurantType` LIKE :Restaurant_Type');
	if (strlen($name)>0){//bind the value
		$result->bindValue(':Restaurant_Name',"%".$name."%"); // find anything contains the name which is searching for
	}else{
		$result->bindValue(':Restaurant_Name',"%");// if name is empty, search everything
	}
	if ($type =="choose one"){
		$result->bindValue(':Restaurant_Type',"%");// search every type
	}else{
		$result->bindValue(':Restaurant_Type',"%".$type."%");// search  anything contains the type
	}
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	return $result;
}

function individual_page($idnumber){// find the restuarnt by the id value
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `restaurants` WHERE `ID` = :Restaurant_ID ');
	$result->bindValue(':Restaurant_ID', $idnumber);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	return $result;
}

function individual_reviews($idnumber){// find the reviews by the restaurant id
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `reviews` WHERE `Rid` = :Restaurant_ID ');
	$result->bindValue(':Restaurant_ID', $idnumber);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	return $result;
}

function LogincheckPassword($useremailinput, $password){// find the results based on email and hashed password,
	// for login part
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `users` WHERE `UserEmail` = :useremail AND `passwordhash` = SHA2(CONCAT(:password1,`salt`),0) ');
	// hash the input password
	$result->bindValue(':useremail', $useremailinput);
	$result->bindValue(':password1', $password);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	//return false;
	return $result;
}

function checkExistEmail($useremail){// check whether a email is exist in users database
	// error check for registration, prevent same email used to registration
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `users` WHERE `UserEmail` = :useremail');
	$result->bindValue(':useremail', $useremail);
	$result->execute();
	//return $result->rowCount()>0;
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	//return false;
	return $result;
}

function checkExistName($username){// check whether a name is exist
	// prevent same user name
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `users` WHERE `Username` = :username');
	$result->bindValue(':username', $username);
	$result->execute();
	//return $result->rowCount()>0;
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	//return false;
	return $result;
}

function searchRate($id, $name){//check the rating database, make user can't infinitely rate same project
	$result;
	$pdo = new PDO('mysql:host=localhost;dbname=restaurant','resadmin','1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{
	$result = $pdo->prepare('SELECT * FROM `rating` WHERE `Rid` = :id AND `Theuser` LIKE :username');
	$result->bindValue(':id', $id);
	$result->bindValue(':username', $name);
	$result->execute();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	return $result;
}
?>

