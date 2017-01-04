<?php
//contain all server side validaiton function
// field_list is $_POST, which is an array
// $field_name is the key of the $_POST
// pattern is used to make sure the data can work correctly with whole system and prevent some attack
require ('search.inc.php');// include search inc php to get function to read database
function validateName($field_list, $field_name){// validate name input of registration,

	$pattern =' /^([a-zA-Z0-9]+(\s+[a-zA-Z0-9])?){2,50}$/';// patter of name, 2 to 50 number, letters and space
	$error=false;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){// if input is empty
			$error = 'Name is required';
			return $error;
		}elseif(!preg_match($pattern, $field_list[$field_name])){// don't match pattern
			$error = 'Pattern error, only accept 2 to 50 number letters and space';
			return $error;
		}elseif(checkExistName($field_list[$field_name])->rowCount()>0){// name is alredy be used
			$error = 'Name already existed';
			return $error;
		}
		return $error;
}

function validateEmail($field_list, $field_name){
// validate the input email of registration

$pattern =' /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,})+$/';// a common pattern of email, 
	$error=false;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){// if email is empty
			$error = 'Email is required';
			return $error;
		}elseif(!preg_match($pattern, $field_list[$field_name])){// if email doesn't match pattern 
			$error = 'Email pattern is wrong, ex. abc@mail.com';
			return $error;
		}elseif(checkExistEmail($field_list[$field_name])->rowCount()>0){// email is used
			$error ='Email is already used';
			return $error;
		}
		return $error;
}

function checkPassword($field_list, $field_name){
	// check the password
	$pattern ='/^[a-zA-Z0-9]{4,25}$/';// pattern, 4 to 25 letters and numbers
	$error=false;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){// if password is empty
			$error = 'Password is required';
		}elseif(!preg_match($pattern, $field_list[$field_name])){// if pattern doesn't match
			$error = 'Password only accept 4 to 25 letters and numbers';
		}
		return $error;
}

function checkBirthDate($field_list, $field_name){// check the birthday date
	$pattern1 ='/^\d{1,2}\/\d{1,2}\/\d{4}$/';//pattern 1 mm/dd/yyyy
	$pattern2 ='/^\d{4}\-\d{1,2}\-\d{1,2}$/';//pattern 2 yyyy-mm-dd
	$error=false;
	$separate;
	$mm;
	$dd;
	$yyyy;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){// if input is empty
			$error = 'Birthday is required';
			return $error;
		}
		if(preg_match($pattern1, $field_list[$field_name])){// match with pattern one
			$separate =explode("/",$field_list[$field_name]);// separate the string
		$mm=(int)$separate[0]; // assign value to mm, dd ,yyyy
		$dd=(int)$separate[1];
		$yyyy=(int)$separate[2];
		}elseif(preg_match($pattern2, $field_list[$field_name])){// match with pattern two
			$separate =explode("-",$field_list[$field_name]);//separate the string
		$mm=(int)$separate[1];// assignet to mm, dd, yyyy
		$dd=(int)$separate[2];
		$yyyy=(int)$separate[0];
		}
		else{
			$error = 'Please match mm/dd/yyyy pattern';
			return $error;
		}
		
		$dayofmonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);// the total number of days for different month
		if ($yyyy%400==0 || ($yyyy%4==0 && $yyyy%100 !=0 )){
		$dayofmonth[1] =29; // for the year which Feburary has 29th day.
		}
		if($yyyy <1000 || $yyyy>3000 || $mm <=0 || $mm >=13){//for radiculous input of year and month
			$error ="year or month value doesn't make sense";
			return $error;
		}
		if ($dd <=0 || $dd>$dayofmonth[$mm-1]){ // if the day value doesn't make sense 
		$error = "day value doesn't make sense";
		return $error;
		}
		return $error;
}

function checkGender($field_list, $field_name){// check the gender radio input
	$error =false;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){//if input is empty
			$error = 'Required to select one';
			return $error;
		}
	return $error;
}
//above is validaiton for user registration
//below is validation for object submission

function checkRestaurantName($field_list, $field_name){// check the restaurant name
	$pattern ='/^[a-zA-Z0-9_!,.?@#$^&:\'"()\/ ]{1,100}$/';// pattern  1 to 100 chacater with uper lower cases, number, and some specail character
	$error =false;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){// if input is empty
			$error = 'Restaurant Name is required';
			return $error;
		}
	if(!preg_match($pattern, $field_list[$field_name])){// inf pattern doesn't match
		$error = 'Only available for 1 to 100 characters, include upper lower letters, number, some special characters';
		return $error;
	}
	return $error;
}

function checkRestaurantLocation($field_list, $field_name){// validate location
	$pattern ='/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/';// pattern , postive or negatvie sign may exist before digits
	// 0 to 90 for latitude, 0 to 180 for longitude
	$error =false;
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){// if location is empty
			$error = 'Restaurant location is required';
			return $error;
		}
	if(!preg_match($pattern, $field_list[$field_name])){// if pattern fail
		$error = 'Pattern not match, example 40.0,-79.0';
		return $error;
	}
	return $error;
}

function checkRestaurantAddress($field_list, $field_name){// check address
	$pattern ='/^[a-zA-Z0-9_!,.?@#$^&:\'"()\/ ]{0,100}$/'; //pattern  0 to 100 chacater with uper lower cases, number, and some specail character
	$error =false;
	if(!preg_match($pattern, $field_list[$field_name])){// pattern fail
		$error = 'Only available for 0 to 100 characters, include upper lower letters, number';
		return $error;
	}
	return $error;
}

function checkDescription($field_list, $field_name){//check description
	$pattern ='/^[a-zA-Z0-9_!,.?@#$^&:\'"()\/ ]{0,500}$/';//pattern  0 to 500 chacater with uper lower cases, number, and some specail character
	$error =false;
	if(!preg_match($pattern, $field_list[$field_name])){// pattern fail
		$error = 'Only available for 0 to 500 characters, include upper lower letters, number, few special characters';
		return $error;
	}
	return $error;
}
?>