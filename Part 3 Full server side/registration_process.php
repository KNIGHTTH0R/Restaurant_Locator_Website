<?php
//process the submited data of registration form
$errors =array();
if (isset($_POST['SubmitRegistration'])){ 
	require 'validation.php';// include the validation php which provide validtion functions
	if (($result =validateEmail( $_POST, 'Email_1')) !=false){ // if email has error
		$errors['Email_1']=$result; // store email error
	}
	if (($result =validateName( $_POST, 'Username_1')) !=false){ // if name has error
		$errors['Username_1']=$result; // store username error
	}
	if (($result =checkPassword( $_POST, 'Password_1')) !=false){ // if password has error
		$errors['Password_1']=$result;	// store password error
	}
	if (($result =checkBirthDate( $_POST, 'Birthday_1')) !=false){ // if birthday has error
		$errors['Birthday_1']=$result; // store birthday error
	}
	if (($result =checkGender( $_POST, 'gender')) !=false){
		$errors['gender']=$result;
	}

	if(count($errors)>0){// if error exists
		include 'registration.php';// include the registraion page, errors will be displayed to user, and the value should be saved 
	}else{
		require ('update.inc.php'); // require update php to update the values into users database
		$types ="";
		$choices =array('FastFood', 'Western', 'Chinese', 'Buffet', 'Expensive', 'Cheap'); // keywords for types
		foreach ($choices as $key) {
			if(isset($_POST[$key])){
				$types=$_POST[$key].','.$types; //gather the selected checkbox
			}
		}
		insertRegistration($_POST['Username_1'], $_POST['Email_1'], $_POST['Password_1'], $_POST['Birthday_1'], $_POST['gender'], $types);// call function to insert values
		header("Location: success.php?from=registration");// direct to success page, let user know they successfully register
	}
}
?>