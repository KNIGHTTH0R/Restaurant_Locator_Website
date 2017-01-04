var user_lat;
var user_lng;
var fill = false;
var locations = []; // prepare a locations array to contain one or more coordinates.
var contents = []; // array for infowindow
var hasUserLocation; // boolean, define whether user location information exist 
var createMap = false;
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
	 hasUserLocation = true; // user search by location
	 if (fill){ // when need to jump to result page
		 document.getElementById("setlocation").value=user_lat+","+user_lng; // upload curren location to the input field of locations 
		 // use these when user exactly inside the restaurant
	 }else{
	 	var coordinate = {lat:user_lat, lng:user_lng}; // current location coordinates
		locations.push(coordinate); // insert user location into location array
		var user_location_content = '<div id = "content">' +
		'<h1> Your Location </h1>' +
		'<p> This is your location </p>' +
		'</div>'; // user's current location information
		contents.push(user_location_content);// insert into content array
		createMap=true;// true to create map
		initMap();// continue to create map
	 }
}
function generalSearch(){
	hasUserLocation = false; // user don's search arround their location 
	createMap = true;
	initMap();// continue to create map
}
function updateLocation(){ // let users quickly update their location to submission where they are inside the restaurant
	fill=true;
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

function readin(){// read the data saved from results_sample.php
		for (var j=0;j<locationarrayFromPhp.length;j++){// get each group of latitude  and longtitude
			var slat = Number(locationarrayFromPhp[j].split(",")[0].trim());
			var slng = Number(locationarrayFromPhp[j].split(",")[1].trim());
			var coordinate = {lat:slat, lng:slng};
			locations.push(coordinate); // insert user location into location array
			var restaurant_content = String(connectarrayFromPhp[j].trim());// get the content of the each location
			contents.push(restaurant_content);// insert into content array
		}
}
// identify whehter user current location is necessary
function defineUser(){
	if (!noresultFromPhp){
			if(aroundUserFromPhp){	
				getLocation();
			}else{
				generalSearch();
			}
		}
}
function initMap() {// create map

			
			if (!createMap){// stop and define user's choice
				defineUser();
			}else{// continue to create map
			
			readin();// get data from php
			/*
			Create Map, center is the user location, and zoom level is 14, can see the street
			*/
			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 14,
			  center: locations[0] // if user location exist, center the user location, if no user location exist, center the first result
			});  
		
			var infowindow = new google.maps.InfoWindow(); // create infowindow
			var marker; // create marker variable
			
			for (var i=0;i<locations.length;i++){ // create all markers in a loop
				if (i==0 && hasUserLocation){ // user information if need
						  marker = new google.maps.Marker({
						  position: locations[i],
						  map: map,
						  icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png', // blue marker for user 
						  title:"Your Location" // title of user marker
						});
						
						
				}else{
						marker = new google.maps.Marker({ // marker for results, color is red 
						  position: locations[i],
						  map: map, 
						  title:"Restaurant" // restaurant result title
						});
				}
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
						  infowindow.setContent(contents[i]); // set the information of infowindow
						  infowindow.open(map, marker); // connect infowindow to marker
						}
					  })(marker, i));
			}
			var getCurrent_Center = map.getCenter();// get the current center of the map
			google.maps.event.addDomListener(window, 'resize', function() { // resize the map and keep lock the map at the center when the container is resizing
				map.setCenter(getCurrent_Center);
			});		
			}			
}

