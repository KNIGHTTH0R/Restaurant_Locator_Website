var user_lat;
var user_lng;
var jump = true;
function getLocation() { // Html5 Geolocation API, used to locate the user current's location.
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(currentLocation, showError);
		// get the current location of user and initiated the living map at same time.
		// Handle the errors by alert the user.
	} else {
		window.alert(getElementById("status").innerHTML="Geolocation is not supported by this browser.");
		// Handle the errors by alert the user.
	}
}
function currentLocation(position){
	 user_lat = position.coords.latitude; // get the current latitude and store in local
	 user_lng = position.coords.longitude; // get the current longitude and store in lacal
	 var user_getlocation = true; // user search by location
	 if (jump){ // when need to jump to result page
	 sessionStorage.setItem('lat', JSON.stringify(user_lat)); // store the value of lat, and give it to results page and mapping.js for creating map
	 sessionStorage.setItem('lng', JSON.stringify(user_lng)); // store the value of lng, and give it to results page and mapping.js for creating map 
	 sessionStorage.setItem('bool', JSON.stringify(user_getlocation)); // store the boolean value, give it to results page and mapping.js for creating map 
	 window.location.href="results_sample.html"; // jump to result page
	 }else{
		 document.getElementById("setlocation").value=user_lat+","+user_lng; // upload curren location to the input field of locations 
		 // use these when user exactly inside the restaurant
	 }
}

function generalSearch(){
	var user_getlocation = false; // user don's search arround their location 
	sessionStorage.setItem('bool', JSON.stringify(user_getlocation)); // tell the information to mapping.js don't need to care about user location
	window.location.href="results_sample.html"; // jump to result
}
function updateLocation(){ // let users quickly update their location to submission where they are inside the restaurant
	jump=false;
	getLocation();// use the geolocation API
	
}
/*
Handle possible errors
*/
function showError(error) {
	switch(error.code) {
		case error.PERMISSION_DENIED:
			window.alert( "User denied the request for Geolocation.");
			break;
		case error.POSITION_UNAVAILABLE:
			window.alert( "Location information is unavailable.").
			break;
		case error.TIMEOUT:
			window.alert( "The request to get user location timed out.")
			break;
		case error.UNKNOWN_ERROR:
			window.alert( "An unknown error occurred.")
			break;
	}
}