<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.inc.php'; ?>
		<title> Welcome, Sign Here</title>
		<link href="registration_ver1.css"  rel="stylesheet" type="text/css"/>
		<script src ="registration_2.js"></script>
	</head>
	<!-- In head part
		Include head which use  two metas and commons.css file.
		One metas for characters, another for resizing the site when change to small size screen. 
		Insert registration_ver1.css file to control style for this page.
		Insert registration_2.js for validation input forms
		Also give this page a title.-->
	<body>
		<header>
			<h1>Sign up</h1>
		</header>
		<!-- header part, make the header of the page -->
		
		<?php include 'menu.inc.php'; //include the menu?>
		
	  <div class="registration_form" >
	  <!-- form named myform
	  will be checked at client side javascript validation
	  pass the clientside validation
	  the results will be posted to registration_process.php for server side validation-->
		<form  name ="myform" onsubmit ="return validateForm();" action="registration_process.php" method="POST">
		<!-- Start to insert the html form elements-->
		<?php
		$fields = array('email', 'username', 'password', 'birthday');// create an array contain 4 keywords
			foreach ($fields as $key) {  // this foreach loop will according the keyword to create 4 properate input field
				$type =$key; // type of the input
				$errorspan =$key; // error area
				$holder =ucfirst($key); // value of holder
				if(isset($_POST[ucfirst($key).'_1'])){ // if the input field value is posted, the name of each field is keyword concatenate with _1
					$value = htmlspecialchars($_POST[ucfirst($key).'_1']); // record the value and prepare to post the value to the input field
				}else{
					$value =""; // if value is not existed
				}
				if ($key =='username'){  // if the keyword is username, type is text
					$type ='text';
				}elseif($key =='birthday'){// if keyword is birthday, type is date,and have a special holder
					$type ='date';
					$holder ='mm/dd/yyyy';
				}
				echo '<label for ="'.$key.'">'.ucfirst($key).':</label><br/>';// create the label
				if(isset($errors[ucfirst($key).'_1'])){// if error exist, means already posted once, create field and insert the value to correspnding fields.
					echo '<input type ="'.$type.'" id="'.$key.'" class="type_input" style="border-color:red" name="'.ucfirst($key).'_1" placeholder="'.$holder.'" value="'.$value.'" /><br/>';
				}else{// if not posted, create the field
					echo '<input type ="'.$type.'" id="'.$key.'" class="type_input" name="'.ucfirst($key).'_1" placeholder="'.$holder.'" value="'.$value.'" /><br/>';
				}
				echo '<span id="'.$key.'_error_alert">';// create error span 
				if(isset($errors[ucfirst($key).'_1'])){
					echo $errors[ucfirst($key).'_1'];// post error for corresponding field
				}
				echo '</span><br/>';
			}
		?>
		  <fieldset><!-- radio buttons -->
		  <legend align="center">Gender:</legend>
			  <label for="male">Male</label>
			  <input type="radio" name="gender" id="male" value="male" class ="radio" <?php if(isset($_POST['gender'])){if($_POST['gender'] =="male"){echo 'checked';}} // if the value is alrady posted, check it ?>>
			  <label for="female">Female</label>
			  <input type="radio" name="gender" id="female" value="female" class ="radio" <?php if(isset($_POST['gender'])){if($_POST['gender'] =="female"){echo 'checked';}} // if the value is posted, check it?>><br/>
			   <span id="gender_error_alert">
			   	<?php
			   		if(isset($errors['gender'])){
						echo $errors['gender'];
					}// show the erros fo gender radios
			   	?>
			   </span><br/>
		  </fieldset>
		  <!-- Use radio type input to let user select their gender.
			   Contains all radio in one fieldset.
			   Give the fieldset a legend. -->
			What kinds of restaurant do you like?<br/>
			  <?php include 'type_selection.inc.php'; // include the type selection check box part?>
			   <span id="type">(optional)</span><br/>
			  <!-- Use checkbox type input to let user select one or more type for the restaurant.
					   What is the restaurant style.
					   Is the restaurant cheap or expensive.
					   Each one has own label, class, id, value. -->
			  <br/>
			  <input type="submit" class ="button" name="SubmitRegistration" value="Submit">
			  <!-- submit registration forms.-->
			  <input type="button" class ="button" value ="Cancel" onclick="history.go(-1);return true;">
			  <!-- back to previous page-->
		</form>
	  </div>
    <?php include 'footer.inc.php'; // include footer?>
	<!-- footer part of the page. It has a link can back to top of the page -->
</body>
	
</html>