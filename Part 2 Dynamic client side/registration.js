function validateForm(){
	var namecheck = checkName(); // validate name
	var passcheck = checkPassword(); // validate password
	var emailcheck = checkEmail(); // validate email
	var gendercheck = checkGender(); // validate gender radio button
	var datecheck = checkDate(); // validate date
	// if any validation fail, the border of field become red, and a red explanation appear in html 
	if (namecheck && passcheck && emailcheck && gendercheck && datecheck){
		//pass all validations
		return true;
	}else{
		return false;
	}
}

function checkName(){// validate name
	var namepattern = /^([a-zA-Z]+(\s+[a-zA-Z])?){2,50}$/; 
/*	name pattern, between 2 to 50 character, only upper and lower letters allowed
    space are allowed between letters*/
	var name = document.forms["myform"]["UserName"].value; // get value from html
	if (name =="" || name ==null){ // if value is empty
		document.getElementById("username").style.borderColor ="red"; 
		document.getElementById("name_error_alert").innerHTML = "Name is required";
		return false;
	}else if(!namepattern.test(name)){ // if pattern is wrong
		document.getElementById("username").style.borderColor ="red";
		document.getElementById("name_error_alert").innerHTML = "Pattern error, only accept letters and space";
		return false;
	}
	else{ // close the alert and return true
		document.getElementById("username").style.borderColor ="gray";
		document.getElementById("name_error_alert").innerHTML = "";
		return true;
		
	}
	
}

function checkPassword(){ // validate password
	var passwordpattern = /^[a-zA-Z0-9]{4,25}$/; 
	/*
	password pattern, only 4 to 25 character of upper letter, lower letter and digit number are allowed
	*/
	var pass = document.forms["myform"]["Password"].value; // get value from html
	if (pass =="" || name ==null){ // handle the empty input
		document.getElementById("password").style.borderColor ="red";
		document.getElementById("password_error_alert").innerHTML = "Password is required";
		return false;
	}else if (!passwordpattern.test(pass)){ // check the pattern 
		
		document.getElementById("password").style.borderColor ="red";
		document.getElementById("password_error_alert").innerHTML = "Password only accept 4 to 25 letters and numbers";
		return false;
	}
	else{ // close the alert and return true
		document.getElementById("password").style.borderColor ="gray";
		document.getElementById("password_error_alert").innerHTML = "";
		return true;
	}
}

function checkEmail(){ // validate email
	var emailpattern =/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,})+$/;
	/*
	email pattern, at least one of (letters digits) also can contain dot before @, 
	after @ at least one letter or digits number before dot
	after dot, at least 2 from digit or letter
	*/
	var email = document.forms["myform"]["Email"].value;
	if (email =="" || email == null){ // handle the empty input
		document.getElementById("email").style.borderColor ="red";
		document.getElementById("email_error_alert").innerHTML = "Email is required";
		return false;
	}else if (!emailpattern.test(email)){ // check the pattern 
		document.getElementById("email").style.borderColor ="red";
		document.getElementById("email_error_alert").innerHTML = "Email pattern is wrong, ex. abc@mail.com";
		return false;
	}else{ // close the alert return true
		document.getElementById("email").style.borderColor ="gray";
		document.getElementById("email_error_alert").innerHTML = "";
		return true;
	}
}
function checkGender(){ // validate the radio button for gender
	
	var choose =""; // create variable
	var options = document.forms["myform"]["gender"]; // get value from html
	for (var i=0;i<options.length;i++){
		if (options[i].checked){ // if radio is clicked
			choose = options[i].value; // get the value 
		}
	}
	if (choose ==""){ // if raido is not checked
		document.getElementById("gender_error_alert").innerHTML = "Required to select one";
		return false;
	}else{ // close the alert and return true 
		document.getElementById("gender_error_alert").innerHTML = "";
		return true;
	}
}

function checkDate(){ //validate date 
	var datepattern= /^\d{1,2}\/\d{1,2}\/\d{4}$/; // date pattern mm/dd/yyyy
	var date = document.forms["myform"]["birthday"].value; // get value from html 
	if (date =="" || date==null){ // if input is empty 
		document.getElementById("bday").style.borderColor ="red";
		document.getElementById("date_error_alert").innerHTML = "Birthday is required";
		return false;
	}else if (!datepattern.test(date)){ // doesn't match with pattern 
		document.getElementById("bday").style.borderColor ="red";
		document.getElementById("date_error_alert").innerHTML = "Please match mm/dd/yyyy pattern";
		return false;
	}
	
	var separate = date.split("/"); // split mm/dd/yyyy to different variable 
	var mm = parseInt(separate[0]); //month 
	var dd = parseInt(separate[1]); // day
	var yyyy = parseInt(separate[2]); //year 
	
	if (yyyy <1000 || yyyy>3000 || mm <=0 || mm >=13){ // if one of the value of year or month doesn't make sense 
		document.getElementById("bday").style.borderColor ="red";
		document.getElementById("date_error_alert").innerHTML = "year or month value doesn't make sense";
		return false;
	}
	var dayofmonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // each month have different number of days
	if (yyyy%400==0 || (yyyy%4==0 && yyyy%100 !=0 )){
		dayofmonth[1] =29; // Feburary has 29th day.
	}
	if (dd <=0 || dd>dayofmonth[mm-1]){ // if the day value doesn't make sense 
		document.getElementById("bday").style.borderColor ="red";
		document.getElementById("date_error_alert").innerHTML = "day value doesn't make sense";
		return false;
	}else{ // clean the alert and return true 
		document.getElementById("bday").style.borderColor ="gray";
		document.getElementById("date_error_alert").innerHTML = "";
		return true;
	}
}